<?php

namespace App\Http\Controllers;

use App\models\InputProduct;
use App\Models\Kardex;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InputProductController extends Controller
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

            $inputs = InputProduct::join('products', 'product_id', '=', 'products.id')->select('products.description', 'inputs.amount', 'inputs.cost', 'inputs.user_id as user', 'inputs.updated_at')->get();

            return response()->json([$inputs], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'msg' => 'Hubo un problema en el servidor',
                'error' => $th->getMessage(),
            ], 500);
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

        $errors = $this->fieldValidation($request);

        if ($errors) {
            return $errors;
        }

        // Start a transaction
        DB::beginTransaction();

        try {

            $last_kardex = Kardex::where('product_id', $request->product_id)->orderBy('created_at', 'DESC')->take(1)->join('products', 'product_id', '=', 'products.id')->select('products.description', 'kardexes.description', 'cost_pp', 'input_amount', 'input_value', 'output_amount', 'output_value', 'balance_amount', 'balance_value', 'kardexes.created_at')->get();

            if (count($last_kardex) == 0) {
                // set the first row in the kardex table
                $kardex = new Kardex();
                $kardex->product_id = $request->product_id;
                $kardex->description = "Compra Factura ". $request->invoice_number. ". Cantidad: ". $request->amount . ". Costo: " . $request->cost;
                $kardex->input_amount =  $request->amount;
                $kardex->cost_pp = $request->cost;
                $kardex->input_value = $request->amount * $request->cost;
                $kardex->output_amount = 0;
                $kardex->output_value = 0;
                $kardex->balance_amount = $request->amount - 0;
                $kardex->balance_value = $request->amount * $request->cost;
                $kardex->save();

                //update the product
                $product = Product::find($request->product_id);
                $product->cost = $kardex->cost_pp;
                $product->save();
                
            } else {

                $kardex = new Kardex();
                $kardex->product_id = $request->product_id;
                $kardex->description = "Compra Factura ". $request->invoice_number. ". Cantidad: ". $request->amount . ". Costo: " . $request->cost;
                $kardex->input_amount = $request->amount;
                $kardex->input_value = $request->amount * $request->cost;
                $kardex->output_amount = 0;
                $kardex->output_value = 0;
                $kardex->balance_amount = $request->amount + $last_kardex[0]->balance_amount;
                $kardex->balance_value =  $request->amount * $request->cost + $last_kardex[0]->balance_value;
                $kardex->cost_pp = $kardex->balance_value / $kardex->balance_amount;
                $kardex->save();

                //update the product
                $product = Product::find($request->product_id);
                $product->cost = $kardex->cost_pp;
                $product->save();
            }

            //creating a new Input
            $input = new InputProduct();
            $input->product_id = $request->product_id;
            $input->amount = $request->amount;
            $input->cost = $request->cost;
            $input->user_id = Auth::user()->id;
            // the InputProduct is saved ...
            $input->save();

            // Update the product
            Product::find($request->product_id)->increment('stock', $request->amount);
            DB::commit();

            return response()->json([
                'msg' => 'Entrada de producto Agregada exitosamente',
            ], 200);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return response()->json([
                'msg' => 'Lo sentimos. Hubo un problema en el servidor',
                'error' => $th->getMessage(),
            ], 422);

        } // end catch

        catch (Exception $e) {

            return response()->json([
                'msg' => 'Hubo un Error en el servidor',
                'error' => $e->getMessage(),
            ], 500);

        }
    } // End store

    // validations
    public function fieldValidation($request)
    {
        $rules = [
            'product_id' => ['required', 'numeric'],
            'amount' => ['required', 'numeric', 'min:1', 'max:999'],
            'cost' => ['required', 'numeric', 'min:0.05', 'max:999.99'],
        ];

        $messages = array(
            'product_id.required' => 'El ID del producto es un campo requerido',
            'product_id.numeric' => 'El ID del producto deber ser un número',
            'amount.required' => 'La cantidad es un campo requerido',
            'amount.numeric' => 'La cantidad deber ser un número',
            'amount.min' => 'La cantidad no debe ser menor a 1',
            'amount.max' => 'La cantidad no debe ser mayor a 999',
            'cost.required' => 'El costo es un campo requerido',
            'cost.numeric' => 'El costo deber ser un número',
            'cost.min' => 'El costo no debe ser menor a $0.05',
            'cost.max' => 'El costo no debe ser mayor a $999.99',
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
