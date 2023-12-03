<div class="modal-dialog modal-dialog-centered modal-m">
   <div class="modal-content">
         <div class="modal-header border-0 pb-0">
            <div class="form-header modal-header-title text-start mb-0">
               <h6 class="mb-0">Update Sales Details</h6>
            </div>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span class="align-center" aria-hidden="true">&times;</span>
            </button>
         </div>

         <form autocomplete="off" method="POST"
                action="{{ route('sale.edit', ['unique_id' => $sales_index_datas->unique_id]) }}" enctype="multipart/form-data">
                @csrf

            <div class="modal-body">
               <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Currency<span class="text-danger"> *</span></label>
                                <select
                                    class="form-control select currency_id js-example-basic-single"
                                    name="currency_id" id="currency_id" required>
                                    <option value="" disabled selected hiddden>Select Purchase Currency
                                    </option>
                                    @foreach ($currency_data as $currency_datas)
                                        <option @if ($currency_datas->id === $sales_index_datas->currency_id) selected='selected' @endif value="{{ $currency_datas->id }}">{{ $currency_datas->code }} - {{ $currency_datas->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Count<span class="text-danger"> *</span></label>
                            <input type="number" name="sales_count" id="sales_count" class="form-control" placeholder="2" value="{{ $sales_index_datas->sales_count }}">
                        </div>
                        <div class="form-group">
                            <label>Price Per Currency in INR<span class="text-danger"> *</span></label>
                            <input type="number" name="sales_count_per_price" id="sales_count_per_price" class="form-control" placeholder="60" value="{{ $sales_index_datas->sales_count_per_price }}">
                        </div>
                        <div class="form-group">
                            <label>Total<span class="text-danger"> *</span></label>
                            <input type="number" name="total" id="total" class="form-control" placeholder="120" value="{{ $sales_index_datas->total }}">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="description" id="description" class="form-control"
                                placeholder="Optional" value="{{ $sales_index_datas->description }}">
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
