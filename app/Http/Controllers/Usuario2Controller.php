<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class Usuario2Controller extends Controller
{

  /*  public function __construct()
    {
        $this->middleware('auth:api',['except' => ['login']]);
    }*/
    // User registration
    public function register(Request $request)
    {
        /*$validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }*/

        $user = Usuario::create([
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'dni' => $request->get('dni'),
            'id_rol' => $request->get('id_rol'),
            'id_sucursal' => $request->get('id_sucursal'),
            'correo' => $request->get('correo'),
            'contraseña' => Hash::make($request->get('contraseña')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'), 201);
    }

    // User login
    public function login (Request $request){
        $credentials = $request->only('correo', 'contraseña');

        $usuario = Usuario::where(['correo' => $credentials['correo']]) -> first();


        if(!Hash::check($credentials['contraseña'],$usuario->contraseña))
        return response() -> json(['error' => 'Unauthoriezed'],401);

           $token = JWTAuth::fromUser($usuario);
           return $token;
    }


 
   
/*
    public function login(Request $request)
    {
        $credentials = $request->only('correo', 'contraseña');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
         

            // Get the authenticated user.
            $user = auth()->user();

            // (optional) Attach the role to the token.
            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

            return response()->json(compact('token'));
        } catch (JWTException $e) {
            //return response()->json(['error' => 'Could not create token'], 500);
            
        }
    }
*/
    // Get authenticated user
    public function getUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(compact('user'));
    }

    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}