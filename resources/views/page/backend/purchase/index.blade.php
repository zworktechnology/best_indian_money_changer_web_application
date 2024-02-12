@extends('layout.backend.auth')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="content-page-header">
                    <h6>Purchase</h6>
                    <div class="list-btn">
                            <div style="display: flex;">
                                <form autocomplete="off" method="POST" action="{{ route('purchase.datefilter') }}">
                                    @method('PUT')
                                    @csrf
                                    <div style="display: flex">
                                        <div style="margin-right: 10px;"><input type="date" name="from_date"
                                                class="form-control from_date" value="{{ $todaydate }}"></div>
                                        <div style="margin-right: 10px;"><input type="submit" class="btn btn-success"
                                                value="Search" /></div>
                                    </div>
                                </form>
                                <ul class="filter-list">
                                    <li><a class="btn btn-primary" href="{{ route('purchase.create') }}"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Purchase</a></li>
                                </ul>
                            </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-center table-hover datatable table-striped">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width:5%">S.No</th>
                                            <th style="width:15%">Date & Time</th>
                                            <th style="width:15%">Customer</th>
                                            <th style="width:20%">Currencies</th>
                                            <th style="width:15%">Grand Total</th>
                                            <th style="width:15%">Paid</th>
                                            <th style="width:15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Purchasedata as $keydata => $Purchasedatas)
                                            <tr>
                                                <td>{{ ++$keydata }}</td>
                                                <td>{{ date('Y-m-d', strtotime($Purchasedatas['date'])) }} - {{ date('h:i A', strtotime($Purchasedatas['time'])) }}</td>
                                                <td>{{ $Purchasedatas['customer'] }}</td>
                                                <td >
                                                @foreach ($Purchasedatas['products'] as $index => $terms_array)
                                                    @if ($terms_array['purchase_id'] == $Purchasedatas['id'])
                                                    {{ $terms_array['currency'] }} {{ $terms_array['code'] }} - {{ $terms_array['currency_optimal'] }} <br/>
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $Purchasedatas['grand_total'] }}</td>
                                                <td>{{ $Purchasedatas['paid_amount'] }}</td>
                                                <td>
                                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                                  
                                                    <li>
                                                            <a href="{{ route('purchase.edit', ['unique_id' => $Purchasedatas['unique_id']]) }}"
                                                                class="badge" style="color:#28084b;background: #a9ac11;">Edit</a>
                                                    </li>
                                                   

                                                    <li>
                                                        <a class="badge" href="#purchaseview{{ $Purchasedatas['unique_id'] }}" data-bs-toggle="modal"
                                                        data-bs-target=".purchaseview-modal-xl{{ $Purchasedatas['unique_id'] }}" style="color: #f8f9fa;background: #8068dc;">View</a>
                                                    </li>
                                                        <li>
                                                            <a href="#purchasedelete{{ $Purchasedatas['unique_id'] }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target=".purchasedelete-modal-xl{{ $Purchasedatas['unique_id'] }}"
                                                                class="badge bg-danger" style="color: white;">Delete</a>
                                                        </li>
                                                    </ul>

                                                </td>
                                            </tr>

                                            <div class="modal fade purchaseview-modal-xl{{ $Purchasedatas['unique_id'] }}"
                                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                                    aria-labelledby="purchaseviewLargeModalLabel{{ $Purchasedatas['unique_id'] }}"
                                                    aria-hidden="true">
                                                    @include('page.backend.purchase.view')
                                            </div>
                                            <div class="modal fade purchasedelete-modal-xl{{ $Purchasedatas['unique_id'] }}"
                                                tabindex="-1" role="dialog"data-bs-backdrop="static"
                                                aria-labelledby="purchasedeleteLargeModalLabel{{ $Purchasedatas['unique_id'] }}"
                                                aria-hidden="true">
                                                @include('page.backend.purchase.delete')
                                            </div>
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
