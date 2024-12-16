<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComboRequest;
use App\Http\Requests\UpdateComboRequest;
use App\Models\Combo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ComboController extends Controller
{

    public function index()
    {
        $combo = DB::table('combo')
            ->leftJoin('combo_producto', 'combo.id_combo', '=', 'combo_producto.id_combo')
            ->leftJoin('producto', 'combo_producto.id_producto', '=', 'producto.id_producto')
            ->select(
                'combo.id_combo',
                'combo.codigo',
                'combo.nombre',
                'combo.costo',
                'combo.duracion',
                DB::raw('json_agg(json_build_object(
                \'producto\',producto.producto,
                \'cantidad\',combo_producto.cantidad
                )) as productos')
            )
            ->groupBy('combo.id_combo')
            ->get();

        // Decodificar la cadena JSON del array productos
        $combo = $combo->map(function ($item) {
            $item->productos = json_decode($item->productos);
            return $item;
        });


        return response()->json($combo);
    }


    public function store(StoreComboRequest $request)
    {
        $datosValidos = $request->validated();

        DB::transaction(function () use ($datosValidos, $request) { //envolvemos todo en una transaccion para que se haga tanto 
            //la creacion del combo como el registro en la tabla combo_producto
            $combo = Combo::create($datosValidos);

            $productos = $request->input('productos', []); //obtenemos el array productos del request

            foreach ($productos as $producto) { //para cada uno de los productos del array, los vinculo con el id_combo creado
                DB::table('combo_producto')->insert([
                    'id_combo' => $combo->id_combo,
                    'id_producto' => $producto['id_producto'],
                    'cantidad' => $producto['cantidad']
                ]);
            }
        });

        return response()->json(['message' => 'Combo creado exitosamente'], 201);
    }


    public function show(string $id)
    {

        $combo = DB::table('combo')
            ->where('combo.id_combo', $id)
            ->leftJoin('combo_producto', 'combo.id_combo', '=', 'combo_producto.id_combo')
            ->leftJoin('producto', 'combo_producto.id_producto', '=', 'producto.id_producto')
            ->select(
                'combo.es_combo',
                'combo.codigo',
                'combo.id_combo',
                'combo.nombre',
                'combo.costo',
                'combo.duracion',
                DB::raw('json_agg(json_build_object(
                \'producto\',producto.producto,
                \'id_producto\',producto.id_producto,
                \'cantidad\',combo_producto.cantidad
                )) as productos')
            )
            ->groupBy('combo.id_combo')
            ->first();

        // Decodificar la cadena JSON del array productos
        if ($combo)
            $combo->productos = json_decode($combo->productos);
        else return response()->json(['error' => 'Combo no encontrado'], 404);

        return response()->json($combo);
    }

    public function update(UpdateComboRequest $request, string $id)
    {
        //PRIMERO HAGO LAS VALIDACIONES PARA NO INGRESAR UN CODIGO/NOMBRE QUE YA ESTE EN LA TABLA (SIN CONTAR AL QUE ESTOY PASANDO)
        if (Combo::where('codigo', $request->codigo)->where('id_combo', '!=', $id)->exists()) {
            return response()->json([
                'message' => 'El código ya está en uso por otro combo.',
            ], 422);
        }

        if (Combo::where('nombre', $request->nombre)->where('id_combo', '!=', $id)->exists()) {
            return response()->json([
                'message' => 'El nombre del combo ya está en uso por otro.',
            ], 422);
        }
        $datosValidos = $request->validated();
    

        $combo = Combo::findOrFail($id);
        $combo->update($datosValidos);

        return response()->json([
            'message' => 'Combo actualizado exitosamente',
            'producto' => $combo
        ], 200);
    }

    public function destroy(string $id)
    {
        //
    }


    public function filtro(Request $request)
    {

        $where = DB::table('combo')
            ->leftJoin('combo_producto', 'combo.id_combo', '=', 'combo_producto.id_combo')
            ->leftJoin('producto', 'combo_producto.id_producto', '=', 'producto.id_producto')
            ->select(
                'combo.id_combo',
                'combo.codigo',
                'combo.nombre',
                'combo.costo',
                'combo.duracion',
                DB::raw('json_agg(json_build_object(
            \'producto\',producto.producto,
            \'cantidad\',combo_producto.cantidad
            )) as productos')
            )
            ->groupBy('combo.id_combo');



        if (($request->busqueda && ($request->tipo === "Combo")) != null) {
            $where = $where->whereRaw('nombre LIKE ?', ['%' . strtolower($request->busqueda) . '%']);
        }





        $result = $where->get();

        // Decodificar productos antes de enviar la respuesta
        $result->transform(function ($item) {
            $item->productos = json_decode($item->productos);
            return $item;
        });

        return response()->json($result);
    }

    public function buscar (Request $request){
        $termino = $request->termino;
        $tipoBusqueda = $request->tipoBusquedaCombo;
    
    
        if($tipoBusqueda!=null && $tipoBusqueda=== 'Nombre'){
          $resultados = Combo::whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($termino) . '%'])
          ->get();
        }
        if($tipoBusqueda!=null && $tipoBusqueda=== 'Codigo'){
          $resultados = Combo::whereRaw('LOWER(codigo) LIKE ?', ['%' .strtolower($termino). '%'])
          ->get();
        }
    
    
        return response()->json($resultados);
      }
}
