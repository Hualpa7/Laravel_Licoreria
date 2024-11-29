<?php

namespace App\Http\Middleware;

use App\Models\Producto;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $usuario = JWTAuth::parseToken()->authenticate();

            /*   $producto = Producto::where([
                'id_producto' => $usuario->id,
            ])->first();

            if($producto !==null){
                return $next($request);
            }

            *//*
            if ($usuario->correo === 'hualpafranco@gmail.com') {
                return $next($request);
            } else {
                return response()->json(['error' => 'Usuario no autirizado'], 401);
            }*/
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token no validooooooo'], 401);
        }
        return $next($request);
    }
}
