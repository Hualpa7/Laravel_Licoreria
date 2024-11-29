<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compra';
    protected $primaryKey  = 'id_compra';
    public $timestamps = false;

    protected $fillable = [
        'total',
        'id_proveedor',
        'id_sucursal'
    ];

    protected function total(): Attribute
    {
        return Attribute::make(
            // Convertir a string en el formato deseado con coma como separador de decimales
            get: fn($value) => (string)number_format($value, 2, ',', ''),
            // En el set, convertir a float y eliminar puntos en la parte entera
            set: fn($value) => is_string($value)
                ? (float)str_replace(',', '.', $value)
                : $value
        );
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
