<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Currency;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\CurrencyOptimal;
use App\Models\Payment;
use App\Models\PurchaseProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    public function index()
    {
        $todaydate = Carbon::now()->format('Y-m-d');
        $todaytime = Carbon::now()->format('H:i');


        $data = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $todaydate)->latest('created_at')->get();
        $Purchasedata = [];
        $products = [];
        foreach ($data as $key => $datas) {
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

        $customers = Customer::where('soft_delete', '!=', 1)->latest('created_at')->get();

        return view('page.backend.purchase.index', compact('Purchasedata', 'customers', 'todaydate', 'todaytime'));
    }

    public function datefilter(Request $request) {

        $todaydate = $request->get('from_date');
        $todaytime = Carbon::now()->format('H:i');


        $data = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $todaydate)->latest('created_at')->get();
        $Purchasedata = [];
        $products = [];
        foreach ($data as $key => $datas) {
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

            $latest = Purchase::where('soft_delete', '!=', 1)->where('customer_id', '=', $datas->customer_id)->latest('id')->first();
            if($latest != ""){
                $latestid = 'yes';
            }else {
                $latestid = 'no';
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

        $customers = Customer::where('soft_delete', '!=', 1)->latest('created_at')->get();

        return view('page.backend.purchase.index', compact('Purchasedata', 'customers', 'todaydate', 'todaytime'));
    }


    public function create()
    {
        $customers = Customer::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $Currency = Currency::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $CurrencyOptimal = CurrencyOptimal::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');
        
        return view('page.backend.purchase.create', compact('customers', 'today', 'timenow', 'Currency', 'CurrencyOptimal'));
    }

    public function store(Request $request)
    {
        $customer_id = $request->get('customer_id');
        $s_bill_no = 1;
        $lastreport_OFBranch = Purchase::latest('id')->first();
            if($lastreport_OFBranch != '')
            {
                $added_billno = substr ($lastreport_OFBranch->billno, -2);
                $invoiceno = '0' . ($added_billno) + 1;
            } else {
                $invoiceno = '0' . $s_bill_no;
            }

        $data = new Purchase();

        $unique_string = Str::random(5);

        $data->unique_id = $unique_string;
        $data->billno = $invoiceno;
        $data->date = $request->get('date');
        $data->time = $request->get('time');
        $data->customer_id = $request->get('customer_id');
        $data->grand_total = $request->get('purchasegrandtotal');
        $data->purchasebalancetype = $request->get('purchasebalancetype');
        $data->oldbalanceamount = $request->get('purchaseoldbalanceamount');
        $data->overallamount = $request->get('purchaseoverallamount');
        $data->paid_amount = $request->get('purchasepaid_amount');
        $data->balance_amount = $request->get('purchasebalanceamount');
        $data->note = $request->get('note');

        $data->save();

        $purchase_id = $data->id;

        foreach ($request->get('currency_id') as $key => $currency_id) {

            $PurchaseProduct = new PurchaseProduct;
            $PurchaseProduct->date = $request->get('date');
            $PurchaseProduct->time = $request->get('time');
            $PurchaseProduct->purchase_id = $purchase_id;
            $PurchaseProduct->currency_id = $currency_id;
            $PurchaseProduct->currency_optimal_id = $request->purchasecurrency_optimal_id[$key];
            $PurchaseProduct->currencyoptimal_amount = $request->purchasecurrencyoptimal_amount[$key];
            $PurchaseProduct->doller_rate = $request->purchasedoller_rate[$key];
            $PurchaseProduct->dollertotal = $request->purchasedollertotal[$key];
            $PurchaseProduct->count = $request->purchase_count[$key];
            $PurchaseProduct->total = $request->purchase_total[$key];
            $PurchaseProduct->save();

            $currency_optimal_id = $request->purchasecurrency_optimal_id[$key];

            $OptimalData = CurrencyOptimal::findOrFail($currency_optimal_id);
            if($OptimalData != ""){
                $doller_count = $OptimalData->available_stock;
                $totaldoller_count = $doller_count + $request->purchase_count[$key];

                DB::table('currency_optimals')->where('id', $currency_optimal_id)->update([
                    'available_stock' => $totaldoller_count
                ]);
            }
        }


        $PaymentData = Payment::where('customer_id', '=', $customer_id)->latest('id')->first();
        if($PaymentData != ""){


            if($PaymentData->total_balance != ""){

                $grand_total = $request->get('purchasegrandtotal');
                $total_amount = $grand_total - $PaymentData->total_balance;
                $paid_amount = $request->get('purchasepaid_amount');
                $balnceamount = $total_amount - $paid_amount;

                $data = new Payment();

                $data->customer_id = $customer_id;
                $data->purchase_amount = $total_amount;
                $data->purchase_paid = $paid_amount;
                $data->purchase_balance = $balnceamount;
                $data->purchase_id = $purchase_id;
                $data->save();

            }else if($PaymentData->purchase_balance != ""){

                $grand_total = $request->get('purchasegrandtotal');
                $total_amountnew = $grand_total + $PaymentData->purchase_balance;
                $paid_amountnew = $request->get('purchasepaid_amount');
                $balnceamountnew = $total_amountnew - $paid_amountnew;

                $data = new Payment();

                $data->customer_id = $customer_id;
                $data->total_amount = $total_amountnew;
                $data->total_paid = $paid_amountnew;
                $data->total_balance = $balnceamountnew;
                $data->purchase_id = $purchase_id;
                $data->save();
            }

            
        }else {
            $gross_amount = $request->get('purchasegrandtotal');
            $payable_amount = $request->get('purchasepaid_amount');
            $balance_amount = $gross_amount - $payable_amount;

            $data = new Payment();

            $data->customer_id = $customer_id;
            $data->purchase_amount = $request->get('purchasegrandtotal');
            $data->purchase_paid = $request->get('purchasepaid_amount');
            $data->purchase_balance = $balance_amount;
            $data->purchase_id = $purchase_id;
            $data->save();
        }

        return redirect()->route('purchase.index')->with('message', 'Added !');
    }

    public function edit($unique_id)
    {
        $PurchaseData = Purchase::where('unique_id', '=', $unique_id)->first();
        $PurchaseProducts = PurchaseProduct::where('purchase_id', '=', $PurchaseData->id)->get();

        $customers = Customer::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $Currency = Currency::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $CurrencyOptimal = CurrencyOptimal::where('soft_delete', '!=', 1)->latest('created_at')->get();

        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        return view('page.backend.purchase.edit', compact('PurchaseData', 'PurchaseProducts', 'customers', 'Currency', 'CurrencyOptimal', 'today', 'timenow'));
    }


    public function update(Request $request, $unique_id)
    {
        $Purchasedata = Purchase::where('unique_id', '=', $unique_id)->first();

        $purchase_customerid = $Purchasedata->customer_id;

        $PaymentData = Payment::where('customer_id', '=', $purchase_customerid)->where('purchase_id', '=', $Purchasedata->id)->first();
        if($PaymentData != ""){

            $old_grossamount = $PaymentData->purchase_amount;
            $old_paid = $PaymentData->purchase_paid;

            $oldentry_grossamount = $Purchasedata->overallamount;
            $oldentry_paid = $Purchasedata->paid_amount;

            $gross_amount = $request->get('purchasegrandtotal');
            $payable_amount = $request->get('purchasepaid_amount');


           $editedgross = $old_grossamount - $oldentry_grossamount;
           $editedpaid = $old_paid - $oldentry_paid;
           $newgross = $editedgross + $gross_amount;
           $newpaid = $editedpaid + $payable_amount;

            $new_balance = $newgross - $newpaid;

            DB::table('payments')->where('customer_id', $purchase_customerid)->where('purchase_id', $Purchasedata->id)->update([
                'purchase_amount' => $newgross,  'purchase_paid' => $newpaid, 'purchase_balance' => $new_balance
            ]);
        }


        $Purchasedata->date = $request->get('date');
        $Purchasedata->time = $request->get('time');
        $Purchasedata->grand_total = $request->get('purchasegrandtotal');
        $Purchasedata->purchasebalancetype = $request->get('purchasebalancetype');
        $Purchasedata->oldbalanceamount = $request->get('purchaseoldbalanceamount');
        $Purchasedata->overallamount = $request->get('purchaseoverallamount');
        $Purchasedata->paid_amount = $request->get('purchasepaid_amount');
        $Purchasedata->balance_amount = $request->get('purchasebalanceamount');
        $Purchasedata->note = $request->get('note');
        
        $Purchasedata->update();

        $purchase_id = $Purchasedata->id;


        $getInserted = PurchaseProduct::where('purchase_id', '=', $purchase_id)->get();
        $purchase_products = array();
        foreach ($getInserted as $key => $getInserted_produts) {
            $purchase_products[] = $getInserted_produts->id;
        }

        $updated_products = $request->purchase_products_id;
        $updated_product_ids = array_filter($updated_products);
        $different_ids = array_merge(array_diff($purchase_products, $updated_product_ids), array_diff($updated_product_ids, $purchase_products));


        if (!empty($different_ids)) {
            foreach ($different_ids as $key => $differents_id) {
                $getPurchaseOld = PurchaseProduct::where('id', '=', $differents_id)->first();

                $OptimalData = CurrencyOptimal::findOrFail($getPurchaseOld->currency_optimal_id);

                $doller_count = $OptimalData->available_stock;
                $totaldoller_count = $doller_count - $getPurchaseOld->count;

                DB::table('currency_optimals')->where('id', $getPurchaseOld->currency_optimal_id)->update([
                    'available_stock' => $totaldoller_count
                ]);
            }
        }

        if (!empty($different_ids)) {
            foreach ($different_ids as $key => $different_id) {
                PurchaseProduct::where('id', $different_id)->delete();
            }
        }




        // Products
        foreach ($request->get('purchase_products_id') as $key => $purchase_products_id) {
            if ($purchase_products_id > 0) {


                $ids = $purchase_products_id;
              //  $currency_id = $request->currency_id[$key];
                $currency_optimal_id = $request->purchasecurrency_optimal_id[$key];
                $currencyoptimal_amount = $request->purchasecurrencyoptimal_amount[$key];
                $purchasedoller_rate = $request->purchasedoller_rate[$key];
                $purchasedollertotal = $request->purchasedollertotal[$key];
                $count = $request->purchase_count[$key];
                $total = $request->purchase_total[$key];

                $inserted_products = PurchaseProduct::where('id', '=', $purchase_products_id)->where('currency_optimal_id', '=', $currency_optimal_id)->first();
                $inserted_stock = $inserted_products->count;

                $OptimalDatas = CurrencyOptimal::findOrFail($currency_optimal_id);
                $availablestock = $OptimalDatas->available_stock;

                $editedstock = $availablestock - $inserted_stock;
                DB::table('currency_optimals')->where('id', $currency_optimal_id)->update([
                    'available_stock' => $editedstock
                ]);


                DB::table('purchase_products')->where('id', $ids)->update([
                    'purchase_id' => $purchase_id, 'currency_optimal_id' => $currency_optimal_id,
                     'currencyoptimal_amount' => $currencyoptimal_amount, 'doller_rate' => $purchasedoller_rate, 'dollertotal' => $purchasedollertotal, 'count' => $count, 'total' => $total
                ]);

                $OptimalDatasid = CurrencyOptimal::findOrFail($currency_optimal_id);
                $availablestocks = $OptimalDatasid->available_stock;
                $newstock = $availablestocks + $count;

                DB::table('currency_optimals')->where('id', $currency_optimal_id)->update([
                    'available_stock' => $newstock
                ]);


               

            } else if ($purchase_products_id == '') {

                $PurchaseProduct = new PurchaseProduct;
                $PurchaseProduct->date = $request->get('date');
                $PurchaseProduct->time = $request->get('time');
                $PurchaseProduct->purchase_id = $purchase_id;
                $PurchaseProduct->currency_id = $request->currency_id[$key];
                $PurchaseProduct->currency_optimal_id = $request->purchasecurrency_optimal_id[$key];
                $PurchaseProduct->currencyoptimal_amount = $request->purchasecurrencyoptimal_amount[$key];
                $PurchaseProduct->doller_rate = $request->purchasedoller_rate[$key];
                $PurchaseProduct->dollertotal = $request->purchasedollertotal[$key];
                $PurchaseProduct->count = $request->purchase_count[$key];
                $PurchaseProduct->total = $request->purchase_total[$key];
                $PurchaseProduct->save();


                $currency_optimal_id = $request->purchasecurrency_optimal_id[$key];

                $OptimalData = CurrencyOptimal::findOrFail($currency_optimal_id);
                if($OptimalData != ""){
                    $doller_count = $OptimalData->available_stock;
                    $totaldoller_count = $doller_count + $request->purchase_count[$key];

                    DB::table('currency_optimals')->where('id', $currency_optimal_id)->update([
                        'available_stock' => $totaldoller_count
                    ]);
                }
            }
        }



        return redirect()->route('purchase.index')->with('info', 'Updated !');
    }




    public function delete($unique_id)
    {
        $data = Purchase::where('unique_id', '=', $unique_id)->first();

        $customer_id = $data->customer_id;


        $PurchasebranchwiseData = Payment::where('customer_id', '=', $customer_id)->where('purchase_id', '=', $data->id)->first();
        if($PurchasebranchwiseData != ""){
            $PurchasebranchwiseData->delete();
        }

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('purchase.index')->with('warning', 'Deleted !');
    }
}
