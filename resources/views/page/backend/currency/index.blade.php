@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Currency</h6>
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
                                 <th style="width:35%">Name</th>
                                 <th style="width:20%">Code</th>
                                 <th style="width:25%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($currency_index_data as $keydata => $currency_index_datas)
                              <tr>
                                 <td>{{ ++$keydata }}</td>
                                 <td>{{ $currency_index_datas->name }}</td>
                                 <td>{{ $currency_index_datas->code }}</td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                          <a class="badge bg-success" href="#edit{{ $currency_index_datas->unique_id }}" data-bs-toggle="modal"
                                          data-bs-target=".currencyedit-modal-xl{{ $currency_index_datas->unique_id }}" style="color: white;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $currency_index_datas->unique_id }}" data-bs-toggle="modal"
                                          data-bs-target=".currencydelete-modal-xl{{ $currency_index_datas->unique_id }}" class="badge bg-danger" style="color: white;">Delete</a>
                                       </li>
                                    </ul>

                                 </td>
                              </tr>

                              <div class="modal fade currencyedit-modal-xl{{ $currency_index_datas->unique_id }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="currencyeditLargeModalLabel{{ $currency_index_datas->unique_id }}"
                                    aria-hidden="true">
                                    @include('page.backend.currency.edit')
                              </div>
                              <div class="modal fade currencydelete-modal-xl{{ $currency_index_datas->unique_id }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="currencydeleteLargeModalLabel{{ $currency_index_datas->unique_id }}"
                                    aria-hidden="true">
                                    @include('page.backend.currency.delete')
                              </div>
                           @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>

            </div>
         </div>
         <div class="col-sm-3">
            @include('page.backend.currency.create')
         </div>


      </div>

   </div>
</div>
@endsection
