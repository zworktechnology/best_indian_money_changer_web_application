<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Sale;
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
        $sale_index_data = Sale::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();
        $expense_index_data = Expense::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();
        $income_index_data = Income::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();


            return view('home', compact('today', 'tot_purchaseAmount', 'tot_saleAmount', 'tot_expense', 'tot_income', 'purchase_index_data', 'sale_index_data', 'expense_index_data', 'income_index_data'));
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
        $sale_index_data = Sale::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();
        $expense_index_data = Expense::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();
        $income_index_data = Income::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();


        return view('home', compact('today', 'tot_purchaseAmount', 'tot_saleAmount', 'tot_expense', 'tot_income', 'purchase_index_data', 'sale_index_data', 'expense_index_data', 'income_index_data'));
    }
}
