<?php

namespace App\Http\Controllers;
use App\Models\Currency;
use App\Models\CurrencyOptimal;

use Illuminate\Http\Request;

class CurrencyOptimalController extends Controller
{
    public function index()
    {
        $currencyOtimal = CurrencyOptimal::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $currency_optimal = [];
        foreach ($currencyOtimal as $key => $currencyOtimals) {

            $Currency = Currency::findOrFail($currencyOtimals->currency_id);

            $currency_optimal[] = array(
                'code' => $Currency->code,
                'name' => $Currency->name,
                'currency_id' => $currencyOtimals->currency_id,
                'currencyoptimal_name' => $currencyOtimals->name,
                'available_stock' => $currencyOtimals->available_stock,
                'id' => $currencyOtimals->id,
            );
        }
        $currency_data = Currency::where('soft_delete', '!=', 1)->latest('created_at')->get();

        return view('page.backend.currency_optimal.index', compact('currency_optimal', 'currency_data'));
    }



    public function store(Request $request)
    {
        $data = new CurrencyOptimal();

        $data->currency_id = $request->get('currency_id');
        $data->name = $request->get('currency_optimal_name');
        $data->available_stock = $request->get('available_stock');

        $data->save();

        return redirect()->route('currency_optimal.index')->with('message', 'Added !');
    }


    public function edit(Request $request, $id)
    {
        $CurrencyOptimal = CurrencyOptimal::findOrFail($id);

        $CurrencyOptimal->currency_id = $request->get('currency_id');
        $CurrencyOptimal->name = $request->get('currency_optimal_name');
        $CurrencyOptimal->available_stock = $request->get('available_stock');

        $CurrencyOptimal->update();

        return redirect()->route('currency_optimal.index')->with('info', 'Updated !');
    }

    public function delete($id)
    {
        $data = CurrencyOptimal::findOrFail($id);

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('currency_optimal.index')->with('warning', 'Deleted !');
    }


    public function getcurrencyamount($currency_id)
    {
        $currencyOtimal = CurrencyOptimal::where('soft_delete', '!=', 1)->where('currency_id', '=', $currency_id)->get();
        $userData['data'] = $currencyOtimal;
        echo json_encode($userData);
    }

    public function getcurrencyoptimalamount($currency_optimal_id)
    {
        $currencyOtimal = CurrencyOptimal::findOrFail($currency_optimal_id);
        $userData['data'] = $currencyOtimal->name;
        echo json_encode($userData);
    }
}
