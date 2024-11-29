<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRolRequest;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{

    public function index()
    {

        // Consulta para obtener los roles y permisos en formato JSON
        $roles = DB::table('roles')
            ->leftJoin('rol_permiso', 'roles.id_rol', '=', 'rol_permiso.id_rol')
            ->leftJoin('permisos', 'rol_permiso.id_permiso', '=', 'permisos.id_permiso')
            ->select(
                'roles.id_rol',
                'roles.nombre_rol',
                DB::raw('COALESCE(json_agg(json_build_object(
                        \'id_permiso\', permisos.id_permiso,
                        \'nombre_permiso\', permisos.nombre_permiso
                    )
                ) FILTER (WHERE permisos.id_permiso IS NOT NULL),
                \'[]\'
            ) AS permisos
        ')
            )
            ->groupBy('roles.id_rol')
            ->get();

        // Decodificar los permisos en formato JSON
        foreach ($roles as $rol) {
            $rol->permisos = json_decode($rol->permisos);
        }

        // Retornar el resultado como JSON
        return response()->json($roles);
    }

    public function store(StoreRolRequest $request)
    {

        $datosValidos = $request->validated();
        $rol = Rol::create($datosValidos);
        $rol->save();
        return ($rol);
    }


    public function show(string $id)
    {
        return Rol::find($id);
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
