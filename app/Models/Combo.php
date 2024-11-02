<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Combo extends Model
{
    protected $table = 'combo';
    protected $primaryKey  = 'id_combo';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'costo',
        'duracion',
        'id_sucursal'
    ];

    protected function nombre(): Attribute{
        return Attribute::make(
               get: fn (string $value) => ucfirst(strtolower($value)),
               set: fn (string $value) => strtolower($value),
        );
    }

    protected function costo(): Attribute
    {
        return Attribute::make(
            get: fn($value) => '$' . number_format($value, 2), // Agregar signo de pesos y formatear a dos decimales
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
