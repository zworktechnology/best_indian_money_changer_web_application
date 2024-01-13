<div class="modal-dialog modal-dialog-centered modal-md">
   <div class="modal-content">

      <div class="modal-header border-0 pb-0">
         <div class="form-header modal-header-title text-start mb-0">
            <h6 class="mb-0">Update Customer</h6>
         </div>
         <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span class="align-center" aria-hidden="true">&times;</span>
         </button>
      </div>
      <form autocomplete="off" method="POST"
                action="{{ route('customer.edit', ['id' => $customers_arr['id']]) }}" enctype="multipart/form-data">
                @csrf
      <div class="modal-body">
         <div class="row">
                     <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Name <span style="color: gray"></span><span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Customer Name" required value="{{ $customers_arr['name'] }}">
                        </div>
                        <div class="form-group">
                            <label>Phone Number<span style="color: gray"></span><span
                                    class="text-danger">*</span></label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Enter Customer MobileNo" required value="{{ $customers_arr['phone_number'] }}">
                        </div>
                        <div class="form-group">
                            <label>Note</label>
                           <textarea name="note" id="note" type="text" class="form-control" placeholder="Enter Note">{{ $customers_arr['note'] }}</textarea>
                        </div>
                    </div>
         </div>
      </div>

      <div class="modal-footer">
         <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Update</button>
         <button type="button" class="btn btn-cancel btn-danger" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
      </div>
      </form>
   </div>
</div>