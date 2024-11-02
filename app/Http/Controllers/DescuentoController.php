<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDescuentoRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\Descuento;

class DescuentoController extends Controller
{

    public function index()
    {
        return Descuento::all(); // Devuelve todos los descuentos
    }

    public function store(StoreDescuentoRequest $request)
    {
        $datosValidos = $request->validated();
        $descuento = Descuento::create($datosValidos);
        $descuento->save();
        return ($descuento);
    }




    public function show(string $id)
    {
        return Descuento::find($id);
    }


    public function update(StoreDescuentoRequest $request, string $id)
    {
        $datosValidos = $request->validated();
        $descuento = Descuento::find($id);
        $descuento->update($datosValidos);
    }

    public function destroy(string $id)
    {
        //
    }
}
