<?php

namespace App\Http\Controllers;
use App\Models\Currency;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\CurrencyOptimal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Carbon\Carbon;

class CurrencyController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $currency_index_data = Currency::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $currency_data = [];
        
        foreach ($currency_index_data as $key => $datas) {

            $PurchaseProduct = PurchaseProduct::where('date', '=', $today)->where('currency_id', '=', $datas->id)->get();
            if($PurchaseProduct != ""){
                $rate_count = count(collect($PurchaseProduct));
            }
                
            $PurchaseProducttotal = PurchaseProduct::where('date', '=', $today)->where('currency_id', '=', $datas->id)->sum('doller_rate'); 
            if($PurchaseProducttotal != 0){
                $PurchaseProduct_total = $PurchaseProducttotal;
                $average_rate = $PurchaseProduct_total / $rate_count;
                $totalaverage = number_format((float)$average_rate, 2, '.', '');
            }else {
                $PurchaseProduct_total = 0;
                $totalaverage = 0;
            }

                        $currency_data[] = array(
                            'unique_id' => $datas->unique_id,
                            'code' => $datas->code,
                            'name' => $datas->name,
                            'country' => $datas->country,
                            'description' => $datas->description,
                            'id' => $datas->id,
                            'average_rate' => $totalaverage,
                        );
        }

        return view('page.backend.currency.index', compact('currency_data', 'today'));
    }


    public function datefilter(Request $request) {
        $today = $request->get('from_date');

        $currency_index_data = Currency::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $currency_data = [];
        
        foreach ($currency_index_data as $key => $datas) {

            $PurchaseProduct = PurchaseProduct::where('date', '=', $today)->where('currency_id', '=', $datas->id)->get();
            if($PurchaseProduct != ""){
                $rate_count = count(collect($PurchaseProduct));
            }
                
            $PurchaseProducttotal = PurchaseProduct::where('date', '=', $today)->where('currency_id', '=', $datas->id)->sum('doller_rate'); 
            if($PurchaseProducttotal != 0){
                $PurchaseProduct_total = $PurchaseProducttotal;
                $average_rate = $PurchaseProduct_total / $rate_count;
                $totalaverage = number_format((float)$average_rate, 2, '.', '');
            }else {
                $PurchaseProduct_total = 0;
                $totalaverage = 0;
            }

                        $currency_data[] = array(
                            'unique_id' => $datas->unique_id,
                            'code' => $datas->code,
                            'name' => $datas->name,
                            'country' => $datas->country,
                            'description' => $datas->description,
                            'id' => $datas->id,
                            'average_rate' => $totalaverage,
                        );
        }

        return view('page.backend.currency.index', compact('currency_data', 'today'));
    }


        
    public function store(Request $request)
    {
        $data = new Currency();

        $unique_id_string = Str::random(5);

        $data->unique_id = $unique_id_string;
        $data->code = $request->get('code');
        $data->name = $request->get('name');

        $data->save();

        return redirect()->route('currency.index')->with('message', 'Added !');
    }

    public function edit(Request $request, $unique_id)
    {
        $currency_edit_data = Currency::where('unique_id', '=', $unique_id)->first();

        $currency_edit_data->name = $request->get('name');

        $currency_edit_data->update();

        return redirect()->route('currency.index')->with('info', 'Updated !');
    }

    public function delete($unique_id)
    {
        $currency_soft_delete_data = Currency::where('unique_id', '=', $unique_id)->first();

        $currency_soft_delete_data->soft_delete = 1;

        $currency_soft_delete_data->update();

        return redirect()->route('currency.index')->with('warning', 'Deleted !');
    }


    public function getcurrencies()
    {
        $GetProduct = Currency::where('soft_delete', '!=', 1)->get();
        $userData['data'] = $GetProduct;
        echo json_encode($userData);
    }
}
