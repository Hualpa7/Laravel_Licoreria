<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProveedorController extends Controller
{
    
    public function index()
    {
        return Proveedor::orderBy('nombre', 'asc')->get();
    }

    
   
    public function store(StoreProveedorRequest $request)
    {
        $datosValidos = $request->validated();
        $proveedor = Proveedor::create($datosValidos);
        $proveedor->save();
        return ($proveedor);
    }


   
    public function show(string $id)
    {
        return Proveedor::find($id); 
    }

  
    public function update(StoreProveedorRequest $request, string $id)
    {
        $datosValidos = $request->validated();
        $proveedor = Proveedor::find($id);
        $proveedor->update($datosValidos);
    }

    
    public function destroy(string $id)
    {
        //
    }

    public function buscar (Request $request){
        $termino = $request->termino;
        $tipoBusqueda = $request->tipoBusquedaProveedor;
    
    
        if($tipoBusqueda!=null && $tipoBusqueda=== 'Nombre'){
          $resultados = Proveedor::whereRaw('nombre LIKE ?', ['%' . strtolower($termino) . '%'])
          ->get();
        }
        if($tipoBusqueda!=null && $tipoBusqueda=== 'Correo'){
          $resultados = Proveedor::whereRaw('correo LIKE ?', ['%' .$termino. '%'])
          ->get();
        }
    
        return response()->json($resultados);
      }
}
