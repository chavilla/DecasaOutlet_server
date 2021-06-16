<?php

namespace App\Http\Controllers;

use App\Models\Kardex;
use App\Models\Product;
use Exception;

class KardexController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($codebar)
    {
        //
        try {
            //code...

            $product = Product::where('codebar',$codebar)->select('id')->first();


            if(!$product) {
                return response()->json([],200);
            }

            $row = Kardex::select('product_id', 'description', 'cost_pp', 'input_amount', 'input_value', 'output_amount', 'output_value', 'balance_amount', 'balance_value', 'created_at')->where('product_id', $product->id)->get();

            if(count($row)==0) {
                return response()->json([],200);
            }

            return response()->json($row, 200);

        }    
        catch (\Exception $e) {
            //throw $th;
            return response()->json(['msg' => $e->getMessage()], 422);
        }

        catch (\Throwable $e) {
            return response()->json([ 'msg' => $e->getMessage()],500);
        }
    }
 
}
