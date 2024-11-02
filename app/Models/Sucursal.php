<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursal';
    protected $primaryKey  = 'id_sucursal';
    public $timestamps = false;


    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'provincia',
        'foto'
    ];

    protected function direccion(): Attribute{
        return Attribute::make(
               get: fn (string $value) => ucfirst(strtolower($value)),
               set: fn (string $value) => strtolower($value),
        );
    }
}

