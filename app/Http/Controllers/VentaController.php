<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreVentaRequest;
use Illuminate\Http\Request;
use App\Models\Venta;
use Carbon\Carbon; //Esto usado en el filtro de fechas

use function Laravel\Prompts\table;

class VentaController extends Controller
{

    public function index()
    {
        $venta = Venta::with(['usuario'])->get();
        return $venta;
    }



    public function store(StoreVentaRequest $request)
    {



        $datosValidos = $request->validated();

        DB::transaction(function () use ($datosValidos, $request) { //envuelvo todo en una transaccion para que se carguen loso registros
            $venta = Venta::create($datosValidos);                 //de manera simultanea y si ocurre un error no se cargue el de venta antes 
            foreach ($request->productos as $producto) {           //que el de venta_productos
                DB::table('venta_producto')->insert([
                    'id_venta' => $venta->id_venta,
                    'id_producto' => $producto['id_producto'],
                    'cantidad' => $producto['Cantidad'],
                    'iva' => $producto['IVA']
                ]);

                DB::table('stock')->insert([
                    'cantidad'=> -$producto['Cantidad'],
                    'tipo' => "Venta",
                    'id_producto' => $producto['id_producto'],
                    'id_venta' => $venta->id_venta,
                    'id_sucursal' => $venta->id_sucursal
                ]);
            }
            $venta->save();
            return response()->json(['message' => 'Venta realizada exitosamente'], 201);
        });
    }


    public function show(string $id)
    {

        $venta = DB::table('venta')
            ->where('venta.id_venta', $id)
            ->leftJoin('venta_producto', 'venta.id_venta', '=', 'venta_producto.id_venta')
            ->leftJoin('producto', 'venta_producto.id_producto', '=', 'producto.id_producto')
            ->leftJoin('descuento', 'producto.id_descuento', '=', 'descuento.id_descuento')
            ->select(
                'venta.id_venta',
                DB::raw('json_agg(json_build_object(
                 \'codigo\', producto.codigo,
                 \'producto\',producto.producto,
                 \'costo\',TO_CHAR(producto.costo, \'FM999999999.00\'),
                 \'cantidad\',venta_producto.cantidad,
                 \'iva\',venta_producto.iva,
                 \'descuento_porcentaje\',descuento.porcentaje
                  )) as productos')
            )
            ->groupBy('venta.id_venta')
            ->first();

        if ($venta)
            $venta->productos = json_decode($venta->productos);
        else return response()->json(['error' => 'Venta no encontrada'], 404);

        return response()->json($venta);
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }

    public function filtro(Request $request)
    {


        $where = Venta::with('usuario');


        if ($request->metodo_pago != null)
            $where = $where->where('metodo_pago', strtolower($request->metodo_pago));

        if ($request->periodo_ventas != null && ($request->periodo_ventas === "Ver ventas desde el") && (
            $request->fecha_desde != null && $request->fecha_hasta != null)) {
            $fecha_desde = Carbon::parse($request->fecha_desde)->startOfDay(); //toma la fecha desde el comienzo del dia
            $fecha_hasta = Carbon::parse($request->fecha_hasta)->endOfDay(); //toma la fecha hasta el final del dia
            $where = $where->whereBetween('fecha', [$fecha_desde, $fecha_hasta]);
        }

        if ($request->periodo_ventas != null && ($request->periodo_ventas === "Ventas del mes de") && (
            $request->mes_venta != null && $request->anio_venta != null)) {
            $mes = $request->mes_venta;
            $anio = $request->anio_venta;

            $where = $where->whereYear('fecha', $anio)->whereMonth('fecha', $mes);
        }




        return $where->get();
    }



    public function obtenerAnios()
    {
        return ("ok");
        $anios = DB::table('venta')
            ->select(DB::raw('DISTINCT EXTRACT (YEAR from fecha) as anio'))
            ->orderBy('anio')
            ->pluck('anio');

        return response()->json($anios);
    }
}
