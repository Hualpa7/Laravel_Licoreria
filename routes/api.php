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
use App\Http\Controllers\Usuario2Controller;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use App\Http\Middleware\JwtMiddleware;
use App\Models\Descuento;
use Illuminate\Support\Facades\Route;
use App\Models\Producto;






Route::resource('/categoria',CategoriaController::class);
Route::post('/categoria/filtro', [CategoriaController::class,'filtro']);
Route::resource('/combo',ComboController::class);
Route::post('/combo/filtro', [ComboController::class,'filtro']);
Route::resource('/compra',CompraController::class);
Route::post('/compra/filtro', [CompraController::class,'filtro']);
Route::get('/compra/anos', [CompraController::class,'obtenAños']);
Route::resource('/descuento',DescuentoController::class);
Route::post('/descuento/filtro', [DescuentoController::class,'filtro']);
Route::resource('/marca',MarcaController::class);
Route::resource('/permiso',PermisoController::class);
Route::post('/permiso/vincularPermisoaRol', [PermisoController::class,'vincularPermisoaRol']);
Route::resource('/producto',ProductoController::class);
Route::post('/producto/filtro', [ProductoController::class,'filtro']);
Route::post('/producto/buscar', [ProductoController::class,'buscar']);
Route::resource('/proveedor',ProveedorController::class);
Route::post('/proveedor/buscar', [ProveedorController::class,'buscar']);
Route::resource('/rol',RolController::class);
Route::resource('/stock',StockController::class);
Route::resource('/sucursal',SucursalController::class);
Route::resource('/usuario',UsuarioController::class);
Route::resource('/venta',VentaController::class);
Route::post('/venta/filtro', [VentaController::class,'filtro']);
Route::get('/venta/obtenerAnios', [VentaController::class,'obtenerAnios']);



Route::post('/usuario/registrar', [UsuarioController::class,'register']);
Route::post('/usuario/iniciarSesion', [UsuarioController::class,'login']);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::post('/usuario/cerrarSesion', [UsuarioController::class,'logout']);
    Route::post('/usuario/usuario', [UsuarioController::class,'getUser']);
});






