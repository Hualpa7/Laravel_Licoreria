<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComboRequest;
use App\Models\Combo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ComboController extends Controller
{

    public function index()
    {
        return Combo::all();
    }


    public function store(StoreComboRequest $request)
    {
        $datosValidos = $request->validated();
        $combo = Combo::create($datosValidos);
        $combo->save();
        return ($combo);
    }


    public function show(string $id)
    {
        return Combo::find($id);
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
