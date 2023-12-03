<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PurchaseController;
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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // DASHBOARD
    Route::middleware(['auth:sanctum', 'verified'])->get('/home', [HomeController::class, 'index'])->name('home');
});
// CURRENCY CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zwork_technology/currency', [CurrencyController::class, 'index'])->name('currency.index');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/currency/store', [CurrencyController::class, 'store'])->name('currency.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/currency/edit/{unique_id}', [CurrencyController::class, 'edit'])->name('currency.edit');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/currency/delete/{unique_id}', [CurrencyController::class, 'delete'])->name('currency.delete');
});
// PURCHASE CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zwork_technology/purchase', [PurchaseController::class, 'index'])->name('purchase.index');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/purchase/store', [PurchaseController::class, 'store'])->name('purchase.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/purchase/edit/{unique_id}', [PurchaseController::class, 'edit'])->name('purchase.edit');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/purchase/delete/{unique_id}', [PurchaseController::class, 'delete'])->name('purchase.delete');
});
