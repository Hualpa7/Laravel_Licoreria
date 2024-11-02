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
            get: fn($value) => '$' . number_format($value, 2), // Agregar signo de pesos y formatear a dos decimales
            set: fn($value) => is_string($value) ? number_format((float)$value, 2, '.', '') : $value // Convertir a dos decimales
        );
    }
}
