<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Purchase;
use App\Models\Quotation;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Expense;
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

        $total_quotation_amt_billing = Quotation::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('grand_total');
            if($total_quotation_amt_billing != ""){
                $tot_quotationAmount = $total_quotation_amt_billing;
            }else {
                $tot_quotationAmount = '0';
            }


        $total_bill_amt_billing = Bill::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('bill_grand_total');
            if($total_bill_amt_billing != ""){
                $tot_billAmount = $total_bill_amt_billing;
            }else {
                $tot_billAmount = '0';
            }


        $total_purchase_amt_billing = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('purchase_grandtotal');
            if($total_purchase_amt_billing != ""){
                $tot_purchaseAmount = $total_purchase_amt_billing;
            }else {
                $tot_purchaseAmount = '0';
            }

        $total_expense_amt_billing = Expense::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('grand_total');
            if($total_expense_amt_billing != ""){
                $tot_expenseAmount = $total_expense_amt_billing;
            }else {
                $tot_expenseAmount = '0';
            }



        $bill_recents = Bill::where('soft_delete', '!=', 1)->where('date', '=', $today)->get();
        $bill_arr = [];
        foreach ($bill_recents as $key => $bill_recentsarr) {

            $customer = Customer::findOrFail($bill_recentsarr->customer_id);

            $bill_arr[] = array(
                'billno' => $bill_recentsarr->billno,
                'customer' => $customer->name,
                'bill_grand_total' => $bill_recentsarr->bill_grand_total,
                'bill_paid_amount' => $bill_recentsarr->bill_paid_amount,
            );
        }


        $Purchase_recents = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $today)->get();
        $purhcase_arr = [];
        foreach ($Purchase_recents as $key => $Purchase_recentsarr) {

            $Vendor = Vendor::findOrFail($Purchase_recentsarr->vendor_id);

            $purhcase_arr[] = array(
                'vocher_number' => $Purchase_recentsarr->vocher_number,
                'Vendor' => $Vendor->name,
                'purchase_grandtotal' => $Purchase_recentsarr->purchase_grandtotal,
                'purchase_paidamount' => $Purchase_recentsarr->purchase_paidamount,
            );
        }


        $Expense_recents = Expense::where('soft_delete', '!=', 1)->where('date', '=', $today)->get();
        $expense_arr = [];
        foreach ($Expense_recents as $key => $Expense_recentsarr) {

            $expense_arr[] = array(
                'expence_number' => $Expense_recentsarr->expence_number,
                'grand_total' => $Expense_recentsarr->grand_total,
                'add_on_note' => $Expense_recentsarr->add_on_note,
            );
        }

            return view('home', compact('today', 'tot_quotationAmount', 'tot_billAmount', 'tot_purchaseAmount', 'tot_expenseAmount', 'bill_arr', 'purhcase_arr', 'expense_arr'));
    }



    public function datefilter(Request $request) {

        $today = $request->get('from_date');

        $total_quotation_amt_billing = Quotation::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('grand_total');
            if($total_quotation_amt_billing != ""){
                $tot_quotationAmount = $total_quotation_amt_billing;
            }else {
                $tot_quotationAmount = '0';
            }


        $total_bill_amt_billing = Bill::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('bill_grand_total');
            if($total_bill_amt_billing != ""){
                $tot_billAmount = $total_bill_amt_billing;
            }else {
                $tot_billAmount = '0';
            }


        $total_purchase_amt_billing = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('purchase_grandtotal');
            if($total_purchase_amt_billing != ""){
                $tot_purchaseAmount = $total_purchase_amt_billing;
            }else {
                $tot_purchaseAmount = '0';
            }

        $total_expense_amt_billing = Expense::where('soft_delete', '!=', 1)->where('date', '=', $today)->sum('grand_total');
            if($total_expense_amt_billing != ""){
                $tot_expenseAmount = $total_expense_amt_billing;
            }else {
                $tot_expenseAmount = '0';
            }


            $bill_recents = Bill::where('soft_delete', '!=', 1)->where('date', '=', $today)->get();
            $bill_arr = [];
            foreach ($bill_recents as $key => $bill_recentsarr) {
    
                $customer = Customer::findOrFail($bill_recentsarr->customer_id);
    
                $bill_arr[] = array(
                    'billno' => $bill_recentsarr->billno,
                    'customer' => $customer->name,
                    'bill_grand_total' => $bill_recentsarr->bill_grand_total,
                    'bill_paid_amount' => $bill_recentsarr->bill_paid_amount,
                );
            }
    
    
            $Purchase_recents = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $today)->get();
            $purhcase_arr = [];
            foreach ($Purchase_recents as $key => $Purchase_recentsarr) {
    
                $Vendor = Vendor::findOrFail($Purchase_recentsarr->vendor_id);
    
                $purhcase_arr[] = array(
                    'vocher_number' => $Purchase_recentsarr->vocher_number,
                    'Vendor' => $Vendor->name,
                    'purchase_grandtotal' => $Purchase_recentsarr->purchase_grandtotal,
                    'purchase_paidamount' => $Purchase_recentsarr->purchase_paidamount,
                );
            }


    
            $Expense_recents = Expense::where('soft_delete', '!=', 1)->where('date', '=', $today)->get();
            $expense_arr = [];
            foreach ($Expense_recents as $key => $Expense_recentsarr) {

                $expense_arr[] = array(
                    'expence_number' => $Expense_recentsarr->expence_number,
                    'grand_total' => $Expense_recentsarr->grand_total,
                    'add_on_note' => $Expense_recentsarr->add_on_note,
                );
            }

            return view('home', compact('today', 'tot_quotationAmount', 'tot_billAmount', 'tot_purchaseAmount', 'tot_expenseAmount', 'bill_arr', 'purhcase_arr', 'expense_arr'));
    }
}
