<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarcaRequest;
use App\Models\Marca;
use Illuminate\Http\Request;


class MarcaController extends Controller
{

    public function index()
    {
        return Marca::orderBy('nombre_marca', 'asc')->get();
    }


    public function store(StoreMarcaRequest $request)
    {
        $datosValidos = $request->validated();
        $marca = Marca::create($datosValidos);
        $marca->save();
        return ($marca);
    }


    public function show(string $id)
    {
        return Marca::find($id); // Devuelve el producto con el ID especificado
    }


    public function update(StoreMarcaRequest $request, string $id)
    {
        $datosValidos = $request->validated();
        $marca = Marca::find($id);
        $marca->update($datosValidos);

        

        return response()->json([
            'message' => 'Marca actualizada exitosamente',
            'marca' => $marca
          ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
