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


    protected function duracion(): Attribute
    {
        return Attribute::make(
            get: fn($value) => date('d/m/Y', strtotime($value)), // Convertir a dd/mm/aaaa al obtenerlo
            set: fn($value) => date('Y-m-d H:i:s', strtotime($value)) // Guardar en Y-m-d H:i:s al almacenarlo
        );
    }

    
}
