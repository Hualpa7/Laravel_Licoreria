<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable; 

class Usuario extends Authenticatable implements JWTSubject
{
    protected $table = 'usuario';
    protected $primaryKey  = 'id_usuario';
    public $timestamps = false;

    use HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'contraseña',
        'id_rol',
        'id_sucursal',
        'correo'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
          'correo' => $this['correo'],
            'contraseña' => $this['contraseña'],
            'id_usuario' => $this['id_usuario']
        ];
    }

     // Relación con la marca
     public function rol()
     {
         return $this->belongsTo(Rol::class, 'id_rol');
     }

     public function sucursal()
     {
         return $this->belongsTo(Sucursal::class, 'id_sucursal');
     }
    
}
