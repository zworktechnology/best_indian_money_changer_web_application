<form autocomplete="off" method="POST" action="{{ route('expense.store') }}">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="form-group-item">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Date<span class="text-danger"> *</span></label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ $today }}">
                        </div>
                        <div class="form-group">
                            <label>Time<span class="text-danger"> *</span></label>
                            <input type="time" name="time" id="time" class="form-control" value="{{ $timenow }}">
                        </div>
                        <div class="form-group">
                            <label>Customer<span class="text-danger">*</span></label>
                            <select class="form-control select  js-example-basic-single" name="customer_id" id="customer_id" required>
                                   <option value="" disabled selected hiddden>Select Customer </option>
                                        @foreach ($customers as $customers_arr)
                                            <option value="{{ $customers_arr->id }}">{{ $customers_arr->name }}</option>
                                        @endforeach
                                    </select>
                        </div>
                        <div class="form-group">
                            <label>Amount<span class="text-danger">*</span></label>
                            <input type="text" name="amount" id="amount" class="form-control" placeholder="150">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="description" id="description" class="form-control"
                                placeholder="Optional">
                        </div>
                    </div>
                </div>
                <div class="add-customer-btns text-end">
                    <button type="submit" class="btn customer-btn-save">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
