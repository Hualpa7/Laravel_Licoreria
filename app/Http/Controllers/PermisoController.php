<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermisoRequest;
use App\Models\Permiso;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PermisoController extends Controller
{
    
    public function index()
    {
        return Permiso::all(); 
    }

  
    public function store(StorePermisoRequest $request)
    {
        
        $datosValidos = $request->validated();
        $permiso = Permiso::create($datosValidos);
        $permiso->save();
        return ($permiso);
       
    }

    public function show(string $id)
    {
        return Permiso::find($id);
    }

   
    public function update(Request $request, string $id)
    {
        //
    }

    
    public function destroy(string $id)
    {
        //
    }
}
