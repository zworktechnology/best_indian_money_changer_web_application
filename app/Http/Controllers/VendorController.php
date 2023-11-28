<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\PaymentBalance;
use App\Models\Purchase;
use App\Models\VendorPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;

class VendorController extends Controller
{
    public function index()
    {
        $data = Vendor::where('soft_delete', '!=', 1)->orderBy('id', 'DESC')->get();

        $Vendor_data = [];
        foreach ($data as $key => $datas) {

            $PaymentBalanceAmount = PaymentBalance::where('vendor_id', '=', $datas->id)->first();
            if($PaymentBalanceAmount != ""){
                $vendor_bal = $PaymentBalanceAmount->vendor_balance;
            }else {
                $vendor_bal = '0';
            }

            $Vendor_data[] = array(
                'name' => $datas->name,
                'unique_key' => $datas->unique_key,
                'address' => $datas->address,
                'phone_number' => $datas->phone_number,
                'email_id' => $datas->email_id,
                'id' => $datas->id,
                'shop_name' => $datas->shop_name,
                'vendor_balance' => $vendor_bal,
            );

        }
        return view('page.backend.vendor.index', compact('Vendor_data'));
    }


    public function store(Request $request)
    {
        $randomkey = Str::random(5);

        $data = new Vendor();

        $data->unique_key = $randomkey;
        $data->name = $request->get('name');
        $data->address = $request->get('address');
        $data->phone_number = $request->get('phone_number');
        $data->email_id = $request->get('email_id');
        $data->shop_name = $request->get('shop_name');
        $data->balance_amount = $request->get('balance_amount');

        $data->save();


        $vendorid = $data->id;
        $PaymentBalanceDAta = PaymentBalance::where('vendor_id', '=', $vendorid)->first();
        if($PaymentBalanceDAta == ""){
            $balance_amount = $request->get('balance_amount');
            $paymentbalacedata = new PaymentBalance();

            $paymentbalacedata->vendor_id = $vendorid;
            $paymentbalacedata->vendor_amount = $balance_amount;
            $paymentbalacedata->vendor_paid = 0;
            $paymentbalacedata->vendor_balance = $balance_amount;
            $paymentbalacedata->save();
        }


        return redirect()->route('vendor.index')->with('message', 'Added !');
    }


    public function edit(Request $request, $unique_key)
    {
        $VendorData = Vendor::where('unique_key', '=', $unique_key)->first();

        $VendorData->name = $request->get('name');
        $VendorData->address = $request->get('address');
        $VendorData->phone_number = $request->get('phone_number');
        $VendorData->email_id = $request->get('email_id');
        $VendorData->shop_name = $request->get('shop_name');

        $VendorData->update();

        return redirect()->route('vendor.index')->with('info', 'Updated !');
    }


    public function view($unique_key)
    {
        $VendorData = Vendor::where('unique_key', '=', $unique_key)->first();
        $today = Carbon::now()->format('Y-m-d');

        $data = Purchase::where('vendor_id', '=', $VendorData->id)->where('soft_delete', '!=', 1)->get();
        $Purchase_data = [];
        foreach ($data as $key => $datas) {


            $Purchase_data[] = array(
                'unique_key' => $datas->unique_key,
                'id' => $datas->id,
                'purchase_number' => $datas->purchase_number,
                'vocher_number' => $datas->vocher_number,
                'date' => $datas->date,
                'purchase_subtotal' => $datas->purchase_subtotal,
                'purchase_discountprice' => $datas->purchase_discountprice,
                'purchase_totalamount' => $datas->purchase_totalamount,
                'purchase_taxamount' => $datas->purchase_taxamount,
                'purchase_taxpercentage' => $datas->purchase_taxpercentage,
                'purchase_extracostamount' => $datas->purchase_extracostamount,
                'purchase_grandtotal' => $datas->purchase_grandtotal,
                'purchase_paidamount' => $datas->purchase_paidamount,
                'purchase_balanceamount' => $datas->purchase_balanceamount,
            );
        }



        

        $paymentdata = VendorPayment::where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->orderBy('id', 'DESC')->get();
        if($paymentdata){

            $PaymentData = [];
            foreach ($paymentdata as $key => $paymentdatas) {
    
                $PaymentData[] = array(
                    'unique_key' => $paymentdatas->unique_key,
                    'id' => $paymentdatas->id,
                    'date' => $paymentdatas->date,
                    'time' => $paymentdatas->time,
                    'oldblance' => $paymentdatas->oldblance,
                    'discount' => $paymentdatas->discount,
                    'totalamount' => $paymentdatas->totalamount,
                    'paid_amount' => $paymentdatas->paid_amount,
                    'payment_pending' => $paymentdatas->payment_pending,
                    'note' => $paymentdatas->note,
                );
    
            }
        }else {
            $PaymentData = '';
        }
        



            $total_purchaseamount = Purchase::where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('purchase_grandtotal');
            if($total_purchaseamount != ""){
                $totpurchaseamount = $total_purchaseamount;
            }else {
                $totpurchaseamount = '0';
            }


            // Total Paid
            $total_paid = Purchase::where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('purchase_paidamount');
            if($total_paid != ""){
                $total_paid_Amount = $total_paid;
            }else {
                $total_paid_Amount = '0';
            }
            $payment_total_paid = VendorPayment::where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('paid_amount');
            if($payment_total_paid != ""){
                $total_payment_paid = $payment_total_paid;
            }else {
                $total_payment_paid = '0';
            }


            $payment_discount = VendorPayment::where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('discount');
            if($payment_discount != ""){
                $totpayment_discount = $payment_discount;
            }else {
                $totpayment_discount = '0';
            }
            $total_amount_paid = $total_paid_Amount + $total_payment_paid + $totpayment_discount;

            $total_balance = $totpurchaseamount - $total_amount_paid;


            $fromdate = '';
            $todate = '';

        return view('page.backend.vendor.view', compact('VendorData', 'today', 'Purchase_data', 'totpurchaseamount', 'total_amount_paid', 'total_balance', 'PaymentData', 'fromdate', 'todate'));
    }




    public function viewfilter(Request $request, $unique_key)
    {
        $fromdate = $request->get('fromdate');
        $todate = $request->get('todate');
        $today = Carbon::now()->format('Y-m-d');
        $VendorData = Vendor::where('unique_key', '=', $unique_key)->first();

        if($fromdate){
            $data = Purchase::where('date', '=', $fromdate)->where('vendor_id', '=', $VendorData->id)->where('soft_delete', '!=', 1)->get();
            $Purchase_data = [];
            foreach ($data as $key => $datas) {
    
    
                $Purchase_data[] = array(
                    'unique_key' => $datas->unique_key,
                    'id' => $datas->id,
                    'purchase_number' => $datas->purchase_number,
                    'vocher_number' => $datas->vocher_number,
                    'date' => $datas->date,
                    'purchase_subtotal' => $datas->purchase_subtotal,
                    'purchase_discountprice' => $datas->purchase_discountprice,
                    'purchase_totalamount' => $datas->purchase_totalamount,
                    'purchase_taxamount' => $datas->purchase_taxamount,
                    'purchase_taxpercentage' => $datas->purchase_taxpercentage,
                    'purchase_extracostamount' => $datas->purchase_extracostamount,
                    'purchase_grandtotal' => $datas->purchase_grandtotal,
                    'purchase_paidamount' => $datas->purchase_paidamount,
                    'purchase_balanceamount' => $datas->purchase_balanceamount,
                );
            }
    
    
    
            
    
            $paymentdata = VendorPayment::where('date', '=', $fromdate)->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->orderBy('id', 'DESC')->get();
            if($paymentdata){
    
                $PaymentData = [];
                foreach ($paymentdata as $key => $paymentdatas) {
        
                    $PaymentData[] = array(
                        'unique_key' => $paymentdatas->unique_key,
                        'id' => $paymentdatas->id,
                        'date' => $paymentdatas->date,
                        'time' => $paymentdatas->time,
                        'oldblance' => $paymentdatas->oldblance,
                        'discount' => $paymentdatas->discount,
                        'totalamount' => $paymentdatas->totalamount,
                        'paid_amount' => $paymentdatas->paid_amount,
                        'payment_pending' => $paymentdatas->payment_pending,
                        'note' => $paymentdatas->note,
                    );
        
                }
            }else {
                $PaymentData = '';
            }
            
    
    
    
                $total_purchaseamount = Purchase::where('date', '=', $fromdate)->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('purchase_grandtotal');
                if($total_purchaseamount != ""){
                    $totpurchaseamount = $total_purchaseamount;
                }else {
                    $totpurchaseamount = '0';
                }
    
    
                // Total Paid
                $total_paid = Purchase::where('date', '=', $fromdate)->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('purchase_paidamount');
                if($total_paid != ""){
                    $total_paid_Amount = $total_paid;
                }else {
                    $total_paid_Amount = '0';
                }
                $payment_total_paid = VendorPayment::where('date', '=', $fromdate)->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('paid_amount');
                if($payment_total_paid != ""){
                    $total_payment_paid = $payment_total_paid;
                }else {
                    $total_payment_paid = '0';
                }
    
    
                $payment_discount = VendorPayment::where('date', '=', $fromdate)->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('discount');
                if($payment_discount != ""){
                    $totpayment_discount = $payment_discount;
                }else {
                    $totpayment_discount = '0';
                }
                $total_amount_paid = $total_paid_Amount + $total_payment_paid + $totpayment_discount;
    
                $total_balance = $totpurchaseamount - $total_amount_paid;
        }


        if($todate){
            $data = Purchase::where('date', '=', $todate)->where('vendor_id', '=', $VendorData->id)->where('soft_delete', '!=', 1)->get();
            $Purchase_data = [];
            foreach ($data as $key => $datas) {
    
    
                $Purchase_data[] = array(
                    'unique_key' => $datas->unique_key,
                    'id' => $datas->id,
                    'purchase_number' => $datas->purchase_number,
                    'vocher_number' => $datas->vocher_number,
                    'date' => $datas->date,
                    'purchase_subtotal' => $datas->purchase_subtotal,
                    'purchase_discountprice' => $datas->purchase_discountprice,
                    'purchase_totalamount' => $datas->purchase_totalamount,
                    'purchase_taxamount' => $datas->purchase_taxamount,
                    'purchase_taxpercentage' => $datas->purchase_taxpercentage,
                    'purchase_extracostamount' => $datas->purchase_extracostamount,
                    'purchase_grandtotal' => $datas->purchase_grandtotal,
                    'purchase_paidamount' => $datas->purchase_paidamount,
                    'purchase_balanceamount' => $datas->purchase_balanceamount,
                );
            }
    
    
    
            
    
            $paymentdata = VendorPayment::where('date', '=', $todate)->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->orderBy('id', 'DESC')->get();
            if($paymentdata){
    
                $PaymentData = [];
                foreach ($paymentdata as $key => $paymentdatas) {
        
                    $PaymentData[] = array(
                        'unique_key' => $paymentdatas->unique_key,
                        'id' => $paymentdatas->id,
                        'date' => $paymentdatas->date,
                        'time' => $paymentdatas->time,
                        'oldblance' => $paymentdatas->oldblance,
                        'discount' => $paymentdatas->discount,
                        'totalamount' => $paymentdatas->totalamount,
                        'paid_amount' => $paymentdatas->paid_amount,
                        'payment_pending' => $paymentdatas->payment_pending,
                        'note' => $paymentdatas->note,
                    );
        
                }
            }else {
                $PaymentData = '';
            }
            
    
    
    
                $total_purchaseamount = Purchase::where('date', '=', $todate)->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('purchase_grandtotal');
                if($total_purchaseamount != ""){
                    $totpurchaseamount = $total_purchaseamount;
                }else {
                    $totpurchaseamount = '0';
                }
    
    
                // Total Paid
                $total_paid = Purchase::where('date', '=', $todate)->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('purchase_paidamount');
                if($total_paid != ""){
                    $total_paid_Amount = $total_paid;
                }else {
                    $total_paid_Amount = '0';
                }
                $payment_total_paid = VendorPayment::where('date', '=', $todate)->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('paid_amount');
                if($payment_total_paid != ""){
                    $total_payment_paid = $payment_total_paid;
                }else {
                    $total_payment_paid = '0';
                }
    
    
                $payment_discount = VendorPayment::where('date', '=', $fromdate)->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('discount');
                if($payment_discount != ""){
                    $totpayment_discount = $payment_discount;
                }else {
                    $totpayment_discount = '0';
                }
                $total_amount_paid = $total_paid_Amount + $total_payment_paid + $totpayment_discount;
    
                $total_balance = $totpurchaseamount - $total_amount_paid;
        }



        if($fromdate && $todate){
            $data = Purchase::whereBetween('date', [$fromdate, $todate])->where('vendor_id', '=', $VendorData->id)->where('soft_delete', '!=', 1)->get();
            $Purchase_data = [];
            foreach ($data as $key => $datas) {
    
    
                $Purchase_data[] = array(
                    'unique_key' => $datas->unique_key,
                    'id' => $datas->id,
                    'purchase_number' => $datas->purchase_number,
                    'vocher_number' => $datas->vocher_number,
                    'date' => $datas->date,
                    'purchase_subtotal' => $datas->purchase_subtotal,
                    'purchase_discountprice' => $datas->purchase_discountprice,
                    'purchase_totalamount' => $datas->purchase_totalamount,
                    'purchase_taxamount' => $datas->purchase_taxamount,
                    'purchase_taxpercentage' => $datas->purchase_taxpercentage,
                    'purchase_extracostamount' => $datas->purchase_extracostamount,
                    'purchase_grandtotal' => $datas->purchase_grandtotal,
                    'purchase_paidamount' => $datas->purchase_paidamount,
                    'purchase_balanceamount' => $datas->purchase_balanceamount,
                );
            }
    
    
    
            
    
            $paymentdata = VendorPayment::whereBetween('date', [$fromdate, $todate])->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->orderBy('id', 'DESC')->get();
            if($paymentdata){
    
                $PaymentData = [];
                foreach ($paymentdata as $key => $paymentdatas) {
        
                    $PaymentData[] = array(
                        'unique_key' => $paymentdatas->unique_key,
                        'id' => $paymentdatas->id,
                        'date' => $paymentdatas->date,
                        'time' => $paymentdatas->time,
                        'oldblance' => $paymentdatas->oldblance,
                        'discount' => $paymentdatas->discount,
                        'totalamount' => $paymentdatas->totalamount,
                        'paid_amount' => $paymentdatas->paid_amount,
                        'payment_pending' => $paymentdatas->payment_pending,
                        'note' => $paymentdatas->note,
                    );
        
                }
            }else {
                $PaymentData = '';
            }
            
    
    
    
                $total_purchaseamount = Purchase::whereBetween('date', [$fromdate, $todate])->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('purchase_grandtotal');
                if($total_purchaseamount != ""){
                    $totpurchaseamount = $total_purchaseamount;
                }else {
                    $totpurchaseamount = '0';
                }
    
    
                // Total Paid
                $total_paid = Purchase::whereBetween('date', [$fromdate, $todate])->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('purchase_paidamount');
                if($total_paid != ""){
                    $total_paid_Amount = $total_paid;
                }else {
                    $total_paid_Amount = '0';
                }
                $payment_total_paid = VendorPayment::whereBetween('date', [$fromdate, $todate])->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('paid_amount');
                if($payment_total_paid != ""){
                    $total_payment_paid = $payment_total_paid;
                }else {
                    $total_payment_paid = '0';
                }
    
    
                $payment_discount = VendorPayment::whereBetween('date', [$fromdate, $todate])->where('soft_delete', '!=', 1)->where('vendor_id', '=', $VendorData->id)->sum('discount');
                if($payment_discount != ""){
                    $totpayment_discount = $payment_discount;
                }else {
                    $totpayment_discount = '0';
                }
                $total_amount_paid = $total_paid_Amount + $total_payment_paid + $totpayment_discount;
    
                $total_balance = $totpurchaseamount - $total_amount_paid;
        }


        return view('page.backend.vendor.view', compact('VendorData', 'today', 'Purchase_data', 'totpurchaseamount', 'total_amount_paid', 'total_balance', 'PaymentData', 'fromdate', 'todate'));
    }


    public function delete($unique_key)
    {
        $data = Vendor::where('unique_key', '=', $unique_key)->first();

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('vendor.index')->with('warning', 'Deleted !');
    }


    public function checkduplicate(Request $request)
    {
        if(request()->get('query'))
        {
            $query = request()->get('query');
            $supplierdata = Vendor::where('phone_number', '=', $query)->first();

            $userData['data'] = $supplierdata;
            echo json_encode($userData);
        }
    }



    public function allvendor_pdfexport () 
    {
        $data = Vendor::where('soft_delete', '!=', 1)->get();
        $Vendorarr_data = [];
        foreach ($data as $key => $datas) {

            $purchaseamount = Purchase::where('soft_delete', '!=', 1)->where('vendor_id', '=', $datas->id)->sum('purchase_grandtotal');
            if($purchaseamount != ""){
                $purchase_totalamount = $purchaseamount;
            }else {
                $purchase_totalamount = '0';
            }



            $Vendorarr_data[] = array(
                'unique_key' => $datas->unique_key,
                'name' => $datas->name,
                'address' => $datas->address,
                'phone_number' => $datas->phone_number,
                'email_id' => $datas->email_id,
                'id' => $datas->id,
                'purchase_totalamount' => $purchase_totalamount,
            );
        }



        $pdf = Pdf::loadView('page.backend.vendor.allvendorpdfexport_view', [
            'Vendorarr_data' => $Vendorarr_data,
        ]);
        $name = 'Vendors.' . 'pdf';
        return $pdf->stream($name);
    }




    public function vendorview_pdfexport($unique_key, $fromdate, $todate) 
    {
        $GetVendor = Vendor::where('unique_key', '=', $unique_key)->first();


        if($fromdate && $todate){
            
            $vendorarr_data = [];
            $purchaseexportdate_arr = [];

            $PurchaseData = Purchase::whereBetween('date', [$fromdate, $todate])->where('vendor_id', '=', $GetVendor->id)->where('soft_delete', '!=', 1)->get();
            if($PurchaseData != ""){
                foreach ($PurchaseData as $key => $PurchaseData_Arr) {
                    $purchaseexportdate_arr[] = $PurchaseData_Arr->date;
                }
            }

            $paymentexportdate_arr = [];
            $VendorPaymentdata = VendorPayment::whereBetween('date', [$fromdate, $todate])->where('vendor_id', '=', $GetVendor->id)->where('soft_delete', '!=', 1)->get();
            if($VendorPaymentdata != ""){
                foreach ($VendorPaymentdata as $key => $VendorPsaymentdata) {
                    $paymentexportdate_arr[] = $VendorPsaymentdata->date;
                }
            }


            $date_arr = array_merge($purchaseexportdate_arr, $paymentexportdate_arr);
            usort($date_arr, function ($a, $b) {
                $dateTimestamp1 = strtotime($a);
                $dateTimestamp2 = strtotime($b);
    
                return $dateTimestamp1 < $dateTimestamp2 ? 1 : -1;
            });
            foreach (array_unique($date_arr) as $key => $date_array) {

                $Purchasedatearr = Purchase::where('date', '=', $date_array)->where('vendor_id', '=', $GetVendor->id)->where('soft_delete', '!=', 1)->get();

                $VendorPaymentdatearr = VendorPayment::where('date', '=', $date_array)->where('vendor_id', '=', $GetVendor->id)->where('soft_delete', '!=', 1)->get();

                $merged = $VendorPaymentdatearr->merge($Purchasedatearr);

                $result = $merged->all();

                foreach ($result as $key => $mergearrays) {

                   if($mergearrays->purchase_number != ""){
                        $purchase_number = $mergearrays->purchase_number;
                        $Vouchertype = 'PURCHASE';
                        $debit = $mergearrays->purchase_grandtotal;
                        $credit = $mergearrays->purchase_paidamount;
                   }else {
                        $purchase_number = '';
                        $Vouchertype = 'Receipts';
                        $debit = '';
                        $credit = $mergearrays->paid_amount;
                   }

                    $vendorarr_data[] = array(
                        'purchase_number' => $purchase_number,
                        'Vouchertype' => $Vouchertype,
                        'debit' => $debit,
                        'credit' => $credit,
                        'date_array' => $date_array,
                    );
                }
            }



            $pdf = Pdf::loadView('page.backend.vendor.vendorpdfexport_view', [
                'vendorarr_data' => $vendorarr_data,
                'Vendor' => $GetVendor->name,
                'fromdate' => $fromdate,
                'todate' => $todate,
                
            ]);
            $name = $GetVendor->name . '.' . 'pdf';
            return $pdf->stream($name);
        }
    }
}
