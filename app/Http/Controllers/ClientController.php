<?php

namespace App\Http\Controllers;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        try {
            //code...
            return response()->json([
                Client::select('id','ruc', 'name', 'lastName', 'phone' ,'email')->get()
            ],200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'msg' => 'No se pueden obtener los clientes',
            ],500);
        }
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errors=$this->fieldValidation($request);

        if ($errors) {
            # code...
            return $errors;
        }

        try {
            $client = new Client([
                'ruc' => $request->ruc,
                'name' => $request->name,
                'lastName' => $request->lastName,
                'phone' => $request->phone,
                'email' => $request->email,
                'active' => 1,
            ]);

            $client->save();

            return response()->json([
                'msg' => 'Cliente creado satisfactoriamente',
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Hubo un problema con el servidor',
                'error' => $e->getMessage(),
            ]);
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
            $client = Client::find($id);
            $client->ruc = $request->ruc;
            $client->name = $request->name;
            $client->lastName = $request->lastName;
            $client->phone = $request->phone;
            $client->email = $request->email;
            $client->save();

            return response()->json(
                [
                    'msg' => 'Cliente guardado satisfactoriamente',
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'msg' => 'No se ha podido guardar el cliente',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    // validations
    public function fieldValidation($request){
        $rules = [
            'ruc' => 'min:7|unique:clients|max:14|alpha_num|required',
            'name' => 'required|regex:/^[A-Za-zÁÉÍÓÚáéíóú][a-záéíóú]{1,15}$/',
            'lastName' => 'required|regex:/^[A-Za-zÁÉÍÓÚáéíóú][a-záéíóú]{1,15}$/',
            'phone' => 'required|regex:/(^\d{4}-\d{4}$)/',
            'email' => 'required|unique:clients|regex:/(^[a-z][\w]+[-\.]?\w+@[a-z]+\.(com)?(net)?(org)?)/',
        ];
 
        $messages = array(
         'ruc.required' => 'Campo ruc es requerido',
         'ruc.min' => 'Campo ruc debe tener al menos 7 caracteres',
         'ruc.max' => 'Campo ruc no debe tener más de 8 caracteres',
         'ruc.alpha_num' => 'Campo ruc sólo debe contener números o letras',
         'ruc.unique' => 'El RUC introducido ya está siendo usado',
         'name.required' => 'Campo nombre es requerido',
         'name.regex' => 'El formato del nombre no es válido',
         'lastName.required' => 'Campo apellido es requerido',
         'lastName.regex' => 'El formato del apellido no es válido',
         'phone.required' => 'Campo teléfono es requerido',
         'phone.regex' => 'El formato del teléfono no es válido',
         'email.required' => 'Campo email es requerido',
         'email.unique' => 'El email introducido ya está siendo usado',
         'email.regex' => 'El email no es válido',
        );
 
        
        $validator = Validator::make($request->all(),$rules, $messages);
 
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()],
                400);
        }
    }
}
