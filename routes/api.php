<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DescuentoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;
use App\Models\Producto;


/*
Route::get('/productoss',function () {
    $productos = Producto::where('descripcion','Prodcuto B') -> get();
});
*/


Route::get('/productos/costo-mayor-a/{costo}', function ($costo) {
  $producto = Producto::where('costo','>',$costo) -> get();
  return $producto;
});




Route::resource('/categoria',CategoriaController::class);
Route::post('/categoria/filtro', [CategoriaController::class,'filtro']);
Route::resource('/combo',ComboController::class);
Route::resource('/compra',CompraController::class);
Route::resource('/descuento',DescuentoController::class);
Route::resource('/marca',MarcaController::class);
Route::resource('/permiso',PermisoController::class);
Route::resource('/producto',ProductoController::class);
Route::post('/producto/filtro', [ProductoController::class,'filtro']);
Route::resource('/proveedor',ProveedorController::class);
Route::resource('/rol',RolController::class);
Route::resource('/stock',StockController::class);
Route::resource('/sucursal',SucursalController::class);
Route::resource('/usuario',UsuarioController::class);
Route::resource('/venta',VentaController::class);





