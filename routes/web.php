<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddonController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CustomerPaymentController;
use App\Http\Controllers\VendorPaymentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\FrontendController;
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
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // DASHBOARD
    Route::middleware(['auth:sanctum', 'verified'])->get('/home', [HomeController::class, 'index'])->name('home');

    // DASHBOARD FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-anandtraders/home/datefilter', [App\Http\Controllers\HomeController::class, 'datefilter'])->name('home.datefilter');
});
