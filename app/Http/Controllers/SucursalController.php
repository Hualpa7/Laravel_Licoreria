<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSucursalRequest;
use App\Models\Sucursal;
use Illuminate\Http\Request;


class SucursalController extends Controller
{

    public function index()
    {
        return Sucursal::all();
    }


    public function store(StoreSucursalRequest $request)
    {

        $datosValidos = $request->validated();
        $sucursal = Sucursal::create($datosValidos);
        $sucursal->save();
        return ($sucursal);
    
    }


    public function show(string $id)
    {
        return Sucursal::find($id);
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
