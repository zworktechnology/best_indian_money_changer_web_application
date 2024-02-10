@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Debit Note</h6>
            <div class="list-btn">
                <div style="display: flex;">
                    <form autocomplete="off" method="POST" action="{{ route('expense.datefilter') }}">
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
                                 <th style="width:20%">Date</th>
                                 <th style="width:20%">Amount</th>
                                 <th style="width:20%">Description</th>
                                 <th style="width:20%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($expense_data as $keydata => $expense_datas)
                              <tr>
                                 <td>{{ ++$keydata }}</td>
                                 <td>{{ $expense_datas['customer'] }}</td>
                                 <td>{{ date('d M Y', strtotime($expense_datas['date'])) }} - {{ date('h:i A', strtotime($expense_datas['time'])) }}</td>
                                 <td>{{ $expense_datas['amount'] }}</td>
                                 <td>{{ $expense_datas['description'] }}</td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                          <a class="badge" href="#edit{{ $expense_datas['unique_id'] }}" data-bs-toggle="modal"
                                          data-bs-target=".expenseedit-modal-xl{{ $expense_datas['unique_id'] }}" style="color: white;background: #a9ac11;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $expense_datas['unique_id'] }}" data-bs-toggle="modal"
                                          data-bs-target=".expensedelete-modal-xl{{ $expense_datas['unique_id'] }}" class="badge bg-danger" style="color: white;">Delete</a>
                                       </li>
                                    </ul>

                                 </td>
                              </tr>

                              <div class="modal fade expenseedit-modal-xl{{ $expense_datas['unique_id'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="expenseeditLargeModalLabel{{ $expense_datas['unique_id'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.expense.edit')
                              </div>
                              <div class="modal fade expensedelete-modal-xl{{ $expense_datas['unique_id'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="expensedeleteLargeModalLabel{{ $expense_datas['unique_id'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.expense.delete')
                              </div>
                           @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>

            </div>
         </div>
         <div class="col-sm-3">
            @include('page.backend.expense.create')
         </div>


      </div>

   </div>
</div>
@endsection
