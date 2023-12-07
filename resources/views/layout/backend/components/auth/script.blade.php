<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<script src="{{ asset('assets/backend/js/jquery-3.7.0.min.js') }}"></script>

<script src="{{ asset('assets/backend/js/feather.min.js') }}"></script>

<script src="{{ asset('assets/backend/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('assets/backend/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/backend/js/bootstrap-datetimepicker.min.js') }}"></script>


<script src="{{ asset('assets/backend/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/backend/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/apexchart/chart-data.js') }}"></script>

<script src="{{ asset('assets/backend/js/script.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

$(document).on("keyup", '.purchases_count', function() {
   var purchases_count = $(this).val();
   var purchases_count_per_price = $(".purchases_count_per_price").val();
   var total_purchse = purchases_count * purchases_count_per_price;
   $('.total_purchasevalue').val(total_purchse.toFixed(2));
});


$(document).on("keyup", '.purchases_count_per_price', function() {
   var purchases_count_per_price = $(this).val();
   var purchases_count = $(".purchases_count").val();
   var total_purchse = purchases_count * purchases_count_per_price;
   $('.total_purchasevalue').val(total_purchse.toFixed(2));
});


$(document).on("keyup", '.sales_count', function() {
   var sales_count = $(this).val();
   var sales_count_per_price = $(".sales_count_per_price").val();
   var total_sale = sales_count * sales_count_per_price;
   $('.total_salevalue').val(total_sale.toFixed(2));
});


$(document).on("keyup", '.sales_count_per_price', function() {
   var sales_count_per_price = $(this).val();
   var sales_count = $(".sales_count").val();
   var total_sale = sales_count * sales_count_per_price;
   $('.total_salevalue').val(total_sale.toFixed(2));
});
</script>