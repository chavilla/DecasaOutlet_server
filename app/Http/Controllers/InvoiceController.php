<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Invoice;
use App\Models\Kardex;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
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
            $invoices = Invoice::join('users', 'invoices.user_id', '=', 'users.id')
                ->join('clients', 'clients.id', '=', 'invoices.client_id')
                ->select('invoices.id as id', 'invoices.invoice_number as invoice', 'invoices.created_at','clients.name as clientName', 'clients.lastName as clientLastName', 'clients.ruc as clientRuc', 'clients.phone', 'clients.email','users.name as seller', 'invoices.created_at')
                ->get();

            $data = [];

            /* get the details by invoice */
            for ($i = 0; $i < sizeof($invoices); $i++) {
                $data[$i] = $invoices[$i];
                $detail = Detail::join('invoices', 'details.invoice_id', '=', 'invoices.id')
                    ->join('products', 'details.product_id','=','products.id')
                    ->select('products.description as description','amount', 'priceUnit', 'details.priceTotal')->where('details.invoice_id', $invoices[$i]->id)->get();
                $data[$i]->details = $detail;
            }

            return response()->json([$data]);

        } catch (\Throwable $th) {
            return response()->json([
                'msg' => 'Lo sentimos. Hubo un problema en el servidor',
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
            ], 422);
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
        DB::beginTransaction();

        try {
            //creating and saving a new invoice...
            $invoice = new InVoice();
            $lastInvoice = $this->saveInvoice($invoice, $request);

            // Creating all Details
            $detailSize = sizeOf($request->details);

            for ($i = 0; $i < $detailSize; $i++) {
                $detail = new Detail();
                $this->saveDetail($detail, $request->details[$i], $lastInvoice->id, $lastInvoice->invoice_number);
            }

            DB::commit();

            return response()->json('Venta realizada satisfactoriamente', 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return response()->json([
                'msg' => 'Lo sentimos. Hubo un problema en el servidor',
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
            ], 422);
        }
    }

    // Save an invoice
    public function saveInvoice($invoice, $request)
    {

        $invoice->invoice_number = $request->invoice_number;
        $invoice->user_id = Auth::user()->id;
        $invoice->client_id = $request->client_id;
        $invoice->payMode = $request->payMode;
        $invoice->ruc_client = $request->ruc;
        $invoice->total = $request->totalToPay;
        $invoice->created_at = Carbon::now();
        $invoice->created_at = Carbon::now();
        $invoice->save(['timestamps' => false]);

        return $invoice;
    }

    //save a detail
    public function saveDetail($detail, $request, $invoice_id, $invoice_number)
    {

        $detail->invoice_id = $invoice_id;
        $detail->product_id = $request['id'];
        $detail->amount = $request['amount'];
        $detail->priceUnit = $request['priceTotal'];
        $detail->priceTotal = $request['priceTotalSale'];
        $detail->save();

        $this->updateKardex($request['id'], $request['amount'], $request['priceTotal'], $request['priceTotalSale'], $invoice_number);
    }

    public function updateKardex($product_id, $amount, $priceUnit, $priceTotal, $invoice_number)
    {

        $last_kardex = Kardex::where('product_id', $product_id)->orderBy('created_at', 'DESC')->take(1)->join('products', 'product_id', '=', 'products.id')->select('products.description', 'kardexes.description', 'cost_pp', 'input_amount', 'input_value', 'output_amount', 'output_value', 'balance_amount', 'balance_value', 'kardexes.created_at')->get();

        $kardex = new Kardex();
        $kardex->product_id = $product_id;
        $kardex->description = 'Venta Factura ' . $invoice_number;
        $kardex->input_amount = 0;
        $kardex->input_value = 0;
        $kardex->output_amount = $amount;
        $kardex->output_value = $amount * $last_kardex[0]->cost_pp;
        $kardex->balance_amount = $last_kardex[0]->balance_amount - $amount;
        $kardex->balance_value =  $last_kardex[0]->balance_value - ($amount * $last_kardex[0]->cost_pp);
        $kardex->cost_pp =  $last_kardex[0]->cost_pp;

        $kardex->save();
        $this->decrementStock($product_id, $amount);
    }

    public function decrementStock($product_id, $amount)
    {
        //update the product
        Product::find($product_id)->decrement('stock', $amount);
    }

    public function getLastNoInvoice()
    {
        $lastInvoice = Invoice::latest()->first();
        if ($lastInvoice) {
            return response()->json($lastInvoice->invoice_number);
        } else {
            return response()->json("0000");
        }
    }
}
