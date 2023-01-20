<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::get('/pagamentos', [\App\Http\Controllers\DashboardController::class, 'payments'])->name('pagamentos');
Route::get('/emails', [\App\Http\Controllers\DashboardController::class, 'emailsQueue'])->name('emails-queue');
Route::get('/faturas', [\App\Http\Controllers\DashboardController::class, 'invoices'])->name('faturas');
