<div class="modal-dialog modal-dialog-centered modal-m">
   <div class="modal-content">
         <div class="modal-header border-0 pb-0">
            <div class="form-header modal-header-title text-start mb-0">
               <h6 class="mb-0">Update Credit Note Details</h6>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span class="align-center" aria-hidden="true">&times;</span>
            </button>
         </div>

         <form autocomplete="off" method="POST"
                action="{{ route('income.edit', ['unique_id' => $Income_datas['unique_id']]) }}" enctype="multipart/form-data">
                @csrf

            <div class="modal-body">
               <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Amount<span class="text-danger">*</span></label>
                            <input type="text" name="amount" id="amount" class="form-control" placeholder="150" value="{{ $Income_datas['amount'] }}">
                        </div>
                        <div class="form-group">
                            <label>Customer<span class="text-danger">*</span></label>
                            <select class="form-control select js-example-basic-single" name="customer_id" id="customer_id" required>
                                   <option value="" disabled selected hiddden>Select Customer </option>
                                        @foreach ($customers as $customers_arr)
                                            <option value="{{ $customers_arr->id }}"@if ($customers_arr->id === $Income_datas['customer_id']) selected='selected' @endif>{{ $customers_arr->name }}</option>
                                        @endforeach
                                    </select>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="description" id="description" class="form-control"
                                placeholder="Optional" value="{{ $Income_datas['description'] }}">
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
