<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class IncomeController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');

        $data = Income::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();
        $Income_data = [];
        foreach ($data as $key => $datas) {

            $customer = Customer::findOrFail($datas->customer_id);

            $Income_data[] = array(
                'unique_id' => $datas->unique_id,
                'date' => $datas->date,
                'time' => $datas->time,
                'amount' => $datas->amount,
                'description' => $datas->description,
                'id' => $datas->id,
                'customer' => $customer->name,
                'customer_id' => $datas->customer_id,
            );
        }

        $customers = Customer::where('soft_delete', '!=', 1)->latest('created_at')->get();

        return view('page.backend.income.index', compact('Income_data', 'today', 'timenow', 'customers'));
    }

    public function datefilter(Request $request) {

        $today = $request->get('from_date');
        $timenow = Carbon::now()->format('H:i');

        $data = Income::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();
        $Income_data = [];
        foreach ($data as $key => $datas) {

            $customer = Customer::findOrFail($datas->customer_id);

            $Income_data[] = array(
                'unique_id' => $datas->unique_id,
                'date' => $datas->date,
                'time' => $datas->time,
                'amount' => $datas->amount,
                'description' => $datas->description,
                'id' => $datas->id,
                'customer' => $customer->name,
                'customer_id' => $datas->customer_id,
            );
        }

        $customers = Customer::where('soft_delete', '!=', 1)->latest('created_at')->get();

        return view('page.backend.income.index', compact('Income_data', 'today', 'timenow', 'customers'));
    }

    public function store(Request $request)
    {
        $data = new Income();

        $unique_id_string = Str::random(5);

        $data->unique_id = $unique_id_string;
        $data->date = $request->get('date');
        $data->time = $request->get('time');
        $data->amount = $request->get('amount');
        $data->customer_id = $request->get('customer_id');
        $data->description = $request->get('description');

        $data->save();

        return redirect()->route('income.index')->with('message', 'Added !');
    }

    public function edit(Request $request, $unique_id)
    {
        $income_edit_data = Income::where('unique_id', '=', $unique_id)->first();

        $income_edit_data->amount = $request->get('amount');
        $income_edit_data->description = $request->get('description');
        $income_edit_data->customer_id = $request->get('customer_id');

        $income_edit_data->update();

        return redirect()->route('income.index')->with('info', 'Updated !');
    }

    public function delete($unique_id)
    {
        $income_soft_delete_data = Income::where('unique_id', '=', $unique_id)->first();

        $income_soft_delete_data->soft_delete = 1;

        $income_soft_delete_data->update();

        return redirect()->route('income.index')->with('warning', 'Deleted !');
    }
}
