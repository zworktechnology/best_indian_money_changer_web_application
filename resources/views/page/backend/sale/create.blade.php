@extends('layout.backend.auth')

@section('content')
    <div class="page-wrapper card-body">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="content-page-header">
                    <h6>Add Sale</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="quotation-card">
                                <div class="card-body">

                                    <form autocomplete="off" method="POST" action="{{ route('sale.store') }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group-item border-0 mb-0">
                                            <div class="row align-item-center">
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label > Date <span class="text-danger">*</span></label>
                                                        <input type="date" class="datetimepicker form-control" placeholder="Select Date"
                                                            value="{{ $today }}" name="date" id="date"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label>Time <span class="text-danger">*</span></label>
                                                        <input type="time" class="datetimepicker form-control" placeholder="Select Date"
                                                            value="{{ $timenow }}" name="time" id="time"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label >Customer <span class="text-danger">*</span></label>
                                                        <select
                                                            class="form-control select salecustomer_id js-example-basic-single"
                                                            name="customer_id" id="customer_id" required>
                                                            <option value="" disabled selected hiddden>Select Customer
                                                            </option>
                                                            @foreach ($customers as $customers_arr)
                                                                <option value="{{ $customers_arr->id }}">{{ $customers_arr->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive no-pagination">
                                            <table class="table table-center table-hover datatable">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th style="width:7%;">S.No</th>
                                                        <th style="width:19%;">Currency</th>
                                                        <th style="width:13%;">Currency Optimal</th>
                                                        <th style="width:15%">Rate / Doller</th>
                                                        <th style="width:15%">Total</th>
                                                        <th style="width:10%;">Count</th>
                                                        <th style="width:13%;">Total Amount</th>
                                                        <th style="width:8%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="saleproduct_fields">
                                                    <tr>
                                                        <td>
                                                            <input id="#" name="#"
                                                                class="auto_num form-control" type="text" value="1"
                                                                readonly />
                                                        </td>
                                                        <td>
                                                        <input type="hidden" id="sales_products_id" name="sales_products_id[]" />
                                                            <select
                                                                class="form-control  currency_id select js-example-basic-single"
                                                                name="currency_id[]" id="salecurrency_id1" required>
                                                                <option value="" selected hidden class="text-muted">
                                                                    Select Currency
                                                                </option>
                                                                @foreach ($Currency as $Currencys)
                                                                    <option value="{{ $Currencys->id }}">
                                                                        {{ $Currencys->name }} - {{ $Currencys->code }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control  currency_optimal_id select js-example-basic-single" name="currency_optimal_id[]" id="currency_optimal_id1" required>
                                                                <option value="" selected hidden class="text-muted">Select CurrencyOptimal</option>
                                                            </select>
                                                            <input type="hidden" class="form-control currencyoptimal_amount"
                                                                id="currencyoptimal_amount1" name="currencyoptimal_amount[]"
                                                                value="" required />
                                                        </td>
                                                        <td><input type="text" class="form-control doller_rate" id="doller_rate1" name="doller_rate[]" placeholder="Rate" /></td>
                                                        <td><input type="text" class="form-control dollertotal" id="dollertotal1" name="dollertotal[]" readonly /></td>
                                                        <td><input type="text" class="form-control sale_count"
                                                                 id="sale_count1" name="sale_count[]"
                                                                placeholder="Qty" /></td>
                                                        <td><input type="text" class="form-control sale_total"
                                                                readonly id="sale_total1" name="sale_total[]"/></td>
                                                        <td>
                                                            <button class="additemplus_button addsalefields" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>


                                        <div class="form-group-item border-0 p-0">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-12">
                                                    <div class="form-group-bank">
                                                        <div class="form-group notes-form-group-info">
                                                            <label>Notes <span class="text-danger">*</span></label>
                                                            <textarea class="form-control" placeholder="Enter Notes" name="note" id="note" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-12">
                                                    <div class="form-group-bank">
                                                        <div class="invoice-total-box">
                                                            <div class="invoice-total-footer">
                                                                <h4 style="text-transform:uppercase;color: green;">Grand Total <span class="salegrand_total">  </span></h4>
                                                                <input type="hidden" class="form-control grand_total" name="grand_total" id="grand_total">
                                                            </div>
                                                            <div class="invoice-total-footer">
                                                                <h4 style="text-transform:uppercase;color: #db9161;">Old Balance <span class="saleold_balance">  </span></h4>
                                                                <input type="hidden" class="form-control oldbalanceamount" name="oldbalanceamount" id="oldbalanceamount">
                                                            </div>
                                                            <div class="invoice-total-footer">
                                                                <h4 style="text-transform:uppercase;color: darkgreen;">Total <span class="sale_overallamount">  </span></h4>
                                                                <input type="hidden" class="form-control overallamount" name="overallamount" id="overallamount">
                                                            </div>
                                                            <div class="invoice-total-footer">
                                                                <h4 style="text-transform:uppercase;">Paid Amount <span class="">
                                                                    <input type="text" class="form-control salepaid_amount"  required name="paid_amount" id="paid_amount" placeholder="Enter Payable Amount"> </span></h4>
                                                            </div>
                                                            <div class="invoice-total-footer">
                                                                <h4 style="text-transform:uppercase;color: #c73d3d;">Balance<span class="salebalance_amount"> </span>
                                                                <input type="hidden" class="form-control balance_amount"  name="balance_amount" id="balance_amount" ></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end" style="margin-top:3%">
                                            <input type="submit" class="btn btn-primary"
                                                onclick="purchseubmitForm(this);" />
                                            <a href="{{ route('sale.index') }}"
                                                class="btn btn-cancel btn-danger">Cancel</a>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
