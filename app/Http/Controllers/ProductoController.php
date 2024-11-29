<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Proveedor;

class ProductoController extends Controller
{

  public function index()
  {
    //  return Producto::all(); // Devuelve todos los productos
    /*
      $productos = DB::table('producto')
          -> leftJoin('stock','producto.id_producto','=','stock.id_producto')
          -> select(
            'producto.*',
            DB::raw('COALESCE(SUM(stock.cantidad), 0) as stock')
          )
          ->groupBy('producto.id_producto')
          ->get();
          return response()->json($productos);*/
    $productos = Producto::leftJoin('stock', 'producto.id_producto', '=', 'stock.id_producto')
      ->select(
        'producto.*',
        DB::raw('COALESCE(SUM(stock.cantidad), 0) as stock')
      )
      ->groupBy('producto.id_producto')
      ->get();

    return $productos;
  }



  public function store(StoreProductoRequest $request)
  {
    $datosValidos = $request->validated();


    $producto = Producto::create($datosValidos);

    //otra forma  es con el fill
    //$producto = new Producto();
    //$producto->fill($datosValidos);
    //aqui puedo agregar otros campos que no estan dentro de $datosValidos


    $producto->save();
    return ($producto);
  }




  public function show($id)
  {/*
        $producto = Producto::select(
                'producto.*',
                DB::raw('COALESCE(SUM(stock.cantidad), 0) as stock'),
                'categoria.nombre_categoria',
                'marca.nombre_marca'
            )
            ->leftJoin('stock', 'producto.id_producto', '=', 'stock.id_producto')
            ->leftJoin('categoria','producto.id_categoria','=','categoria.id_categoria')
            ->leftJoin('marca','producto.id_marca','=','marca.id_marca')
            ->where('producto.id_producto', $id)
            ->groupBy('producto.id_producto','categoria.nombre_categoria', 'marca.nombre_marca')
            ->first(); // Devuelve solo el primer resultado, ya que esperamos un único producto
    
        return $producto; // Devuelve el producto con el ID <especificado></especificado>
        
        SI HAGO LA RELACIONES DE MODELOS LA CONSULTA QUEDARIA MUCHO MAS SENCILLA:*/


    $producto = Producto::with(['categoria', 'marca','descuento']) //tablas categoria y marca
      ->withSum('stock as stock', 'cantidad') //se trata de sumar los valores de cantidad de la tabla stock
      ->findOrFail($id); // Encuentra el producto o lanza un error si no existe

    $producto->stock = $producto->stock ?? 0; //si no hay registros con ese id_prdcuto se retorna 0

    return $producto;
  }





  public function update(UpdateProductoRequest $request, string $id)
  { //SE HACEN LAS VALIDACIONES DE UNIQUE DIRECTAMENTE EN LA BD AQUI

    if (Producto::where('codigo', $request->codigo)->where('id_producto', '!=', $id)->exists()) {
      return response()->json([
        'message' => 'El código ya está en uso por otro producto.',
      ], 422);
    }

    if (Producto::where('producto', $request->producto)->where('id_producto', '!=', $id)->exists()) {
      return response()->json([
        'message' => 'El nombre del producto ya está en uso por otro producto.',
      ], 422);
    }
    $datosValidos = $request->only(['codigo', 'producto', 'alerta_minima', 'costo', 'id_categoria', 'id_marca']);
    $producto = Producto::findOrFail($id);
    $producto->update($datosValidos);

    return response()->json([
      'message' => 'Producto actualizado exitosamente',
      'producto' => $producto
    ], 200);
  }



  public function destroy(string $id)
  {
    return "destroy";
  }

  public function filtro(Request $request)
  {

     $where = Producto::with(['descuento'])
     ->withSum('stock as stock', 'cantidad'); //se trata de sumar los valores de cantidad de la tabla stock
      

    //$where = $where->select(['producto', 'costo']);

    // $where = Producto::select(['producto','costo']);

    if ($request->id_marca != null)
      $where = $where->where('id_marca', $request->id_marca);

    if ($request->id_categoria != null)
      $where = $where->where('id_categoria', $request->id_categoria);

    if (($request->busqueda && ($request->tipo === "Nombre")) != null){
     // $where = $where->where('producto', 'like','%'.strtolower($request->busqueda).'%');
      $where = $where->whereRaw('producto LIKE ?', ['%' . strtolower($request->busqueda) . '%']);
    }

    if (($request->busqueda && ($request->tipo === "Codigo")) != null)
     // $where = $where->where('codigo',  'like','%'.$request->busqueda.'%');
     $where = $where->whereRaw('LOWER(codigo) LIKE ?', ['%' . strtolower($request->busqueda) . '%']); //LOWE PARA convertir en minusculas


    /*if ($request->costo != null)
      $where = $where->where('costo', $request->costo[0], $request->costo[1]);
*/
    //  $where = $where->orderBy('producto');

    //  $tamanioPagina = $request->tamanioPagina != null ? $request->tamanioPagina : 10;

    //  return $where->get();
    return $where->get();
  }

  public function buscar (Request $request){
    $termino = $request->termino;
    $tipoBusqueda = $request->tipoBusquedaProducto;


    if($tipoBusqueda!=null && $tipoBusqueda=== 'Nombre'){
      $resultados = Producto::whereRaw('producto LIKE ?', ['%' . strtolower($termino) . '%'])
      ->get();
    }
    if($tipoBusqueda!=null && $tipoBusqueda=== 'Codigo'){
      $resultados = Producto::whereRaw('LOWER(codigo) LIKE ?', ['%' .strtolower($termino). '%'])
      ->get();
    }


    return response()->json($resultados);
  }
}
