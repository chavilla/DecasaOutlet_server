<?php

namespace App\Http\Controllers;

use App\Models\Kardex;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{

    // show all products
    public function index()
    {
        try {
            //code...
            $products = Product::join('users', 'user_id', '=', 'users.id')
            ->select('products.codebar', 'products.id','products.description', 'products.reference', 'products.category_id', 'products.stock', 'products.cost' ,'products.priceTotal', 'products.tax' ,'products.active' , 'users.name as creador')->get();

            return response()->json([$products]);

        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'msg' => $e->getMessage(),
                'status' => 422
            ],422);
        }
    }

    //Get id and description
    public function getIdAndDescription()
    {
        try {
            //code...
            $products = Product::select('id', 'description')->get();

            return response()->json($products,200);

        } catch (\Exception $th) {
            return response()->json([
                'msg' => 'No se han podido obtener los productos',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    //store a new product
    public function store(Request $request)
    {

        // Validation
        $errors = $this->fieldValidation($request);
        if ($errors) {
            return $errors;
        }

        // priceTotal must be more expensive than cost
        if ($request->priceTotal <= $request->cost) {
            # code...
            return response()->json([
                'msg' => 'El Precio debe ser mayor al costo',
            ],422);
        }

        DB::beginTransaction();

        try {
            //code...
            $product = new Product();
            $product->cost = $request->cost;
            $product->stock = $request->stock;
            $product->priceTotal = $request->priceTotal;
            $product->tax = $request->tax;
            $product->description = $request->description;
            $product->reference = $request->reference;
            $product->codebar = $request->codebar;
            $product->category_id = $request->category_id;
            $product->user_id =Auth::user()->id;
            $product->save();

            // modify kardex of this product
            $kardex = new Kardex();
            $kardex->product_id = $product->id;
            $kardex->description = "Stock Inicial .Cantidad: ". $request->stock . ". Costo: " . $request->cost;
            $kardex->input_amount =  $request->stock;
            $kardex->cost_pp = $request->cost;
            $kardex->input_value = $request->stock * $request->cost;
            $kardex->output_amount = 0;
            $kardex->output_value = 0;
            $kardex->balance_amount = $request->stock;
            $kardex->balance_value = $request->stock * $request->cost;
            $kardex->save();

            DB::commit();

            return response()->json([
                'msg' => 'Producto insertado correctamente'
            ], 200);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return response()->json([
                'msg' => 'No se ha podido insertar el producto',
                'error' => $th->getMessage(),
            ], 422);

        } // end catch
    }

    //display a product with the specified id
    public function show($codebar)
    {
        //
        try {
            //code...

            $product =  Product::select('id','description', 'reference', 'stock', 'priceTotal', 'codebar','tax')->where('codebar', $codebar)->get();

            if(count($product) == 0) {
                return response()->json([
                ],200);
            }

            return response()->json($product,200);

        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'msg' => 'Hubo un problema en el servidor',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        //
        try {
            //code...
            $product = Product::find($id);
            $product->priceTotal = $request->priceTotal;
            $product->tax = $request->tax;
            $product->description = $request->description;
            $product->reference = $request->reference;
            $product->codebar = $request->codebar;
            $product->category_id = $request->category_id;
            $product->user_id = Auth::user()->id;
            $product->save();

            return response()->json(
                [
                    'msg' => 'Producto Actualizado correctamente'
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'msg' => 'No se ha podido actualizar el producto',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    //inactive the product with the id specified
    public function toInactive($id)
    {

        try {

            $product = Product::where('id', $id)->first();

            if ($product->active == 0) {
                $product->active = 1;
            } else {
                $product->active = 0;
            }

            $product->save();

            return response()->json([
                'msg' => 'Producto Actualizado'
            ], 200);
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'msg' => 'Producto no Actualizado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // validations
    public function fieldValidation($request)
    {
        $rules = [
            'category_id' => ['required', 'regex:/(^\d{1,2}$)/'],
            'cost' => ['required', 'numeric','min:0.05', 'max:999.99'],
            'priceTotal' => ['required', 'numeric','min:0.05', 'max:999.99'],
            'stock' => ['required', 'numeric', 'min:1', 'max:999'],
            'tax' => ['required', 'numeric','min:0'],
            'description' => ['required', 'regex:/^[A-Z][a-záéíóú0-9]+(\s?[A-Za-záéíóú0-9])+$/'],
            'reference' => ['required', Rule::unique('products')],
            'codebar' => [ 'required', 'regex:/^[0-9]{12,13}$/', Rule::unique('products')],
        ];

        $messages = array(
            'category_id.required' => 'La categoría es un campo requerido',
            'category_id.regex' => 'El formato de la categoría no es válido',
            'cost.required' => 'El costo es campo requerido',
            'cost.min' => 'El costo no debe ser menor a $0.05',
            'cost.max' => 'El costo no debe ser mayor a 999.99',
            'priceTotal.required' => 'El Precio total es campo requerido',
            'priceTotal.min' => 'El Precio total no debe ser menor a $0.05',
            'priceTotal.max' => 'El Precio total no debe ser mayor a 999.99',
            'stock.required' => 'El stock es campo requerido',
            'stock.min' => 'El stock no debe ser menor a 1',
            'stock.max' => 'El stock no debe ser mayor a 999',
            'tax.required' => 'El impuesto es campo requerido',
            'tax.min' => 'El impuesto no debe ser menor a 0',
            'tax.numeric' => 'El impuesto debe ser numérico',
            'description.required' => 'La descripción es un campo requerido',
            'description.regex' => 'El formato de la descripción no es válido',
            'reference.required' => 'La referencia es un campo requerido',
            'reference.unique' => 'Este producto ya existe',
            'codebar.required' => 'El código de barra es un campo requerido',
            'codebar.regex' => 'Código de barras no válido',
            'codebar.unique' => 'Ya existe un producto con el código de barras establecido',
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
