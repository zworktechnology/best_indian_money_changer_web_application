<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Currency;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\CurrencyOptimal;
use App\Models\Payment;
use App\Models\PurchaseProduct;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Sale;
use App\Models\SaleProduct;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $today = Carbon::now()->format('Y-m-d');

            $total_purchase_amt_billing = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('grand_total');
            if($total_purchase_amt_billing != ""){
                $tot_purchaseAmount = $total_purchase_amt_billing;
            }else {
                $tot_purchaseAmount = '0';
            }

            $total_sale_amt_billing = Sale::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('grand_total');
            if($total_sale_amt_billing != ""){
                $tot_saleAmount = $total_sale_amt_billing;
            }else {
                $tot_saleAmount = '0';
            }

            $total_debit_amt_billing = Expense::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('amount');
            if($total_debit_amt_billing != ""){
                $tot_expense = $total_debit_amt_billing;
            }else {
                $tot_expense = '0';
            }


            $total_income_amt_billing = Income::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('amount');
            if($total_income_amt_billing != ""){
                $tot_income = $total_income_amt_billing;
            }else {
                $tot_income = '0';
            }

       

        $purchase_index_data = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();

        $Purchasedata = [];
        $products = [];
        foreach ($purchase_index_data as $key => $datas) {
            $customer = Customer::findOrFail($datas->customer_id);


            $PurchaseProduct = PurchaseProduct::where('purchase_id', '=', $datas->id)->orderBy('id', 'DESC')->get();
            foreach ($PurchaseProduct as $key => $PurchaseProduct_Arr) {

                $currency = Currency::findOrFail($PurchaseProduct_Arr->currency_id);
                $currency_optimal = CurrencyOptimal::findOrFail($PurchaseProduct_Arr->currency_optimal_id);
                $products[] = array(
                    'currencyoptimal_amount' => $PurchaseProduct_Arr->currencyoptimal_amount,
                    'doller_rate' => $PurchaseProduct_Arr->doller_rate,
                    'dollertotal' => $PurchaseProduct_Arr->dollertotal,
                    'count' => $PurchaseProduct_Arr->count,
                    'total' => $PurchaseProduct_Arr->total,
                    'code' => $currency->code,
                    'currency' => $currency->name,
                    'currency_optimal' => $currency_optimal->name,
                    'purchase_id' => $PurchaseProduct_Arr->purchase_id,

                );
            }

            $Purchasedata[] = array(
                'unique_id' => $datas->unique_id,
                'date' => $datas->date,
                'time' => $datas->time,
                'customer_id' => $datas->customer_id,
                'customer' => $customer->name,
                'grand_total' => $datas->grand_total,
                'oldbalanceamount' => $datas->oldbalanceamount,
                'overallamount' => $datas->overallamount,
                'paid_amount' => $datas->paid_amount,
                'balance_amount' => $datas->balance_amount,
                'billno' => $datas->billno,
                'note' => $datas->note,
                'id' => $datas->id,
                'products' => $products,
            );
        }


        $sale_index_data = Sale::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();

        $saledata = [];
        $saleproducts = [];
        foreach ($sale_index_data as $key => $sale_index_datas) {
            $customer = Customer::findOrFail($sale_index_datas->customer_id);


            $SaleProduct = SaleProduct::where('sales_id', '=', $sale_index_datas->id)->orderBy('id', 'DESC')->get();
            foreach ($SaleProduct as $key => $SaleProduct_arr) {

                $currency = Currency::findOrFail($SaleProduct_arr->currency_id);
                $currency_optimal = CurrencyOptimal::findOrFail($SaleProduct_arr->currency_optimal_id);
                $saleproducts[] = array(
                    'currencyoptimal_amount' => $SaleProduct_arr->currencyoptimal_amount,
                    'doller_rate' => $SaleProduct_arr->doller_rate,
                    'dollertotal' => $SaleProduct_arr->dollertotal,
                    'count' => $SaleProduct_arr->count,
                    'total' => $SaleProduct_arr->total,
                    'code' => $currency->code,
                    'currency' => $currency->name,
                    'currency_optimal' => $currency_optimal->name,
                    'sales_id' => $SaleProduct_arr->sales_id,

                );
            }

            $saledata[] = array(
                'unique_id' => $sale_index_datas->unique_id,
                'date' => $sale_index_datas->date,
                'time' => $sale_index_datas->time,
                'customer_id' => $sale_index_datas->customer_id,
                'customer' => $customer->name,
                'grand_total' => $sale_index_datas->grand_total,
                'oldbalanceamount' => $sale_index_datas->oldbalanceamount,
                'overallamount' => $sale_index_datas->overallamount,
                'paid_amount' => $sale_index_datas->paid_amount,
                'balance_amount' => $sale_index_datas->balance_amount,
                'billno' => $sale_index_datas->billno,
                'note' => $sale_index_datas->note,
                'id' => $sale_index_datas->id,
                'saleproducts' => $saleproducts,
            );
        }



        $expense_index_data = Expense::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();
        $income_index_data = Income::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();


            return view('home', compact('today', 'tot_purchaseAmount', 'tot_saleAmount', 'tot_expense', 'tot_income', 'Purchasedata', 'saledata', 'expense_index_data', 'income_index_data'));
    }



    public function datefilter(Request $request) {
        $today = $request->get('from_date');


        $total_purchase_amt_billing = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('grand_total');
        if($total_purchase_amt_billing != ""){
            $tot_purchaseAmount = $total_purchase_amt_billing;
        }else {
            $tot_purchaseAmount = '0';
        }

        $total_sale_amt_billing = Sale::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('grand_total');
        if($total_sale_amt_billing != ""){
            $tot_saleAmount = $total_sale_amt_billing;
        }else {
            $tot_saleAmount = '0';
        }

        $total_debit_amt_billing = Expense::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('amount');
        if($total_debit_amt_billing != ""){
            $tot_expense = $total_debit_amt_billing;
        }else {
            $tot_expense = '0';
        }


        $total_income_amt_billing = Income::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('amount');
        if($total_income_amt_billing != ""){
            $tot_income = $total_income_amt_billing;
        }else {
            $tot_income = '0';
        }


        $purchase_index_data = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();

        $Purchasedata = [];
        $products = [];
        foreach ($purchase_index_data as $key => $datas) {
            $customer = Customer::findOrFail($datas->customer_id);


            $PurchaseProduct = PurchaseProduct::where('purchase_id', '=', $datas->id)->orderBy('id', 'DESC')->get();
            foreach ($PurchaseProduct as $key => $PurchaseProduct_Arr) {

                $currency = Currency::findOrFail($PurchaseProduct_Arr->currency_id);
                $currency_optimal = CurrencyOptimal::findOrFail($PurchaseProduct_Arr->currency_optimal_id);
                $products[] = array(
                    'currencyoptimal_amount' => $PurchaseProduct_Arr->currencyoptimal_amount,
                    'doller_rate' => $PurchaseProduct_Arr->doller_rate,
                    'dollertotal' => $PurchaseProduct_Arr->dollertotal,
                    'count' => $PurchaseProduct_Arr->count,
                    'total' => $PurchaseProduct_Arr->total,
                    'code' => $currency->code,
                    'currency' => $currency->name,
                    'currency_optimal' => $currency_optimal->name,
                    'purchase_id' => $PurchaseProduct_Arr->purchase_id,

                );
            }

            $Purchasedata[] = array(
                'unique_id' => $datas->unique_id,
                'date' => $datas->date,
                'time' => $datas->time,
                'customer_id' => $datas->customer_id,
                'customer' => $customer->name,
                'grand_total' => $datas->grand_total,
                'oldbalanceamount' => $datas->oldbalanceamount,
                'overallamount' => $datas->overallamount,
                'paid_amount' => $datas->paid_amount,
                'balance_amount' => $datas->balance_amount,
                'billno' => $datas->billno,
                'note' => $datas->note,
                'id' => $datas->id,
                'products' => $products,
            );
        }


        $sale_index_data = Sale::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();

        $saledata = [];
        $saleproducts = [];
        foreach ($sale_index_data as $key => $sale_index_datas) {
            $customer = Customer::findOrFail($sale_index_datas->customer_id);


            $SaleProduct = SaleProduct::where('sales_id', '=', $sale_index_datas->id)->orderBy('id', 'DESC')->get();
            foreach ($SaleProduct as $key => $SaleProduct_arr) {

                $currency = Currency::findOrFail($SaleProduct_arr->currency_id);
                $currency_optimal = CurrencyOptimal::findOrFail($SaleProduct_arr->currency_optimal_id);
                $saleproducts[] = array(
                    'currencyoptimal_amount' => $SaleProduct_arr->currencyoptimal_amount,
                    'doller_rate' => $SaleProduct_arr->doller_rate,
                    'dollertotal' => $SaleProduct_arr->dollertotal,
                    'count' => $SaleProduct_arr->count,
                    'total' => $SaleProduct_arr->total,
                    'code' => $currency->code,
                    'currency' => $currency->name,
                    'currency_optimal' => $currency_optimal->name,
                    'sales_id' => $SaleProduct_arr->sales_id,

                );
            }

            $saledata[] = array(
                'unique_id' => $sale_index_datas->unique_id,
                'date' => $sale_index_datas->date,
                'time' => $sale_index_datas->time,
                'customer_id' => $sale_index_datas->customer_id,
                'customer' => $customer->name,
                'grand_total' => $sale_index_datas->grand_total,
                'oldbalanceamount' => $sale_index_datas->oldbalanceamount,
                'overallamount' => $sale_index_datas->overallamount,
                'paid_amount' => $sale_index_datas->paid_amount,
                'balance_amount' => $sale_index_datas->balance_amount,
                'billno' => $sale_index_datas->billno,
                'note' => $sale_index_datas->note,
                'id' => $sale_index_datas->id,
                'saleproducts' => $saleproducts,
            );
        }


        $expense_index_data = Expense::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();
        $income_index_data = Income::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();


        return view('home', compact('today', 'tot_purchaseAmount', 'tot_saleAmount', 'tot_expense', 'tot_income', 'Purchasedata', 'saledata', 'expense_index_data', 'income_index_data'));
    }
}
