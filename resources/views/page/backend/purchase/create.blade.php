@extends('layout.backend.auth')

@section('content')
    <div class="page-wrapper card-body">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="content-page-header">
                    <h6>Add Purchase</h6>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="quotation-card">
                                <div class="card-body">

                                    <form autocomplete="off" method="POST" action="{{ route('purchase.store') }}"
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
                                                            class="form-control select purchasecustomer_id js-example-basic-single"
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
                                                        <th style="width:15%" hidden>Total</th>
                                                        <th style="width:10%;">Count</th>
                                                        <th style="width:13%;">Total Amount</th>
                                                        <th style="width:8%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="purchaseproduct_fields">
                                                    <tr>
                                                        <td>
                                                            <input id="#" name="#"
                                                                class="purchaseauto_num form-control" type="text" value="1"
                                                                readonly />
                                                        </td>
                                                        <td>
                                                        <input type="hidden" id="purchase_products_id" name="purchase_products_id[]" />
                                                            <select
                                                                class="form-control  currency_id select js-example-basic-single"
                                                                name="currency_id[]" id="purchasecurrency_id1" required>
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
                                                            <select class="form-control  purchasecurrency_optimal_id select js-example-basic-single" name="purchasecurrency_optimal_id[]" id="purchasecurrency_optimal_id1" required>
                                                                <option value="" selected hidden class="text-muted">Select CurrencyOptimal</option>
                                                            </select>
                                                            <input type="hidden" class="form-control purchasecurrencyoptimal_amount"
                                                                id="purchasecurrencyoptimal_amount1" name="purchasecurrencyoptimal_amount[]"
                                                                value="" required />
                                                        </td>
                                                        <td><input type="text" class="form-control purchasedoller_rate" id="purchasedoller_rate1" name="purchasedoller_rate[]" placeholder="Rate" /></td>
                                                        <td hidden><input type="text" class="form-control purchasedollertotal" id="purchasedollertotal1" name="purchasedollertotal[]" readonly /></td>
                                                        <td><input type="text" class="form-control purchase_count"
                                                                 id="purchase_count1" name="purchase_count[]"
                                                                placeholder="Qty" /></td>
                                                        <td><input type="text" class="form-control purchase_total"
                                                                readonly id="purchase_total1" name="purchase_total[]"
                                                                placeholder="Total" /></td>
                                                        <td>
                                                            <button class="additemplus_button addpurchasefields" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>
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
                                                                <h4 style="text-transform:uppercase;color: green;">Grand Total <span class="purchasegrand_total">  </span></h4>
                                                                <input type="hidden" class="form-control purchasegrandtotal" name="purchasegrandtotal" id="purchase_grandtotal">
                                                            </div>
                                                            <div class="invoice-total-footer">
                                                                <h4 style="text-transform:uppercase;color: #db9161;">Old Balance <span class="purchaseold_balance">  </span></h4>
                                                                <input type="hidden" class="form-control purchaseoldbalanceamount" name="purchaseoldbalanceamount" id="purchaseoldbalanceamount">
                                                            </div>
                                                            <div class="invoice-total-footer">
                                                                <h4 style="text-transform:uppercase;color: darkgreen;">Total <span class="purchase_overallamount">  </span></h4>
                                                                <input type="hidden" class="form-control purchaseoverallamount" name="purchaseoverallamount" id="purchaseoverallamount">
                                                            </div>
                                                            <div class="invoice-total-footer">
                                                                <h4 style="text-transform:uppercase;">Paid Amount <span class="">
                                                                    <input type="text" class="form-control purchasepaid_amount"  required name="purchasepaid_amount" id="purchasepaid_amount" placeholder="Enter Payable Amount"> </span></h4>
                                                            </div>
                                                            <div class="invoice-total-footer">
                                                                <h4 style="text-transform:uppercase;color: #c73d3d;">Balance<span class="purchasebalance_amount"> </span>
                                                                <input type="hidden" class="form-control purchasebalanceamount"  name="purchasebalanceamount" id="purchasebalanceamount" ></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end" style="margin-top:3%">
                                            <input type="submit" class="btn btn-primary"
                                                onclick="purchseubmitForm(this);" />
                                            <a href="{{ route('purchase.index') }}"
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
