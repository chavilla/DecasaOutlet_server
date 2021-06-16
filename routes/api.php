<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InputProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Auth
Route::group(['middleware' => [], 'prefix' => 'v1'], function () {
    Route::post('/auth/login', [TokenController::class, 'login']);
    Route::post('/auth/refresh', [TokenController::class, 'refreshToken']);
    Route::get('/auth/logout', [TokenController::class, 'logout']);
});

// CRUD: Create, Red, Update, Delete
Route::group(['middleware' => ['jwt.auth'], 'prefix' => 'v1'], function () {

    //categoryController
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/getIdAndNameCategories', [CategoryController::class, 'getIdAndNameCategories']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);

    // Product Routes
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/getIdAndDescription', [ProductController::class, 'getIdAndDescription']);
    Route::get('/products/{codebar}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::put('/products/disabled/{id}', [ProductController::class, 'toInactive']);

    //Users Router
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::put('/users/inactive/{id}', [UserController::class, 'toInactive']);

    //clients Router
    Route::get('/clients', [ClientController::class, 'index']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::put('/clients/{id}', [ClientController::class, 'update']);
    Route::put('/clients/disabled/{id}', [ClientController::class, 'disabled']);

    // inputs Routes
    Route::get('/inputs', [InputProductController::class, 'index']);
    Route::post('/inputs', [InputProductController::class, 'store']);

    // kardex Routes
    Route::get('/kardex/{codebar}', [KardexController::class, 'show']);

    //Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Invoice Route
    Route::get('/invoices', [InvoiceController::class, 'index']);
    Route::get('/invoice/lastID', [InvoiceController::class, 'getLastNoInvoice']);
    Route::post('/invoice', [InvoiceController::class, 'store']);

    // User Routes
    Route::get('user', [UserController::class, 'index']);
    Route::post('user', [UserController::class, 'store']);
});