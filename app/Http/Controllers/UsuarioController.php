<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;


class UsuarioController extends Controller
{

    public function index()
    {
        return Usuario::all();
    }


    public function store(StoreUsuarioRequest $request)
    {
        $datosValidos = $request->validated();
        $usuario = Usuario::create($datosValidos);
        $usuario->save();
        return ($usuario);
    }


    public function show(string $id)
    {
        return Usuario::find($id);
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
