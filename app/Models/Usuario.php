<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey  = 'id_usuario';
    public $timestamps = false;


    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'contraseña',
        'id_rol',
        'id_sucursal',
        'correo'
    ];

    
}
