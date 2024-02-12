<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CurrencyOptimalController;
use App\Http\Controllers\CustomerController;
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
    // DASHBOARD FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/home/datefilter', [HomeController::class, 'datefilter'])->name('home.datefilter');
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
    // DATAE FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/currency/datefilter', [CurrencyController::class, 'datefilter'])->name('currency.datefilter');
});

// CURRENCY OPTIMAL CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zwork_technology/currency_optimal', [CurrencyOptimalController::class, 'index'])->name('currency_optimal.index');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/currency_optimal/store', [CurrencyOptimalController::class, 'store'])->name('currency_optimal.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/currency_optimal/edit/{id}', [CurrencyOptimalController::class, 'edit'])->name('currency_optimal.edit');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/currency_optimal/delete/{id}', [CurrencyOptimalController::class, 'delete'])->name('currency_optimal.delete');
});



// CUSTOMER CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zwork_technology/customer', [CustomerController::class, 'index'])->name('customer.index');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/customer/store', [CustomerController::class, 'store'])->name('customer.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
    // CHECK DUPLICATE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/customer/checkduplicate', [CustomerController::class, 'checkduplicate'])->name('customer.checkduplicate');
});



// SALE CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zwork_technology/sale', [SaleController::class, 'index'])->name('sale.index');
    // CREATE
    Route::middleware(['auth:sanctum', 'verified'])->get('/zwork_technology/sale/create', [SaleController::class, 'create'])->name('sale.create');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/sale/store', [SaleController::class, 'store'])->name('sale.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->get('/zwork_technology/sale/edit/{unique_id}', [SaleController::class, 'edit'])->name('sale.edit');
    // UPDATE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/sale/update/{unique_id}', [SaleController::class, 'update'])->name('sale.update');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/sale/delete/{unique_id}', [SaleController::class, 'delete'])->name('sale.delete');
    // DATAE FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/sale/datefilter', [SaleController::class, 'datefilter'])->name('sale.datefilter');
});


// PURCHASE CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zwork_technology/purchase', [PurchaseController::class, 'index'])->name('purchase.index');
    // CREATE
    Route::middleware(['auth:sanctum', 'verified'])->get('/zwork_technology/purchase/create', [PurchaseController::class, 'create'])->name('purchase.create');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/purchase/store', [PurchaseController::class, 'store'])->name('purchase.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->get('/zwork_technology/purchase/edit/{unique_id}', [PurchaseController::class, 'edit'])->name('purchase.edit');
    // UPDATE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/purchase/update/{unique_id}', [PurchaseController::class, 'update'])->name('purchase.update');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/purchase/delete/{unique_id}', [PurchaseController::class, 'delete'])->name('purchase.delete');
    // DATAE FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/purchase/datefilter', [PurchaseController::class, 'datefilter'])->name('purchase.datefilter');
});
// EXPENSE CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zwork_technology/expense', [ExpenseController::class, 'index'])->name('expense.index');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/expense/store', [ExpenseController::class, 'store'])->name('expense.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/expense/edit/{unique_id}', [ExpenseController::class, 'edit'])->name('expense.edit');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/expense/delete/{unique_id}', [ExpenseController::class, 'delete'])->name('expense.delete');
    // DATAE FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/expense/datefilter', [ExpenseController::class, 'datefilter'])->name('expense.datefilter');
});
// INCOME CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zwork_technology/income', [IncomeController::class, 'index'])->name('income.index');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/income/store', [IncomeController::class, 'store'])->name('income.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->post('/zwork_technology/income/edit/{unique_id}', [IncomeController::class, 'edit'])->name('income.edit');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/income/delete/{unique_id}', [IncomeController::class, 'delete'])->name('income.delete');
    // DATAE FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zwork_technology/income/datefilter', [IncomeController::class, 'datefilter'])->name('income.datefilter');
});


Route::get('getcurrencies/', [CurrencyController::class, 'getcurrencies']);
Route::get('getcurrencyamount/{currency_id}', [CurrencyOptimalController::class, 'getcurrencyamount']);
Route::get('getcurrencyoptimalamount/{currency_optimal_id}', [CurrencyOptimalController::class, 'getcurrencyoptimalamount']);
Route::get('/getoldbalance', [CustomerController::class, 'getoldbalance']);
Route::get('/getoldbalanceforsales', [CustomerController::class, 'getoldbalanceforsales']);
