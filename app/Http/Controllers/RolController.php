<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRolRequest;
use App\Models\Rol;
use Illuminate\Http\Request;


class RolController extends Controller
{

    public function index()
    {
        return Rol::all();
    }

    public function store(StoreRolRequest $request)
    {

        $datosValidos = $request->validated();
        $rol = Rol::create($datosValidos);
        $rol->save();
        return ($rol);
   
    }


    public function show(string $id)
    {
        return Rol::find($id);
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
