<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{

    public function index()
    {
        return Producto::all(); // Devuelve todos los productos
    }



    public function store(StoreProductoRequest $request)
    {
        $datosValidos = $request->validated();

        $datosValidos['costo'] = number_format((float)str_replace(',', '.', $datosValidos['costo']), 2, '.', '');

        $producto = Producto::create($datosValidos);

        //otra forma  es con el fill
        //$producto = new Producto();
        //$producto->fill($datosValidos);
        //aqui puedo agregar otros campos que no estan dentro de $datosValidos


        $producto->save();
        return ($producto);
    }



    public function show($id)
    {
        return Producto::find($id); // Devuelve el producto con el ID especificado
    }


    public function update(Request $request, string $id)
    {
        return "update";
    }


    public function destroy(string $id)
    {
        return "destroy";
    }

    public function filtro (Request $request){
        $where = new Producto;

        $where = $where->select(['producto','costo']);

       // $where = Producto::select(['producto','costo']);

        if($request->id_marca != null)
          $where = $where->where('id_marca',$request->id_marca);

        if($request->costo != null)
        $where = $where->where('costo', $request->costo[0], $request->costo[1]);

        $where = $where->orderBy('producto');

        $tamanioPagina = $request->tamanioPagina != null ? $request->tamanioPagina : 10;

     //  return $where->get();
     return $where->paginate($tamanioPagina);
    }
}
