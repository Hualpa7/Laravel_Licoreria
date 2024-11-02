<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompraRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\Compra;

class CompraController extends Controller
{

    public function index()
    {
        return Compra::all();
    }


    public function store(StoreCompraRequest $request)
    {
        $datosValidos = $request->validated();
        $compra = Compra::create($datosValidos);
        $compra->save();
        return ($compra);
        
    }



    public function show(string $id)
    {
        return Compra::find($id);
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
