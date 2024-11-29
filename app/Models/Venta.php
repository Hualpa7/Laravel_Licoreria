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
        'total',
        'metodo_pago',
        'descuento_gral',
        'id_usuario',
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

    protected function metodoPago(): Attribute{
        return Attribute::make(
               get: fn (string $value) => ucfirst(strtolower($value)),
               set: fn (string $value) => strtolower($value),
        );
    }

   

    //relacion con tabla usuarios
     // Relación con la marca
     public function usuario()
     {
         return $this->belongsTo(Usuario::class, 'id_usuario');
     }

     public function producto()
     {
         return $this->belongsToMany(Producto::class, 'venta_producto', 'id_venta', 'id_producto')
                     ->withPivot('cantidad', 'iva'); // Para acceder a los campos adicionales en la tabla pivot
     }
     

}
