<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';
    protected $primaryKey  = 'id_venta';
    public $timestamps = false;

    protected $fillable = [
        'neto',
        'metodo_pago',
        'descuento_total',
        'id_usuario',
        'id_sucursal'
    ];

    protected function neto(): Attribute
    {
        return Attribute::make(
            get: fn($value) => '$' . number_format($value, 2), // Agregar signo de pesos y formatear a dos decimales
            set: fn($value) => is_string($value) ? number_format((float)$value, 2, '.', '') : $value // Convertir a dos decimales
        );
    }

    protected function metodoPago(): Attribute{
        return Attribute::make(
               get: fn (string $value) => ucfirst(strtolower($value)),
               set: fn (string $value) => strtolower($value),
        );
    }

    protected function descuentoTotal(): Attribute
    {
        return Attribute::make(
            get: fn($value) => '$' . number_format($value, 2), // Agregar signo de pesos y formatear a dos decimales
            set: fn($value) => is_string($value) ? number_format((float)$value, 2, '.', '') : $value // Convertir a dos decimales
        );
    }

}
