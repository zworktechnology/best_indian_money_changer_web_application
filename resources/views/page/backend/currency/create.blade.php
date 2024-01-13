<form autocomplete="off" method="POST" action="{{ route('currency.store') }}">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="form-group-item">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="India">
                        </div>
                        <div class="form-group">
                            <label>Code <span style="color: gray"></span><span
                                    class="text-danger">*</span></label>
                            <input type="text" name="code" id="code" class="form-control" placeholder="INR">
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
