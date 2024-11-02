<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{

    public function index()
    
    {
        return Categoria::orderBy('nombre_categoria', 'asc')->get();
    }


    public function store(StoreCategoriaRequest $request)
    {

        $datosValidos = $request->validated();
        $categoria = Categoria::create($datosValidos);
        $categoria->save();
        return ($categoria);

        
    }

    public function show(string $id)
    {
        return Categoria::find($id);
    }


    public function update(StoreCategoriaRequest $request, string $id)
    {
        $datosValidos = $request->validated();
        $categoria = Categoria::find($id);
        $categoria->update($datosValidos);
    }


    public function destroy(string $id)
    {
        //
    }

    public function filtro (Request $request){
        $where = new Categoria;

        if($request->nombre_categoria != null)
          $where = $where->where('nombre_categoria',$request->nombre_categoria);

       return $where->get();
    }
}
