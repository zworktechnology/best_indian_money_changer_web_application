<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    public function index()
    {
        $data = Customer::where('soft_delete', '!=', 1)->latest('created_at')->get();
        $customers = [];
        foreach ($data as $key => $datas) {


            $customers[] = array(
                'unique_id' => $datas->unique_id,
                'name' => $datas->name,
                'phone_number' => $datas->phone_number,
                'note' => $datas->note,
                'current_balance' => $datas->current_balance,
                'id' => $datas->id,
            );
        }
        return view('page.backend.customer.index', compact('customers'));
    }



    public function store(Request $request)
    {
        $data = new Customer();

        $unique_key = Str::random(5);

        $data->unique_id = $unique_key;
        $data->name = $request->get('name');
        $data->phone_number = $request->get('phone_number');
        $data->note = $request->get('note');
        $data->current_balance = $request->get('current_balance');

        $data->save();


        $customerid = $data->id;
        
            $balance_amount = $request->get('current_balance');

            if($balance_amount != ""){
                $Payment = new Payment();

                $Payment->customer_id = $customerid;
                $Payment->total_amount = $balance_amount;
                $Payment->total_paid = 0;
                $Payment->total_balance = $balance_amount;
                $Payment->save();
            }

        return redirect()->route('customer.index')->with('message', 'Added !');
    }


    public function edit(Request $request, $id)
    {
        $Customer = Customer::findOrFail($id);

        $Customer->name = $request->get('name');
        $Customer->phone_number = $request->get('phone_number');
        $Customer->note = $request->get('note');

        $Customer->update();

        return redirect()->route('customer.index')->with('info', 'Updated !');
    }

    public function delete($id)
    {
        $data = Customer::findOrFail($id);

        $data->soft_delete = 1;

        $data->update();

        return redirect()->route('customer.index')->with('warning', 'Deleted !');
    }


    public function checkduplicate(Request $request)
    {
        if(request()->get('query'))
        {
            $query = request()->get('query');
            $customerdata = Customer::where('phone_number', '=', $query)->first();

            $userData['data'] = $customerdata;
            echo json_encode($userData);
        }
    }


    public function getoldbalance()
    {

        $salecustomer_id = request()->get('salecustomer_id');

        $last_idrow = Payment::where('customer_id', '=', $salecustomer_id)->latest('id')->first();
        if($last_idrow != ""){
            $output[] = array(
                'total_balance' => $last_idrow->total_balance,
                'purchase_balance' => $last_idrow->purchase_balance,
            );
        }else {
            $output[] = array(
                'total_balance' => 0,
                'purchase_balance' => 0,
            );
        }

        echo json_encode($output);
    }


    public function getoldbalanceforsales()
    {

        $purchasecustomer_id = request()->get('salecustomer_id');

        $last_idrow = Payment::where('customer_id', '=', $purchasecustomer_id)->latest('id')->first();
        if($last_idrow != ""){
            $output[] = array(
                'total_balance' => $last_idrow->total_balance,
                'purchase_balance' => $last_idrow->purchase_balance,
            );
        }else {
            $output[] = array(
                'total_balance' => 0,
                'purchase_balance' => 0,
            );
        }
        

        echo json_encode($output);
    }
}
