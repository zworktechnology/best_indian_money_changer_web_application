<?php

namespace App\Http\Controllers;
use App\Models\Currency;
use App\Models\CurrencyOptimal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Carbon\Carbon;

class CurrencyController extends Controller
{
    public function index()
    {
        $currency_index_data = Currency::where('soft_delete', '!=', 1)->latest('created_at')->get();

        return view('page.backend.currency.index', compact('currency_index_data'));
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
