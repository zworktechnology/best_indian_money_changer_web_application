<div class="modal-dialog modal-dialog-centered modal-md">
   <div class="modal-content">

      <div class="modal-header border-0 pb-0">
         <div class="form-header modal-header-title text-start mb-0">
            <h6 class="mb-0">Update Currency Optima</h6>
         </div>
         <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span class="align-center" aria-hidden="true">&times;</span>
         </button>
      </div>
      <form autocomplete="off" method="POST"
                action="{{ route('currency_optimal.edit', ['id' => $currency_optimals['id']]) }}" enctype="multipart/form-data">
                @csrf
      <div class="modal-body">
         <div class="row">
                     <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Currency Code<span class="text-danger">*</span></label>
                              <select
                                    class="form-control select  js-example-basic-single"
                                    name="currency_id" id="currency_id" required>
                                    <option value="" disabled selected hiddden>Select Currency
                                    </option>
                                    @foreach ($currency_data as $currency_datas)
                                        <option value="{{ $currency_datas->id }}"@if ($currency_datas->id === $currency_optimals['currency_id']) selected='selected' @endif>{{ $currency_datas->code }} - {{ $currency_datas->name }}
                                        </option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label>Name <span style="color: gray"></span><span
                                    class="text-danger">*</span></label>
                            <input type="text" name="currency_optimal_name" id="currency_optimal_name" class="form-control" required placeholder="2000" value="{{ $currency_optimals['currencyoptimal_name'] }}" >
                        </div>
                        <div class="form-group">
                            <label>Available Stock <span style="color: gray"></span><span
                                    class="text-danger">*</span></label>
                            <input type="number" name="available_stock" id="available_stock" class="form-control" required placeholder="Available stock in numbers" value="{{ $currency_optimals['available_stock'] }}" >
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