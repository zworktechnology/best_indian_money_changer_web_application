<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $timenow = Carbon::now()->format('H:i');


        $data = Expense::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();
        $expense_data = [];
        foreach ($data as $key => $datas) {

            $customer = Customer::findOrFail($datas->customer_id);

            $expense_data[] = array(
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

        return view('page.backend.expense.index', compact('expense_data', 'today', 'timenow', 'customers'));
    }

    public function datefilter(Request $request) {

        $today = $request->get('from_date');
        $timenow = Carbon::now()->format('H:i');


        $data = Expense::where('soft_delete', '!=', 1)->where('date', '=', $today)->latest('created_at')->get();
        $expense_data = [];
        foreach ($data as $key => $datas) {

            $customer = Customer::findOrFail($datas->customer_id);

            $expense_data[] = array(
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

        return view('page.backend.expense.index', compact('expense_data', 'today', 'timenow', 'customers'));
    }

    public function store(Request $request)
    {
        $data = new Expense();

        $unique_id_string = Str::random(5);

        $data->unique_id = $unique_id_string;
        $data->date = $request->get('date');
        $data->time = $request->get('time');
        $data->customer_id = $request->get('customer_id');
        $data->amount = $request->get('amount');
        $data->description = $request->get('description');

        $data->save();

        return redirect()->route('expense.index')->with('message', 'Added !');
    }

    public function edit(Request $request, $unique_id)
    {
        $expense_edit_data = Expense::where('unique_id', '=', $unique_id)->first();

        $expense_edit_data->amount = $request->get('amount');
        $expense_edit_data->description = $request->get('description');
        $expense_edit_data->customer_id = $request->get('customer_id');

        $expense_edit_data->update();

        return redirect()->route('expense.index')->with('info', 'Updated !');
    }

    public function delete($unique_id)
    {
        $expense_soft_delete_data = Expense::where('unique_id', '=', $unique_id)->first();

        $expense_soft_delete_data->soft_delete = 1;

        $expense_soft_delete_data->update();

        return redirect()->route('expense.index')->with('warning', 'Deleted !');
    }
}
