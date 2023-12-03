<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class IncomeController extends Controller
{
    public function index()
    {
        $today_date = Carbon::now()->format('Y-m-d');
        $today_time = Carbon::now()->format('H:i');

        $income_index_data = Income::where('soft_delete', '!=', 1)->latest('created_at')->get();

        return view('page.backend.income.index', compact('income_index_data', 'today_date', 'today_time'));
    }

    public function store(Request $request)
    {
        $data = new Income();

        $unique_id_string = Str::random(5);

        $data->unique_id = $unique_id_string;
        $data->date = $request->get('date');
        $data->time = $request->get('time');
        $data->amount = $request->get('amount');
        $data->description = $request->get('description');

        $data->save();

        return redirect()->route('income.index')->with('message', 'Added !');
    }

    public function edit(Request $request, $unique_id)
    {
        $income_edit_data = Income::where('unique_id', '=', $unique_id)->first();

        $income_edit_data->amount = $request->get('amount');
        $income_edit_data->description = $request->get('description');

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
