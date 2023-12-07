<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function index()
    {
        $today_date = Carbon::now()->format('Y-m-d');
        $today_time = Carbon::now()->format('H:i');

        $sales_index_data = Sale::where('soft_delete', '!=', 1)->where('date', '=', $today_date)->latest('created_at')->get();
        $currency_data = Currency::where('soft_delete', '!=', 1)->latest('created_at')->get();

        return view('page.backend.sale.index', compact('sales_index_data', 'today_date', 'today_time', 'currency_data'));
    }

    public function datefilter(Request $request) {
        $today_date = $request->get('from_date');
        $today_time = Carbon::now()->format('H:i');

        $sales_index_data = Sale::where('soft_delete', '!=', 1)->where('date', '=', $today_date)->latest('created_at')->get();
        $currency_data = Currency::where('soft_delete', '!=', 1)->latest('created_at')->get();

        return view('page.backend.sale.index', compact('sales_index_data', 'today_date', 'today_time', 'currency_data'));
    }

    public function store(Request $request)
    {
        $data = new Sale();

        $unique_id_string = Str::random(5);
        $today_date = Carbon::now()->format('Y-m-d');
        $today_time = Carbon::now()->format('H:i');

        $data->unique_id = $unique_id_string;
        $data->date = $today_date;
        $data->time = $today_time;
        $data->currency_id = $request->get('currency_id');
        $data->sales_count = $request->get('sales_count');
        $data->sales_count_per_price = $request->get('sales_count_per_price');
        $data->total = $request->get('total');
        $data->description = $request->get('description');

        $data->save();

        return redirect()->route('sale.index')->with('message', 'Added !');
    }

    public function edit(Request $request, $unique_id)
    {
        $sale_edit_data = Sale::where('unique_id', '=', $unique_id)->first();

        $sale_edit_data->currency_id = $request->get('currency_id');
        $sale_edit_data->sales_count = $request->get('sales_count');
        $sale_edit_data->sales_count_per_price = $request->get('sales_count_per_price');
        $sale_edit_data->total = $request->get('total');
        $sale_edit_data->description = $request->get('description');

        $sale_edit_data->update();

        return redirect()->route('sale.index')->with('info', 'Updated !');
    }

    public function delete($unique_id)
    {
        $sale_soft_delete_data = Sale::where('unique_id', '=', $unique_id)->first();

        $sale_soft_delete_data->soft_delete = 1;

        $sale_soft_delete_data->update();

        return redirect()->route('sale.index')->with('warning', 'Deleted !');
    }
}
