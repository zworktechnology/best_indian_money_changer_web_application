<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Currency;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\CurrencyOptimal;
use App\Models\Payment;
use App\Models\SaleProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function index()
    {
        $todaydate = Carbon::now()->format('Y-m-d');
        $todaytime = Carbon::now()->format('H:i');


        $data = Sale::where('soft_delete', '!=', 1)->where('date', '=', $todaydate)->latest('created_at')->get();
        $saledata = [];
        $products = [];
        foreach ($data as $key => $datas) {
            $customer = Customer::findOrFail($datas->customer_id);


            $SaleProduct = SaleProduct::where('sales_id', '=', $datas->id)->orderBy('id', 'DESC')->get();
            foreach ($SaleProduct as $key => $SaleProduct_arr) {

                $currency = Currency::findOrFail($SaleProduct_arr->currency_id);
                $currency_optimal = CurrencyOptimal::findOrFail($SaleProduct_arr->currency_optimal_id);
                $products[] = array(
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

        return view('page.backend.sale.index', compact('saledata', 'customers', 'todaydate', 'todaytime'));
    }

    public function datefilter(Request $request) {

        $todaydate = $request->get('from_date');
        $todaytime = Carbon::now()->format('H:i');


        $data = Sale::where('soft_delete', '!=', 1)->where('date', '=', $todaydate)->latest('created_at')->get();
        $saledata = [];
        $products = [];

        foreach ($data as $key => $datas) {
            $customer = Customer::findOrFail($datas->customer_id);


            $SaleProduct = SaleProduct::where('sales_id', '=', $datas->id)->orderBy('id', 'DESC')->get();
            foreach ($SaleProduct as $key => $SaleProduct_arr) {

                $currency = Currency::findOrFail($SaleProduct_arr->currency_id);
                $currency_optimal = CurrencyOptimal::findOrFail($SaleProduct_arr->currency_optimal_id);
                $products[] = array(
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
                'note' => $datas->note,
                'id' => $datas->id,
                'billno' => $datas->billno,
                'products' => $products,
            );
        }

        $customers = Customer::where('soft_delete', '!=', 1)->latest('created_at')->get();

        return view('page.backend.sale.index', compact('saledata', 'customers', 'todaydate', 'todaytime'));
    }


    public function create()
    {
        $customers = Customer::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $Currency = Currency::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $CurrencyOptimal = CurrencyOptimal::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');
        
        return view('page.backend.sale.create', compact('customers', 'today', 'timenow', 'Currency', 'CurrencyOptimal'));
    }

    public function store(Request $request)
    {
        $customer_id = $request->get('customer_id');
        $s_bill_no = 1;
        $lastreport_OFBranch = Sale::latest('id')->first();
            if($lastreport_OFBranch != '')
            {
                $added_billno = substr ($lastreport_OFBranch->billno, -2);
                $invoiceno = '0' . ($added_billno) + 1;
            } else {
                $invoiceno = '0' . $s_bill_no;
            }

        $data = new Sale();

        $unique_string = Str::random(5);

        $data->unique_id = $unique_string;
        $data->billno = $invoiceno;
        $data->date = $request->get('date');
        $data->time = $request->get('time');
        $data->customer_id = $request->get('customer_id');
        $data->grand_total = $request->get('grand_total');
        $data->oldbalanceamount = $request->get('oldbalanceamount');
        $data->overallamount = $request->get('overallamount');
        $data->paid_amount = $request->get('paid_amount');
        $data->balance_amount = $request->get('balance_amount');
        $data->note = $request->get('note');

        $data->save();

        $sales_id = $data->id;

        foreach ($request->get('currency_id') as $key => $currency_id) {

            $SaleProduct = new SaleProduct;
            $SaleProduct->date = $request->get('date');
            $SaleProduct->time = $request->get('time');
            $SaleProduct->sales_id = $sales_id;
            $SaleProduct->currency_id = $currency_id;
            $SaleProduct->currency_optimal_id = $request->currency_optimal_id[$key];
            $SaleProduct->currencyoptimal_amount = $request->currencyoptimal_amount[$key];
            $SaleProduct->doller_rate = $request->doller_rate[$key];
            $SaleProduct->dollertotal = $request->dollertotal[$key];
            $SaleProduct->count = $request->sale_count[$key];
            $SaleProduct->total = $request->sale_total[$key];
            $SaleProduct->save();

            $currency_optimal_id = $request->currency_optimal_id[$key];

            $OptimalData = CurrencyOptimal::findOrFail($currency_optimal_id);
            if($OptimalData != ""){
                $doller_count = $OptimalData->available_stock;
                $totaldoller_count = $doller_count - $request->sale_count[$key];

                DB::table('currency_optimals')->where('id', $currency_optimal_id)->update([
                    'available_stock' => $totaldoller_count
                ]);
            }
        }


        $PaymentData = Payment::where('customer_id', '=', $customer_id)->first();
        if($PaymentData != ""){
            $total_amount = $PaymentData->total_amount;
            $total_paid = $PaymentData->total_paid;

            $grand_total = $request->get('grand_total');
            $paid_amount = $request->get('paid_amount');
            $oldbalanceamount = $request->get('oldbalanceamount');


            $updted_gross = $grand_total - $oldbalanceamount;

            $new_grossamount = $total_amount + $updted_gross;
            $new_paid = $total_paid + $paid_amount;
            $new_balance = $new_grossamount - $new_paid;

            DB::table('payments')->where('customer_id', $customer_id)->update([
                'total_amount' => $new_grossamount,  'total_paid' => $new_paid, 'total_balance' => $new_balance
            ]);
        }else {
            $gross_amount = $request->get('grand_total');
            $payable_amount = $request->get('paid_amount');
            $balance_amount = $gross_amount - $payable_amount;

            $data = new Payment();

            $data->customer_id = $customer_id;
            $data->total_amount = $request->get('grand_total');
            $data->total_paid = $request->get('paid_amount');
            $data->total_balance = $balance_amount;
            $data->save();
        }

        return redirect()->route('sale.index')->with('message', 'Added !');
    }

    public function edit($unique_id)
    {
        $SaleData = Sale::where('unique_id', '=', $unique_id)->first();
        $SaleProducts = SaleProduct::where('sales_id', '=', $SaleData->id)->get();

        $customers = Customer::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $Currency = Currency::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $CurrencyOptimal = CurrencyOptimal::where('soft_delete', '!=', 1)->latest('created_at')->get();

        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        return view('page.backend.sale.edit', compact('SaleData', 'SaleProducts', 'customers', 'Currency', 'CurrencyOptimal', 'today', 'timenow'));
    }


    public function update(Request $request, $unique_id)
    {
        $Saledata = Sale::where('unique_id', '=', $unique_id)->first();

        $sale_customerid = $Saledata->customer_id;

        $PaymentData = Payment::where('customer_id', '=', $sale_customerid)->first();
        if($PaymentData != ""){

            $old_grossamount = $PaymentData->total_amount;
            $old_paid = $PaymentData->total_paid;

            $oldentry_grossamount = $Saledata->grand_total;
            $oldentry_paid = $Saledata->paid_amount;

            $gross_amount = $request->get('grand_total');
            $payable_amount = $request->get('paid_amount');
            $oldbalanceamount = $request->get('oldbalanceamount');

            $updatedgross = $gross_amount - $oldbalanceamount;


           $editedgross = $old_grossamount - $oldentry_grossamount;
           $editedpaid = $old_paid - $oldentry_paid;
           $newgross = $editedgross + $updatedgross;
           $newpaid = $editedpaid + $payable_amount;

            $new_balance = $newgross - $newpaid;

            DB::table('payments')->where('customer_id', $sale_customerid)->update([
                'total_amount' => $newgross,  'total_paid' => $newpaid, 'total_balance' => $new_balance
            ]);
        }


        $Saledata->date = $request->get('date');
        $Saledata->time = $request->get('time');
        $Saledata->grand_total = $request->get('grand_total');
        $Saledata->oldbalanceamount = $request->get('oldbalanceamount');
        $Saledata->overallamount = $request->get('overallamount');
        $Saledata->paid_amount = $request->get('paid_amount');
        $Saledata->balance_amount = $request->get('balance_amount');
        $Saledata->note = $request->get('note');
        
        $Saledata->update();

        $salesid = $Saledata->id;


        $getInserted = SaleProduct::where('sales_id', '=', $salesid)->get();
        $purchase_products = array();
        foreach ($getInserted as $key => $getInserted_produts) {
            $purchase_products[] = $getInserted_produts->id;
        }

        $updated_products = $request->sales_products_id;
        $updated_product_ids = array_filter($updated_products);
        $different_ids = array_merge(array_diff($purchase_products, $updated_product_ids), array_diff($updated_product_ids, $purchase_products));

        if (!empty($different_ids)) {
            foreach ($different_ids as $key => $different_id) {
                SaleProduct::where('id', $different_id)->delete();
            }
        }




        // Products
        foreach ($request->get('sales_products_id') as $key => $sales_products_id) {
            if ($sales_products_id > 0) {


                $ids = $sales_products_id;
                $currency_id = $request->currency_id[$key];
                $currency_optimal_id = $request->currency_optimal_id[$key];
                $currencyoptimal_amount = $request->currencyoptimal_amount[$key];
                $doller_rate = $request->doller_rate[$key];
                $dollertotal = $request->dollertotal[$key];
                $count = $request->sale_count[$key];
                $total = $request->sale_total[$key];


                $inserted_products = SaleProduct::where('id', '=', $sales_products_id)->where('currency_optimal_id', '=', $currency_optimal_id)->first();
                $inserted_stock = $inserted_products->count;

                $OptimalDatas = CurrencyOptimal::findOrFail($currency_optimal_id);
                $availablestock = $OptimalDatas->available_stock;

                $editedstock = $availablestock + $inserted_stock;
                DB::table('currency_optimals')->where('id', $currency_optimal_id)->update([
                    'available_stock' => $editedstock
                ]);



                DB::table('sale_products')->where('id', $ids)->update([
                    'sales_id' => $salesid, 'currency_id' => $currency_id, 'currency_optimal_id' => $currency_optimal_id,
                     'currencyoptimal_amount' => $currencyoptimal_amount, 'doller_rate' => $doller_rate, 'dollertotal' => $dollertotal, 'count' => $count, 'total' => $total
                ]);


                $OptimalDatasid = CurrencyOptimal::findOrFail($currency_optimal_id);
                $availablestocks = $OptimalDatasid->available_stock;
                $newstock = $availablestocks - $count;

                DB::table('currency_optimals')->where('id', $currency_optimal_id)->update([
                    'available_stock' => $newstock
                ]);

            } else if ($sales_products_id == '') {

                $SaleProduct = new SaleProduct;
                $SaleProduct->date = $request->get('date');
                $SaleProduct->time = $request->get('time');
                $SaleProduct->sales_id = $salesid;
                $SaleProduct->currency_id = $request->currency_id[$key];
                $SaleProduct->currency_optimal_id = $request->currency_optimal_id[$key];
                $SaleProduct->currencyoptimal_amount = $request->currencyoptimal_amount[$key];
                $SaleProduct->doller_rate = $request->doller_rate[$key];
                $SaleProduct->dollertotal = $request->dollertotal[$key];
                $SaleProduct->count = $request->sale_count[$key];
                $SaleProduct->total = $request->sale_total[$key];
                $SaleProduct->save();


                $currencyoptimal_id = $request->currency_optimal_id[$key];

                $OptimalData = CurrencyOptimal::findOrFail($currencyoptimal_id);
                if($OptimalData != ""){
                    $doller_count = $OptimalData->available_stock;
                    $totaldoller_count = $doller_count - $request->sale_count[$key];

                    DB::table('currency_optimals')->where('id', $currencyoptimal_id)->update([
                        'available_stock' => $totaldoller_count
                    ]);
                }
            }
        }



        return redirect()->route('sale.index')->with('info', 'Updated !');
    }




    public function delete($unique_id)
    {
        $data = Sale::where('unique_id', '=', $unique_id)->first();

        $customer_id = $data->customer_id;


        $PurchasebranchwiseData = Payment::where('customer_id', '=', $customer_id)->first();
        if($PurchasebranchwiseData != ""){


            $old_grossamount = $PurchasebranchwiseData->total_amount;
            $old_paid = $PurchasebranchwiseData->total_paid;

            $oldentry_grossamount = $data->grand_total;
            $oldentry_paid = $data->paid_amount;

         
                $updated_gross = $old_grossamount - $oldentry_grossamount;
                $updated_paid = $old_paid - $oldentry_paid;

                $new_balance = $updated_gross - $updated_paid;

            DB::table('payments')->where('customer_id', $customer_id)->update([
                'total_amount' => $updated_gross,  'total_paid' => $updated_paid, 'total_balance' => $new_balance
            ]);

        }

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('sale.index')->with('warning', 'Deleted !');
    }
}
