@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>Currency Optimal</h6>

            <div class="list-btn">
               <div style="display: flex;">
                  <ul class="filter-list">
                     <li>
                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".currencyoptimal-modal-xl">
                              <i class="fa fa-plus-circle me-2" aria-hidden="true"></i>Add CurrencyOptimal</a>
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
                                 <th style="width:20%">Currency Code</th>
                                 <th style="width:20%">Name</th>
                                 <th style="width:20%">Available Stock</th>
                                 <th style="width:30%">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                           @foreach ($currency_optimal as $keydata => $currency_optimals)
                              <tr>
                                 <td>{{ ++$keydata }}</td>
                                 <td>{{ $currency_optimals['code'] }}</td>
                                 <td>{{ $currency_optimals['currencyoptimal_name'] }}</td>
                                 <td>{{ $currency_optimals['available_stock'] }}</td>
                                 <td>
                                    <ul class="list-unstyled hstack gap-1 mb-0">
                                       <li>
                                          <a class="badge bg-success" href="#edit{{ $currency_optimals['id'] }}" data-bs-toggle="modal"
                                          data-bs-target=".currencyoptimaledit-modal-xl{{ $currency_optimals['id'] }}" style="color: white;">Edit</a>
                                       </li>
                                       <li>
                                          <a href="#delete{{ $currency_optimals['id'] }}" data-bs-toggle="modal"
                                          data-bs-target=".currencyoptimaldelete-modal-xl{{ $currency_optimals['id'] }}" class="badge bg-danger" style="color: white;">Delete</a>
                                       </li>
                                    </ul>

                                 </td>
                              </tr>

                              <div class="modal fade currencyoptimaledit-modal-xl{{ $currency_optimals['id'] }}"
                                    tabindex="-1" role="dialog" data-bs-backdrop="static"
                                    aria-labelledby="currencyoptimaleditLargeModalLabel{{ $currency_optimals['id'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.currency_optimal.edit')
                              </div>
                              <div class="modal fade currencyoptimaldelete-modal-xl{{ $currency_optimals['id'] }}"
                                    tabindex="-1" role="dialog"data-bs-backdrop="static"
                                    aria-labelledby="currencyoptimaldeleteLargeModalLabel{{ $currency_optimals['id'] }}"
                                    aria-hidden="true">
                                    @include('page.backend.currency_optimal.delete')
                              </div>
                           @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>

            </div>
         </div>


      </div>

      <div class="modal fade currencyoptimal-modal-xl" tabindex="-1" role="dialog" aria-labelledby="vendorLargeModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            @include('page.backend.currency_optimal.create')
        </div>

   </div>
</div>
@endsection
