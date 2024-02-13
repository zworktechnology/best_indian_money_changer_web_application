@extends('layout.backend.auth')

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="content-page-header">
                    <h6>Sale</h6>
                    <div class="list-btn">
                            <div style="display: flex;">
                                <form autocomplete="off" method="POST" action="{{ route('sale.datefilter') }}">
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
                                    <li><a class="btn btn-primary" href="{{ route('sale.create') }}"><i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Sale</a></li>
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
                                        @foreach ($saledata as $keydata => $saledatas)
                                            <tr>
                                                <td>{{ ++$keydata }}</td>
                                                <td>{{ date('Y-m-d', strtotime($saledatas['date'])) }} - {{ date('h:i A', strtotime($saledatas['time'])) }}</td>
                                                <td>{{ $saledatas['customer'] }}</td>
                                                <td >
                                                @foreach ($saledatas['products'] as $index => $terms_array)
                                                    @if ($terms_array['sales_id'] == $saledatas['id'])
                                                    {{ $terms_array['currency'] }} {{ $terms_array['code'] }} - {{ $terms_array['currency_optimal'] }} <br/>
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $saledatas['grand_total'] }}</td>
                                                <td>{{ $saledatas['paid_amount'] }}</td>
                                                <td>
                                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                                    @if ($saledatas['latestid'] == $saledatas['id'])
                                                    <li >
                                                            <a href="{{ route('sale.edit', ['unique_id' => $saledatas['unique_id']]) }}"
                                                                class="badge" style="color:#28084b;background: #a9ac11;">Edit</a>
                                                    </li>
                                                    @endif
                                                    <li>
                                                        <a class="badge" href="#saleview{{ $saledatas['unique_id'] }}" data-bs-toggle="modal"
                                                        data-bs-target=".saleview-modal-xl{{ $saledatas['unique_id'] }}" style="color: #f8f9fa;background: #8068dc;">View</a>
                                                    </li>
                                                        <li>
                                                            <a href="#delete{{ $saledatas['unique_id'] }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target=".salesdelete-modal-xl{{ $saledatas['unique_id'] }}"
                                                                class="badge bg-danger" style="color: white;">Delete</a>
                                                        </li>
                                                    </ul>

                                                </td>
                                            </tr>

                                            <div class="modal fade saleview-modal-xl{{ $saledatas['unique_id'] }}"
                                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                                    aria-labelledby="saleviewLargeModalLabel{{ $saledatas['unique_id'] }}"
                                                    aria-hidden="true">
                                                    @include('page.backend.sale.view')
                                            </div>
                                            <div class="modal fade salesdelete-modal-xl{{ $saledatas['unique_id'] }}"
                                                tabindex="-1" role="dialog"data-bs-backdrop="static"
                                                aria-labelledby="salesdeleteLargeModalLabel{{ $saledatas['unique_id'] }}"
                                                aria-hidden="true">
                                                @include('page.backend.sale.delete')
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
