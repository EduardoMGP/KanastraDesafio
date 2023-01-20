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

Route::post('/invoices', [App\Http\Controllers\Api\InvoicesController::class, 'create'])
    ->middleware('content.type:text/plain');

Route::get('/invoices', [App\Http\Controllers\Api\InvoicesController::class, 'index']);
Route::get('/invoice/{id}', [App\Http\Controllers\Api\InvoicesController::class, 'view']);
Route::post('/invoice/upload', [App\Http\Controllers\Api\InvoicesController::class, 'uploadFile'])->name('upload-csv');

Route::post('/payment', [App\Http\Controllers\Api\PaymentController::class, 'create']);

Route::get('/payment/{debtId}', [App\Http\Controllers\Api\PaymentController::class, 'payments']);
