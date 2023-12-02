<div class="modal-dialog modal-dialog-centered modal-m">
   <div class="modal-content">
         <div class="modal-header border-0 pb-0">
            <div class="form-header modal-header-title text-start mb-0">
               <h6 class="mb-0">Update Currency Details</h6>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span class="align-center" aria-hidden="true">&times;</span>
            </button>
         </div>

         <form autocomplete="off" method="POST"
                action="{{ route('currency.edit', ['unique_id' => $currency_index_datas->unique_id]) }}" enctype="multipart/form-data">
                @csrf

            <div class="modal-body">
               <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Currency Code<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="INR" value="{{ $currency_index_datas->name }}">
                        </div>
                        <div class="form-group">
                            <label>Country Name<span class="text-danger">*</span></label>
                            <input type="text" name="country" id="country" class="form-control"
                                placeholder="India" value="{{ $currency_index_datas->country }}">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="description" id="description" class="form-control"
                                placeholder="Optional" value="{{ $currency_index_datas->description }}">
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
