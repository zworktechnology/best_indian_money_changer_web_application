@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Credit Note</h6>
            <div class="list-btn">
                <div style="display: flex;">
                    <form autocomplete="off" method="POST" action="{{ route('income.datefilter') }}">
                        @method('PUT')
                        @csrf
                        <div style="display: flex">
                            <div style="margin-right: 10px;"><input type="date" name="from_date"
                                    class="form-control from_date" value="{{ $today }}"></div>
                            <div style="margin-right: 10px;"><input type="submit" class="btn btn-success"
                                    value="Filter" /></div>
                        </div>
                    </form>
                </div>
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-sm-9">
            <div class="card">

                  <div class="card-body">
                     <div class="table-responsive">
                        <table class="table table-center table-hover datatable table-striped">
                           <thead class="thead-light">
                              <tr>
                                 <th style="width:20%">S.No</th>
                                 <th style="width:20%">Customer</th>
                                 <th style="width:20%">Created On</th>
                                 <th style="width:20%">Amount</th>
                                 <th style="width:20%">Description</th>
                                 <th style="width:20%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($Income_data as $keydata => $Income_datas)
                              <tr>
                                 <td>{{ ++$keydata }}</td>
                                 <td>{{ $Income_datas['customer'] }}</td>
                                 <td>{{ date('d M Y', strtotime($Income_datas['date'])) }} - {{ date('h:i A', strtotime($Income_datas['time'])) }}</td>
                                 <td>{{ $Income_datas['amount'] }}</td>
                                 <td>{{ $Income_datas['description'] }}</td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                          <a class="badge" href="#edit{{ $Income_datas['unique_id'] }}" data-bs-toggle="modal"
                                          data-bs-target=".incomeedit-modal-xl{{ $Income_datas['unique_id'] }}" style="color: white;background: #a9ac11;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $Income_datas['unique_id'] }}" data-bs-toggle="modal"
                                          data-bs-target=".incomedelete-modal-xl{{ $Income_datas['unique_id'] }}" class="badge bg-danger" style="color: white;">Delete</a>
                                       </li>
                                    </ul>

                                 </td>
                              </tr>

                              <div class="modal fade incomeedit-modal-xl{{ $Income_datas['unique_id'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="incomeeditLargeModalLabel{{ $Income_datas['unique_id'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.income.edit')
                              </div>
                              <div class="modal fade incomedelete-modal-xl{{ $Income_datas['unique_id'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="incomedeleteLargeModalLabel{{ $Income_datas['unique_id'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.income.delete')
                              </div>
                           @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>

            </div>
         </div>
         <div class="col-sm-3">
            @include('page.backend.income.create')
         </div>


      </div>

   </div>
</div>
@endsection
