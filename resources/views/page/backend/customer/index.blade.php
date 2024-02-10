@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Customer</h6>

            <div class="list-btn">
               <div style="display: flex;">
                  <ul class="filter-list">
                     <li>
                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".customer-modal-xl">
                              <i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add Customer</a>
                     </li>
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
                                 <th style="width:10%">S.No</th>
                                 <th style="width:20%">Name</th>
                                 <th style="width:10%">Phone Number</th>
                                 <th style="width:20%">Note</th>
                                 <th style="width:20%">Current Balance</th>
                                 <th style="width:20%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($customers as $keydata => $customers_arr)
                              <tr>
                                 <td>{{ ++$keydata }}</td>
                                 <td>{{ $customers_arr['name'] }}</td>
                                 <td>{{ $customers_arr['phone_number'] }}</td>
                                 <td>{{ $customers_arr['note'] }}</td>
                                 <td>{{ $customers_arr['current_balance'] }}</td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                          <a class="badge" href="#edit{{ $customers_arr['id'] }}" data-bs-toggle="modal"
                                          data-bs-target=".customeredit-modal-xl{{ $customers_arr['id'] }}" style="color: white;background: #a9ac11;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $customers_arr['id'] }}" data-bs-toggle="modal"
                                          data-bs-target=".customerdelete-modal-xl{{ $customers_arr['id'] }}" class="badge bg-danger" style="color: white;">Delete</a>
                                       </li>
                                    </ul>

                                 </td>
                              </tr>

                              <div class="modal fade customeredit-modal-xl{{ $customers_arr['id'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="customereditLargeModalLabel{{ $customers_arr['id'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.customer.edit')
                              </div>
                              <div class="modal fade customerdelete-modal-xl{{ $customers_arr['id'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="customerdeleteLargeModalLabel{{ $customers_arr['id'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.customer.delete')
                              </div>
                           @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>

            </div>
         </div>


      </div>

      <div class="modal fade customer-modal-xl" tabindex="-1" role="dialog" aria-labelledby="customerLargeModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            @include('page.backend.customer.create')
        </div>

   </div>
</div>
@endsection
