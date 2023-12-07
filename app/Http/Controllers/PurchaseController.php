<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    public function index()
    {
        $today_date = Carbon::now()->format('Y-m-d');
        $today_time = Carbon::now()->format('H:i');

        $purchase_index_data = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $today_date)->latest('created_at')->get();
        $currency_data = Currency::where('soft_delete', '!=', 1)->latest('created_at')->get();

        return view('page.backend.purchase.index', compact('purchase_index_data', 'today_date', 'today_time', 'currency_data'));
    }


    public function datefilter(Request $request) {
        
        $today_date = $request->get('from_date');
        $today_time = Carbon::now()->format('H:i');
        $purchase_index_data = Purchase::where('soft_delete', '!=', 1)->where('date', '=', $today_date)->latest('created_at')->get();
        $currency_data = Currency::where('soft_delete', '!=', 1)->latest('created_at')->get();

        return view('page.backend.purchase.index', compact('purchase_index_data', 'today_date', 'today_time', 'currency_data'));
    }

    public function store(Request $request)
    {
        $data = new Purchase();

        $unique_id_string = Str::random(5);
        $today_date = Carbon::now()->format('Y-m-d');
        $today_time = Carbon::now()->format('H:i');

        $data->unique_id = $unique_id_string;
        $data->date = $today_date;
        $data->time = $today_time;
        $data->currency_id = $request->get('currency_id');
        $data->purchases_count = $request->get('purchases_count');
        $data->purchases_count_per_price = $request->get('purchases_count_per_price');
        $data->total = $request->get('total');
        $data->description = $request->get('description');

        $data->save();

        return redirect()->route('purchase.index')->with('message', 'Added !');
    }

    public function edit(Request $request, $unique_id)
    {
        $purchase_edit_data = Purchase::where('unique_id', '=', $unique_id)->first();

        $purchase_edit_data->currency_id = $request->get('currency_id');
        $purchase_edit_data->purchases_count = $request->get('purchases_count');
        $purchase_edit_data->purchases_count_per_price = $request->get('purchases_count_per_price');
        $purchase_edit_data->total = $request->get('total');
        $purchase_edit_data->description = $request->get('description');

        $purchase_edit_data->update();

        return redirect()->route('purchase.index')->with('info', 'Updated !');
    }

    public function delete($unique_id)
    {
        $purchase_soft_delete_data = Purchase::where('unique_id', '=', $unique_id)->first();

        $purchase_soft_delete_data->soft_delete = 1;

        $purchase_soft_delete_data->update();

        return redirect()->route('purchase.index')->with('warning', 'Deleted !');
    }
}
