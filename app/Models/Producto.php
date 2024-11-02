<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey  = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'producto',
        'alerta_minima',
        'costo',
        'id_categoria',
        'id_marca',
        'id_descuento'
    ];

    protected function producto(): Attribute{
        return Attribute::make(
               get: fn (string $value) => ucfirst(strtolower($value)),
               set: fn (string $value) => strtolower($value),
        );
    }

    protected function costo(): Attribute
    {
        return Attribute::make(
            get: fn($value) => '$' . number_format($value, 2), // Agregar signo de pesos y formatear a dos decimales
            set: fn($value) => is_string($value) ? number_format((float)$value, 2, ',', '') : $value // Convertir a dos decimales
        );
    }
}
