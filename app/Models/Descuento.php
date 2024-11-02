<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Descuento extends Model
{
    protected $table = 'descuento';
    protected $primaryKey  = 'id_descuento';
    public $timestamps = false;

    protected $fillable = [
        'duracion',
        'porcentaje',
        'id_sucursal'
    ];

    protected function porcentaje(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>  number_format($value, 2), // Agregar signo de pesos y formatear a dos decimales
            set: fn($value) => is_string($value) ? number_format((float)$value, 2, '.', '') : $value // Convertir a dos decimales
        );
    }

    protected function duracion(): Attribute
    {
        return Attribute::make(
            get: fn($value) => date('d/m/Y', strtotime($value)), // Convertir a dd/mm/aaaa
            set: fn($value) => $value // Dejar como está para guardarlo sin modificar
        );
    }
}
