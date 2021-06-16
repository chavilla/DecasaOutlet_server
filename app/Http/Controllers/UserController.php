<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $users = User::select('name', 'email', 'role', 'active')->get();

        return response()->json([$users],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        try {

            $userDuplicate = User::where('email', $request->email)->first();

            if ($userDuplicate) {
                return response()->json([
                    'msg' => 'Lo sentimos. Ya existe un usuario con el email introducido'
                ], 422);
            }

            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            if (!$request->role) {
                $request->role = 'user';
            }
            $user->role = $request->role;
            $user->password = Hash::make($request->password);

            $user->save();

            return response()->json([
                'msg' => 'Usuario ingresado correctamente'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json(
                [
                    'msg' => 'No se ha podido guardar el usuario',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        try {
            //code...
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;

            $user->save();

            return response()->json(
                [
                    'msg' => 'Usuario Actualizado correctamente'
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'msg' => 'No se ha podido actualizar el usuario',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    public function toInactive($id)
    {

        try {

            $user = User::where('id', $id)->first();

            if (!$user) {
                return response()->json([
                    'msg' => 'No existe el usuario que estás tratando de inhabilitar'
                ], 401);
            }

            if ($user->active == 0) {
                $user->active = 1;
                $user->save();

                return response()->json([
                    'msg' => 'Usuario Activado'
                ], 200);
            } else {
                $user->active = 0;
                $user->save();

                return response()->json([
                    'msg' => 'Usuario Inactivo'
                ], 200);
            }
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'msg' => 'Uusuario no inactivado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
