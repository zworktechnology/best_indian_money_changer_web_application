@extends('layout.backend.auth')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

                <div class="page-header">
                    <div class="content-page-header">
                        <div class="page-title">
                            <h4>Dashboard</h4>
                        </div>

                        <div class="page-btn">
                            <div style="display: flex;">
                                    <form autocomplete="off" method="POST" action="{{ route('home.datefilter') }}">
                                        @method('PUT')
                                        @csrf
                                        <div style="display: flex">
                                            <div style="margin-right: 10px;"><input type="date" name="from_date"
                                                    class="form-control from_date" value="{{ $today }}"></div>
                                            <div style="margin-right: 10px;"><input type="submit" class="btn btn-success"
                                                    value="Search" /></div>
                                        </div>
                                    </form>
                            </div>


                        </div>
                    </div>
                </div>
            <div class="row">

                

                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-1">
                                    <i class="far fa-file"></i>
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Quotation Amount</div>
                                    <div class="dash-counts">
                                        <p>₹  {{$tot_quotationAmount}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-2">
                                    <i class="fas fa-file-alt"></i>
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Bill Amount</div>
                                    <div class="dash-counts">
                                        <p>₹ {{$tot_billAmount}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-3">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Purchase Amount</div>
                                    <div class="dash-counts">
                                        <p>₹ {{$tot_purchaseAmount}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="dash-widget-icon bg-4">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Expense Amount</div>
                                    <div class="dash-counts">
                                        <p>₹  {{$tot_expenseAmount}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-center">
                                <div class="col">
                                    <h5 class="card-title">Recent Bills</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-stripped table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Bill No</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($bill_arr as $keydata => $bill_recentsarr)
                                        <tr>
                                            <td>{{$bill_recentsarr['billno']}}</td>
                                            <td>{{$bill_recentsarr['customer']}}</td>
                                            <td>{{$bill_recentsarr['bill_grand_total']}}</td>
                                            <td>{{$bill_recentsarr['bill_paid_amount']}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-center">
                                <div class="col">
                                    <h5 class="card-title">Recent Purchase</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Voucher No</th>
                                            <th>Vendor</th>
                                            <th>Amount</th>
                                            <th>Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    @foreach ($purhcase_arr as $keydata => $purhcase_recent_arr)
                                        <tr>
                                            <td>{{$purhcase_recent_arr['vocher_number']}}</td>
                                            <td>{{$purhcase_recent_arr['Vendor']}}</td>
                                            <td>{{$purhcase_recent_arr['purchase_grandtotal']}}</td>
                                            <td>{{$purhcase_recent_arr['purchase_paidamount']}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-center">
                                <div class="col">
                                    <h5 class="card-title">Recent Expenses</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-stripped table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Expense No</th>
                                            <th>Amount</th>
                                            <th>Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($expense_arr as $keydata => $expense_array)
                                        <tr>
                                            <td>{{$expense_array['expence_number']}}</td>
                                            <td>{{$expense_array['grand_total']}}</td>
                                            <td>{{$expense_array['add_on_note']}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
@endsection
