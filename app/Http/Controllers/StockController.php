<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockRequest;
use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{

    public function index()
    {
        return Stock::all();
    }


    public function store(StoreStockRequest $request)
    {
        $datosValidos = $request->validated();
        $stock = Stock::create($datosValidos);
        $stock->save();
        return ($stock);
    }


    public function show(string $id)
    {
        return Stock::find($id);
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
