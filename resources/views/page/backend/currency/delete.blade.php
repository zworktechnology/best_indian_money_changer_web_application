<div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content modal-filled">
         <div class="modal-body">
            <div class="form-header">
               <h6 class="text-black">Delete Curreny Detail</h6>
               <p class="text-black">Are you sure want to delete?</p>
            </div>
            <div class="modal-btn delete-action">
               <div class="row">

                  <form autocomplete="off" method="POST" action="{{ route('currency.delete', [$currency_index_datas->unique_id]) }}">
                     @method('PUT')
                     @csrf

                     <div class="col-6">
                        <button type="submit" class="btn btn-primary paid-continue-btn">Yes, Delete</button>
                     </div>
                  </form>

                  <div class="col-6">
                     <a href="#" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
</div>
