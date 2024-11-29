<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedor';
    protected $primaryKey  = 'id_proveedor';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'telefono',
        'correo'
    ];


    protected function nombre(): Attribute{
        return Attribute::make(
               get: fn (string $value) => ucwords(strtolower($value)),
               set: fn (string $value) => strtolower($value),
        );
    }


}
