<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductRequestController;
use App\Http\Controllers\CustomerController;

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

Route::middleware('api')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('product_requests', ProductRequestController::class);
    Route::get('customer/nik/{nik}', [CustomerController::class, 'nik'])->name('customers.search_nik');
    Route::get('product_requests/detail/{id}', [ProductRequestController::class, 'detail'])->name('product_requests.detail');
});
