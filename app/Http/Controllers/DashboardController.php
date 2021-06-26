<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\models\Client;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Product;

class DashboardController extends Controller
{
    //
    public function index(){

        return response()->json([
            'users'=> User::count(),
            'products' => Product::count(),
            'categories' => CategoryProduct::count(),
            'clients' => Client::count(),
            'salesMonth' => $this->countSalesMonth(),
            'salesToday' => $this->countSalesDay(),
        ]);
    }

    // Sales from month
    public function countSalesMonth() {

        return Invoice::whereBetween('created_at', [$this->_data_first_month_day(), $this->_data_last_month_day()])->sum('total');
    }


    // sales last mont

    // sales from day
    public function countSalesDay() {
        return Invoice::whereBetween('created_at', [$this->_data_start_today(), $this->_data_end_today()])->sum('total');
    }

     /** Actual month first day **/
     public function _data_first_month_day() {
        $month = date('m');
        $year = date('Y');
        return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
    }

        /** Actual month last day **/
    public function _data_last_month_day() {
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0,0,0, $month+1, 0, $year));

        return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
    }

    /* Actual day */

    public function _data_start_today() {
        return date('Y-m-d') . ' 00:00:00';
    }

    public function _data_end_today() {
        return date('Y-m-d') . ' 23:59:59';
    }
}
