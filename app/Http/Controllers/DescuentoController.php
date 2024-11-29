<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDescuentoRequest;
use App\Http\Requests\UpdateDescuentoRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\Descuento;
use Illuminate\Support\Facades\DB;

class DescuentoController extends Controller
{

    public function index()
    {
        $descuento = Descuento::Join('producto', 'descuento.id_descuento', '=', 'producto.id_descuento')
            ->select(
                'descuento.id_descuento',
                'producto.producto',
                'producto.costo',
                'descuento.porcentaje',
                'descuento.duracion'
            )
            ->get();
        return $descuento; // Devuelve todos los descuentos
    }

    public function store(StoreDescuentoRequest $request)
    {
        $datosValidos = $request->validated();


        DB::transaction(function () use ($datosValidos, $request) { //envuelvo todo en una transaccion para que se carguen los registros
            //de manera simultanea 

            $idProducto = $request->id_producto; //obtenemos el id_producto recibido en el request

            $producto = DB::table('producto')->where('id_producto', $idProducto)->first(); //Verificamos de que el producto no tenga descuento previo
            if ($producto && $producto->id_descuento) { //preguntamos si id_descuento no es nulo
                return response()->json([
                    'error' => 'Este producto ya tiene un descuento asignado y no puede tener más de uno.'
                ], 422);
            }

            $descuento = Descuento::create($datosValidos); //Creamos el descuento

            DB::table('producto')
                ->where('id_producto', $idProducto)
                ->update(['id_descuento' => $descuento->id_descuento]);


            return response()->json($descuento, 201);
        });
    }




    public function show(string $id)
    {
        $descuento = DB::table('descuento')
        ->where('descuento.id_descuento', $id)
        ->join('producto', 'descuento.id_descuento', '=', 'producto.id_descuento')
        ->select(
            'descuento.id_descuento',
            DB::raw("INITCAP(producto.producto) as producto"), // Convierte a mayúscula la primera letra de cada palabra
            'producto.costo',
            'descuento.porcentaje',
            'descuento.duracion'
        );
        
        return $descuento->first(); // Devuelve todos los descuentos
    }


    public function update(UpdateDescuentoRequest $request, string $id)
    {
       
        $datosValidos = $request -> validated();
        $descuento = Descuento::findOrFail($id);
        $descuento->update($datosValidos);
    
        return response()->json([
          'message' => 'descuento actualizado exitosamente',
          'descuento' => $descuento
        ], 200);

    }

    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) { //Para que la eliminacion y actualizacion del prodcuto a descuento->null sea simultanea
            $descuento = Descuento::find($id); //busco el elemento

            if (!$descuento) { //si no encuentro el descuento
                return response()->json([
                    'error' => 'Descuento no encontrado'
                ], 404);
            }

            DB::table('producto')  //Si el descuento existe, busca el prodcuto al que pertenece y el prodcuto_descuento setea a null
                ->where('id_descuento', $id)
                ->update(['id_descuento' => null]);

            $descuento->delete(); //se elimina el descuento

        });

        return response()->json(['message' => 'Descuento eliminado'], 200);
    }

    public function filtro(Request $request)
    {

        $where = Descuento::Join('producto', 'descuento.id_descuento', '=', 'producto.id_descuento')
            ->select(
                'descuento.id_descuento',
                'producto.producto',
                'producto.costo',
                'descuento.porcentaje',
                'descuento.duracion'
            );


        if (($request->busqueda && ($request->tipo === "Producto")) != null) {
            $where = $where->whereRaw('producto LIKE ?', ['%' . strtolower($request->busqueda) . '%']);
        }

        


        return $where->get();
    }
}
