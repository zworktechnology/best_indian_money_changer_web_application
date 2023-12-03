<form autocomplete="off" method="POST" action="{{ route('sale.store') }}">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="form-group-item">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Date<span class="text-danger"> *</span></label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ $today_date }}">
                        </div>
                        <div class="form-group">
                            <label>Time<span class="text-danger"> *</span></label>
                            <input type="time" name="time" id="time" class="form-control" value="{{ $today_time }}">
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label>Currency<span class="text-danger"> *</span></label>
                                <select
                                    class="form-control select currency_id js-example-basic-single"
                                    name="currency_id" id="currency_id" required>
                                    <option value="" disabled selected hiddden>Select Purchase Currency
                                    </option>
                                    @foreach ($currency_data as $currency_datas)
                                        <option value="{{ $currency_datas->id }}">{{ $currency_datas->code }} - {{ $currency_datas->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Count<span class="text-danger"> *</span></label>
                            <input type="number" name="sales_count" id="sales_count" class="form-control" placeholder="2">
                        </div>
                        <div class="form-group">
                            <label>Price Per Currency in INR<span class="text-danger"> *</span></label>
                            <input type="number" name="sales_count_per_price" id="sales_count_per_price" class="form-control" placeholder="60">
                        </div>
                        <div class="form-group">
                            <label>Total<span class="text-danger"> *</span></label>
                            <input type="number" name="total" id="total" class="form-control" placeholder="120">
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
