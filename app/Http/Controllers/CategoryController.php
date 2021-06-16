<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $categories = CategoryProduct::select('id', 'name')->get();

        return response()->json([$categories], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIdAndNameCategories()
    {
        try {
            //code..
            $categories = CategoryProduct::select('id', 'name')->get();
            return response()->json([$categories], 200);

        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Hubo un error en el servidor',
                'error' => $e->getMessage(),
            ]);
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
        //

        try {

            $error = $this->fieldValidation($request);

            if ($error) {
                return $error;
            }

            $category = new CategoryProduct();
            $category->name = $request->name;
            $category->save();

            return response()->json([
                'msg' => 'Categoría guardada correctamente'
            ], 200);
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'msg' => 'Lo sentimos. Hubo un problema en el servidor',
                'error' => $e->getMessage(),
            ], 422);
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
        try {
            //
            return response()->json(CategoryProduct::select('id','name')->where('id', $id)->get());

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'msg' => 'Hubo un error',
                'error' => $th->getMessage(),
            ],500);
        }
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
        try {
            //code...
            $category = CategoryProduct::find($id);

            $error = $this->fieldValidation($request);

            if($error) {
                return $error;
            }

            $category->name = $request->name;
            $category->save();

            return response()->json(
                [
                    'msg' => 'Nombre de categoría Actualizada correctamente'
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'msg' => 'Mo se ha podido actualizar el nombre de la cateogoría',
                    'error' => $e->getMessage()
                ],
                500
            );
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

    // validation

    // validations
    public function fieldValidation($request){
        $rules = [
            'name' => [
                'required',
                Rule::unique('categories'),
                'regex:/(^[A-Z][a-záéíóú]+$)/'],
        ];
 
        $messages = array(
         'name.required' => 'Campo nombre es requerido',
         'name.unique' =>  'Esta categoría ya existe',
         'name.regex' => 'El formato del nombre no es válido',
        );
 
        $validator = Validator::make($request->all(),$rules, $messages);
 
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()],
                400);
        }
    }

}
