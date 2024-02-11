@extends('layout.backend.auth')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="content-page-header">
                    <div class="page-title">
                        <h4>Dashboard</h4>
                    </div>
                    <div class="list-btn">
                        <div style="display: flex;">
                            <form autocomplete="off" method="POST" action="{{ route('home.datefilter') }}">
                                @method('PUT')
                                @csrf
                                <div style="display: flex">
                                    <div style="margin-right: 10px;"><input type="date" name="from_date"
                                            class="form-control from_date" value="{{$today}}"></div>
                                    <div style="margin-right: 10px;"><input type="submit" class="btn btn-success"
                                            value="Filter" /></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Inovices card -->
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="card inovices-card w-100">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="inovices-widget-icon bg-info-light">
                                    <img src="{{ asset('assets/backend/img/icons/receipt-item.svg') }}" alt="">
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Total Purchase</div>
                                    <div class="dash-counts">
                                        <p>₹ {{$tot_purchaseAmount}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="inovices-all">No of Purchase <span class="rounded-circle bg-light-gray">02</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="card inovices-card w-100">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="inovices-widget-icon bg-info-light">
                                    <img src="{{ asset('assets/backend/img/icons/transaction-minus.svg') }}" alt="">
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Total Sales</div>
                                    <div class="dash-counts">
                                        <p>₹ {{$tot_saleAmount}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="inovices-all">No of Sales <span class="rounded-circle bg-light-gray">03</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="card inovices-card w-100">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="inovices-widget-icon bg-info-light">
                                    <img src="{{ asset('assets/backend/img/icons/archive-book.svg') }}" alt="">
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Total Debit</div>
                                    <div class="dash-counts">
                                        <p>₹ {{$tot_expense}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="inovices-all">No of Debit <span class="rounded-circle bg-light-gray">01</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6 col-12 d-flex">
                    <div class="card inovices-card w-100">
                        <div class="card-body">
                            <div class="dash-widget-header">
                                <span class="inovices-widget-icon bg-info-light">
                                    <img src="{{ asset('assets/backend/img/icons/clipboard-close.svg') }}" alt="">
                                </span>
                                <div class="dash-count">
                                    <div class="dash-title">Total Credit</div>
                                    <div class="dash-counts">
                                        <p>₹ {{$tot_income}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="inovices-all">No of Credit <span class="rounded-circle bg-light-gray">04</span>
                                </p>
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
                                <h5 class="card-title">Recent Purchase</h5>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('purchase.index') }}" class="btn-right btn btn-sm btn-outline-primary">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-stripped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Currency</th>
                                        <th>Count</th>
                                        <th>Price / Currency in INR</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach ($Purchasedata as $keydata => $Purchasedatas)
                                       
                                            @foreach ($Purchasedatas['products'] as $index => $terms_array)
                                            @if ($terms_array['purchase_id'] == $Purchasedatas['id'])
                                            <tr>
                                                <td>{{ $terms_array['currency'] }}</td>
                                                <td>{{ $terms_array['count'] }}</td>
                                                <td>{{ $terms_array['doller_rate'] }}</td>
                                                <td>{{ $terms_array['total'] }}</td>
                                            </tr>
                                            @endif
                                            @endforeach
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
                                <h5 class="card-title">Recent Sale</h5>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('sale.index') }}" class="btn-right btn btn-sm btn-outline-primary">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-stripped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Currency</th>
                                        <th>Count</th>
                                        <th>Price / Currency in INR</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach ($saledata as $keydata => $saledatas)
                                       
                                            @foreach ($saledatas['saleproducts'] as $index => $terms_arrays)
                                            @if ($terms_arrays['sales_id'] == $saledatas['id'])
                                            <tr>
                                                <td>{{ $terms_arrays['currency'] }}</td>
                                                <td>{{ $terms_arrays['count'] }}</td>
                                                <td>{{ $terms_arrays['doller_rate'] }}</td>
                                                <td>{{ $terms_arrays['total'] }}</td>
                                            </tr>
                                            @endif
                                            @endforeach
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
