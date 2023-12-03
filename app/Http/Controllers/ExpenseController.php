<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index()
    {
        $today_date = Carbon::now()->format('Y-m-d');
        $today_time = Carbon::now()->format('H:i');

        $expense_index_data = Expense::where('soft_delete', '!=', 1)->latest('created_at')->get();

        return view('page.backend.expense.index', compact('expense_index_data', 'today_date', 'today_time'));
    }

    public function store(Request $request)
    {
        $data = new Expense();

        $unique_id_string = Str::random(5);

        $data->unique_id = $unique_id_string;
        $data->date = $request->get('date');
        $data->time = $request->get('time');
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
