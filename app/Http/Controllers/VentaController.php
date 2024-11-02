<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVentaRequest;
use Illuminate\Http\Request;
use App\Models\Venta;

class VentaController extends Controller
{

    public function index()
    {
        return Venta::all();
    }



    public function store(StoreVentaRequest $request)
    {
        $datosValidos = $request->validated();
        $venta = Venta::create($datosValidos);
        $venta->save();
        return ($venta);
    }


    public function show(string $id)
    {
        return Venta::find($id);
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
