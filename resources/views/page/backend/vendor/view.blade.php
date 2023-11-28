@extends('layout.backend.auth')

@section('content')

<div class="page-wrapper">
   <div class="content container-fluid">

      <div class="page-header">
         <div class="content-page-header">
            <h6>VENDOR - <span style="color:green;text-transform: uppercase;">{{ $VendorData->name }}</span></h6>


            <div class="list-btn">
                  <div style="display:flex;">
                     <ul class="filter-list">
                        <li>
                        <form autocomplete="off" method="POST" action="{{ route('vendor.viewfilter', ['unique_key' => $VendorData->unique_key]) }}" enctype="multipart/form-data">
                           @method('PUT')
                           @csrf
                           <div class="page-btn" style="display: flex">
                              

                              <div class="col-lg-3 col-sm-3 col-12" style="margin: 0px 3px;">
                                    <div class="form-group">
                                       <label>From</label>
                                       <input type="date" class="form-control" name="fromdate" id="fromdate" value="{{$fromdate}}" style="color:black">
                                    </div>
                              </div>
                              <div class="col-lg-3 col-sm-3 col-12" style="margin: 0px 3px;">
                                    <div class="form-group">
                                       <label>To</label>
                                       <input type="date" name="todate" class="form-control" id="todate" value="{{$todate}}" style="color:black">
                                    </div>
                              </div>
                              <input type="hidden" name="customerid" id="customerid" value="{{$todate}}" />
                              <input type="hidden" name="uniquekey" id="uniquekey" value="{{$VendorData->unique_key}}" />
                              <div class="col-lg-2 col-sm-2 col-12" style="margin: 0px 3px;">
                                    <div class="form-group">
                                       <label style="opacity: 0%;">Action</label>
                                       <input type="submit" class="btn btn-primary" name="submit" value="Search" />
                                    </div>
                              </div>

                              <div class="col-lg-4 col-sm-4 col-12" style="margin-top:28px;">
                                 <div class="form-group">
                                    <label style="opacity: 0%;"></label>
                                    <a href="/vendorview_pdfexport/{{$VendorData->unique_key}}/{{$fromdate}}/{{$todate}}" class="badges bg-lightgrey btn btn-success">Pdf Export</a>
                                 </div>
                              </div>
                           </div>
                        </form>
                        </li>
                     </ul>
                  </div>
                  
               </div>
         </div>
      </div>




<div class="row">
         <div class="col-xl-4 col-sm-6 col-12">
            <div class="card" style="background: #cfe35bdb;">
               <div class="card-body">
                  <div class="dash-widget-header">
                     <span class="dash-widget-icon bg-1">
                     <i class="fas fa-dollar-sign"></i>
                     </span>
                     <div class="dash-count">
                        <div class="dash-title" style="color:#e93131;font-size: 18px;text-transform: uppercase;">Total Amount</div>
                        <div class="dash-counts">
                              <p> ₹ {{$totpurchaseamount}}</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-4 col-sm-6 col-12">
            <div class="card" style="background: #5be35bc4;">
               <div class="card-body">
                  <div class="dash-widget-header">
                     <span class="dash-widget-icon bg-2">
                        <i class="fas fa-users"></i>
                     </span>
                     <div class="dash-count">
                        <div class="dash-title" style="color:#e93131;font-size: 18px;text-transform: uppercase;">Total Paid</div>
                        <div class="dash-counts">
                           <p> ₹ {{$total_amount_paid}}</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-4 col-sm-6 col-12">
            <div class="card" style="background: #ff000073;">
               <div class="card-body">
                  <div class="dash-widget-header">
                     <span class="dash-widget-icon bg-3">
                        <i class="fas fa-file-alt"></i>
                     </span>
                     <div class="dash-count">
                        <div class="dash-title" style="color:white;font-size: 18px;text-transform: uppercase;">Balance</div>
                        <div class="dash-counts">
                        <p> ₹ {{$total_balance}}</p>
                     </div>
                  </div>
               </div>
               </div>
            </div>
         </div>
</div>







      <div class="card invoices-tabs-card">
         <div class="invoices-main-tabs">
            <div class="row align-items-center">
               <div class="col-lg-12">
                  <div class="invoices-tabs">
                     <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
                        <li class="nav-item" ><a href="#solid-rounded-justified-tab1" class="nav-link active" data-bs-toggle="tab" style="padding-top: 8px;">PURCHASE</a></li>
                        <li class="nav-item"><a href="#solid-rounded-justified-tab2" class="nav-link" data-bs-toggle="tab" style="padding-top: 8px;">PAYMENT RECEIPT</a></li>
                     </ul>

                     <div class="tab-content">
                        <div class="tab-pane show active" id="solid-rounded-justified-tab1">
                        


                        <div class="card">
                              <div class="table-responsive">
                                 <table class="table table-center table-hover datatable">
                                    <thead class="thead-light">
                                       <tr>
                                          <th>Purchase Number</th>
                                          <th>Date</th>
                                          <th>Gross Amount</th>
                                          <th>Discount</th>
                                          <th>Tax </th>
                                          <th>Extra Cost</th>
                                          <th>Grand Total</th>
                                          <th>Paid Amount</th>
                                       </tr>
                                    </thead>
                                       <tbody>
                                       @foreach ($Purchase_data as $keydata => $Purchase_datas)
                                          <tr>
                                             <td># {{$Purchase_datas['purchase_number']}}</td>
                                             <td>{{ date('d-m-Y', strtotime($Purchase_datas['date'])) }}</td>
                                             <td>{{$Purchase_datas['purchase_subtotal']}}</td>
                                             <td>{{$Purchase_datas['purchase_discountprice']}}</td>
                                             <td>{{$Purchase_datas['purchase_taxamount']}}</td>
                                             <td>{{$Purchase_datas['purchase_extracostamount']}}</td>
                                             <td><span class="badge bg-primary-light">₹  {{$Purchase_datas['purchase_grandtotal']}}</span></td>
                                             <td><span class="badge" style="background-color:#c3e12e;color:black;">₹  {{$Purchase_datas['purchase_paidamount']}}</span></td>
                                          </tr>
                                          @endforeach
                                       </tbody>
                                 </table>
                              </div>
                        </div>

                        </div>



                        <div class="tab-pane" id="solid-rounded-justified-tab2">
                                 <div class="card">
                                    <div class="table-responsive">
                                       <table class="table table-center table-hover datatable">
                                          <thead class="thead-light">
                                             <tr>
                                                <th>Date</th>
                                                <th>Discount</th>
                                                <th>Paid Amount </th>
                                                <th>Note</th>
                                             </tr>
                                          </thead>
                                             <tbody>
                                             @foreach ($PaymentData as $keydata => $PaymentDatas)
                                                <tr>
                                                   <td>{{ date('d-m-Y', strtotime($PaymentDatas['date'])) }}</td>
                                                   <td>₹  {{$PaymentDatas['discount']}}</td>
                                                   <td><span class="badge" style="background-color:#c3e12e;color:black;">₹  {{$PaymentDatas['paid_amount']}}</span></td>
                                                   <td>{{$PaymentDatas['note']}}</td>
                                                </tr>
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
         </div>
      </div>








   </div>
</div>
@endsection