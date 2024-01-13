<div class="modal-dialog modal-dialog-centered modal-xl">
   <div class="modal-content">

         <div class="modal-header border-0 pb-0">
            <div class="form-header modal-header-title text-start mb-0">
            <h6 class="mb-0" style="color:green">Sale</h6>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span class="align-center" aria-hidden="true">&times;</span>
            </button>
         </div>

        

            <div class="modal-body">
               <div class="content container-fluid">

               


                           <div class="invoice-item invoice-item-date ">
                              <div class="row">
                                 <div class="col-md-1" ></div>
                                 <div class="col-md-4" >
                                    <p class="text-start invoice-details" style="color:#000;text-transform: uppercase;">
                                       Bill Number<span>: </span><strong style="color:red;"># {{ $saledatas['billno'] }}</strong>
                                    </p>
                                 </div>
                                 <div class="col-md-3">
                                    <p class="text-start invoice-details" style="color:#000;text-transform: uppercase;">
                                       Date<span>: </span><strong style="color:red;">{{ date('M d Y', strtotime($saledatas['date'])) }}</strong>
                                    </p>
                                 </div>
                                 <div class="col-md-4">
                                    <p class="invoice-details" style="color:#000;text-transform: uppercase;">
                                       Customer<span>: </span><strong style="color:red;text-transform: uppercase;">{{ $saledatas['customer'] }}</strong>
                                    </p>
                                 </div>
                              </div>
                           </div>


                           <div class="invoice-item invoice-item-two">
                              <div class="row">

                                 <div class="col-md-4 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px; text-transform: uppercase;">Currency</span>
                                 </div>
                                 <div class="col-md-2 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px;text-transform: uppercase; ">Currency Optimal</span>
                                 </div>
                                 <div class="col-md-3 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px;text-transform: uppercase; ">Count</span>
                                 </div>
                                 <div class="col-md-3 border">
                                       <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 700;line-height: 35px;text-transform: uppercase; ">Total</span>
                                 </div>

                              </div>
                              <div class="row ">
                                 @foreach ($saledatas['products'] as $index => $products_data)
                                    @if ($products_data['sales_id'] == $saledatas['id'])
                                    <div class="col-md-4 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px;text-transform: uppercase; ">{{ $products_data['currency'] }}</span>
                                    </div>
                                    <div class="col-md-2 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px;text-transform: uppercase; ">{{ $products_data['currencyoptimal_amount'] }}</span>
                                    </div>
                                    <div class="col-md-3 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; text-transform: uppercase;">{{ $products_data['count'] }}</span>
                                    </div>
                                    <div class="col-md-3 border">
                                          <span style="vertical-align: inherit;vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;line-height: 35px; text-transform: uppercase;">₹ {{ $products_data['total'] }}</span>
                                    </div>
                                    @endif
                                 @endforeach
                              </div>


                           </div>




                           <div class="terms-conditions">
                              <div class="row align-items-center justify-content-between">

                                    <div class="col-xl-6 col-lg-12">
                                       
                                    </div>

                                    <div class="col-xl-6 col-lg-12">
                                       <div class="invoice-total-card  form-group-bank">
                                          <div class="invoice-total-box">
                                             <div class="invoice-total-inner">
                                                <p style="color: #0d6efd;text-transform: uppercase;">Grand Total <span style="color: #0d6efd;">₹ {{ $saledatas['grand_total'] }}</span></p>
                                                <p style="color: #0d6efd;text-transform: uppercase;">Old Balance <span style="color: #0d6efd;">₹ {{ $saledatas['oldbalanceamount'] }}</span></p>
                                                <p style="color: #0d6efd;text-transform: uppercase;">Total <span style="color: #0d6efd;">₹ {{ $saledatas['overallamount'] }}</span></p>
                                                <p style="color:green;text-transform: uppercase;">Paid Amount <span style="color:green">₹ {{ $saledatas['paid_amount'] }}</span></p>
                                                <p style="color:red;text-transform: uppercase;">Balance Amount <span style="color:red">₹ {{ $saledatas['balance_amount'] }}</span></p>
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
</div>