<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/invoices', [App\Http\Controllers\api\InvoicesController::class, 'create'])
    ->middleware('content.type:text/plain');
Route::get('/invoices', [App\Http\Controllers\api\InvoicesController::class, 'index']);

Route::post('/payment', [App\Http\Controllers\api\PaymentController::class, 'create'])
    ->middleware('content.type:application/json');
