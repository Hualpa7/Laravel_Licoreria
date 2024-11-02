<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';
    protected $primaryKey  = 'id_stock';
    public $timestamps = false;

    protected $fillable = [
        'cantidad',
        'tipo',
        'observaciones',
        'id_producto',
        'id_compra',
        'id_venta',
        'id_sucursal',
        'id_transferencia'
    ];

    protected function tipo(): Attribute{
        return Attribute::make(
               get: fn (string $value) => ucfirst(strtolower($value)),
               set: fn (string $value) => strtolower($value),
        );
    }
}

