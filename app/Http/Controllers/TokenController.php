<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TokenController extends Controller
{
    // login
    public function login(Request $request)
    {

        $errors = $this->fieldValidation($request);

        if ($errors) {
            return $errors;
        }

        try {

            //code...
            $token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password]);

            // Everything was ok
            if ($token) {
                return response()->json([
                    'success' => true,
                    'token' => $token,
                    'user' => User::where('email', $request->email)->get()->first(),
                ], 200);
            }
            // There is an error
            else {
                return response()->json([
                    'success' => false,
                    'message' => 'Email o Password incorrectos',
                ], 422);
            }
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage(),
            ], 500);
        }
    }

    // token invalidator
    public function logout()
    {
        $token = JWTAuth::getToken();

        try {

            JWTAuth::invalidate($token);
            return response()->json([
                'success' => true,
                'message' => 'logout success',
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Error al cerrar sesión '
            ], 422);
        }
    }

    //refresh token
    public function refreshToken(Request $request)
    {
        $token = JWTAuth::getToken();

        try {
            $token = JWTAuth::refresh();

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => User::where('email', $request->email)->get()->first(),
            ], 200);
        } catch (TokenBlacklistedException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Necesitas loguarte nuevamente',
                'exception' => $exception->getMessage(),
            ], 422);
        } catch (TokenExpiredException $exception) {
            return response()->json([
                'success' => false,
                'msg' => 'Tu sesión ha expirado',
                'status' => 401,
            ], 401);
        }
    }

    // validations
    public function fieldValidation($request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $messages = array(
            'email.required' => 'El Email es un campo requerido',
            'email.email' => 'El Email introducido no es válido',
            'password.required' => 'La contraseña es un campo requerido',
        );


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()->first()
                ],
                400
            );
        }
    }
}
