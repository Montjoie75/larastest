<?php

use Illuminate\Support\Facades\Route;
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


// Route::delete('/delete/{id}', [CustomerController::class,'delete']);


Route::prefix('customers/')->group(function(){
    Route::get('/clean', [CustomerController::class,'clean']);
    Route::get('/', [CustomerController::class, 'getAll']);
    Route::get('/visits', [CustomerController::class,'getOneCustomerData']);
    Route::patch('/message/{id}', [CustomerController::class,'acceptCommercialMessage'])->name('message');
    Route::delete('/delete/{id}', [CustomerController::class, 'softDelete']);
});