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



var i = 1;
var j = 1;
var k = 1;
var l = 1;
$(document).ready(function() {
            $('.js-example-basic-single').select2();

            $(".customerphoneno").keyup(function() {
                var query = $(this).val();

                if (query != '') {

                    $.ajax({
                        url: "{{ route('customer.checkduplicate') }}",
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            query: query
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response['data']);
                            if(response['data'] != null){
                                alert('Customer Already Existed');
                                $('.customerphoneno').val('');
                            }
                        }
                    });
                }

            });


            $('#salecurrency_id' + 1).on('change', function() {
                var currency_id = this.value;

                $.ajax({
                    url: '/getcurrencyamount/' + currency_id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response['data']);

                        var output = response['data'].length;
                            $('#currency_optimal_id' + 1).empty();
                            $('#currencyoptimal_amount' + 1).val('');

                            var $select = $('#currency_optimal_id' + 1).append(
                                $('<option>', {
                                    value: '0',
                                    text: 'Select'
                                }));
                            $('#currency_optimal_id' + 1).append($select);

                            for (var i = 0; i < output; i++) {
                                $('#currency_optimal_id' + 1).append($('<option>', {
                                    value: response['data'][i].id,
                                    text: response['data'][i].name
                                }));


                                $('#currency_optimal_id' + 1).on('change', function() {
                                    var currency_optimal_id = this.value;

                                    $.ajax({
                                    url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                    type: 'get',
                                    dataType: 'json',
                                    success: function(response) {
                                        $('#currencyoptimal_amount' + 1).val('');
                                        console.log(response['data']);
                                        $('#currencyoptimal_amount' + 1).val(response['data']);
                                                var sale_count = $('#sale_count' + 1).val();
                                                var total = sale_count * response['data'];
                                                $('#sale_total' + 1).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.overallamount').val(grand_total.toFixed(2));
                                                $('.sale_overallamount').text(grand_total.toFixed(2));

                                                var salepaid_amount = $('.salepaid_amount').val();
                                                var balance = Number(grand_total) - Number(salepaid_amount);
                                                $('.balance_amount').val(balance.toFixed(2));
                                                $('.salebalance_amount').text('₹ ' + balance.toFixed(2));

                                        }
                                    });
                                });
                            }

                    }
                });
            });



            $('.salecustomer_id').on('change', function() {
                var salecustomer_id = $(this).val();
                if(salecustomer_id){
                        $('.saleold_balance').text('');
                        $('.oldbalanceamount').val('');
                        $.ajax({
                        url: '/getoldbalance/',
                        type: 'get',
                        data: {_token: "{{ csrf_token() }}",
                                salecustomer_id: salecustomer_id,
                                },
                        dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                        $(".oldbalanceamount").val(response['data']);
                                        $('.saleold_balance').text(response['data']);

                                        var gross_amount = $(".grand_total").val();
                                        var grand_total = Number(response['data']) + Number(gross_amount);
                                        $('.overallamount').val(grand_total.toFixed(2));
                                        $('.sale_overallamount').text(grand_total.toFixed(2));

                                        var salepaid_amount = $(".salepaid_amount").val();
                                        var pending_amount = Number(grand_total) - Number(salepaid_amount);
                                        $('.balance_amount').val(pending_amount.toFixed(2));
                                        $('.salebalance_amount').text(pending_amount.toFixed(2));
                            }
                        });
                }
            });




            $('#purchasecurrency_id' + 1).on('change', function() {
                var currency_id = this.value;

                $.ajax({
                    url: '/getcurrencyamount/' + currency_id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response['data']);

                        var output = response['data'].length;
                            $('#purchasecurrency_optimal_id' + 1).empty();
                            $('#purchasecurrencyoptimal_amount' + 1).val('');

                            var $select = $('#purchasecurrency_optimal_id' + 1).append(
                                $('<option>', {
                                    value: '0',
                                    text: 'Select'
                                }));
                            $('#purchasecurrency_optimal_id' + 1).append($select);

                            for (var i = 0; i < output; i++) {
                                $('#purchasecurrency_optimal_id' + 1).append($('<option>', {
                                    value: response['data'][i].id,
                                    text: response['data'][i].name
                                }));


                                $('#purchasecurrency_optimal_id' + 1).on('change', function() {
                                    var currency_optimal_id = this.value;

                                    $.ajax({
                                    url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                    type: 'get',
                                    dataType: 'json',
                                    success: function(response) {
                                        $('#purchasecurrencyoptimal_amount' + 1).val('');
                                        console.log(response['data']);
                                        $('#purchasecurrencyoptimal_amount' + 1).val(response['data']);
                                                var purchase_count = $('#purchase_count' + 1).val();
                                                var total = purchase_count * response['data'];
                                                $('#purchase_total' + 1).val(total);

                                                var sum = 0;
                                                $(".purchase_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".purchasegrandtotal").val(sum.toFixed(2));
                                                $('.purchasegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".purchaseoldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.purchaseoverallamount').val(grand_total.toFixed(2));
                                                $('.purchase_overallamount').text(grand_total.toFixed(2));

                                                var purchasepaid_amount = $('.purchasepaid_amount').val();
                                                var balance = Number(grand_total) - Number(purchasepaid_amount);
                                                $('.purchasebalanceamount').val(balance.toFixed(2));
                                                $('.purchasebalance_amount').text('₹ ' + balance.toFixed(2));

                                        }
                                    });
                                });
                            }

                    }
                });
            });






            $('.purchasecustomer_id').on('change', function() {
                var purchasecustomer_id = $(this).val();
                if(purchasecustomer_id){
                        $('.purchaseold_balance').text('');
                        $('.purchaseoldbalanceamount').val('');
                        $.ajax({
                        url: '/getoldbalanceforpurchase/',
                        type: 'get',
                        data: {_token: "{{ csrf_token() }}",
                        purchasecustomer_id: purchasecustomer_id,
                                },
                        dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                        $(".purchaseoldbalanceamount").val(response['data']);
                                        $('.purchaseold_balance').text(response['data']);

                                        var gross_amount = $(".purchasegrandtotal").val();
                                        var grand_total = Number(response['data']) + Number(gross_amount);
                                        $('.purchaseoverallamount').val(grand_total.toFixed(2));
                                        $('.purchase_overallamount').text(grand_total.toFixed(2));

                                        var purchasepaid_amount = $(".purchasepaid_amount").val();
                                        var pending_amount = Number(grand_total) - Number(purchasepaid_amount);
                                        $('.purchasebalanceamount').val(pending_amount.toFixed(2));
                                        $('.purchasebalance_amount').text(pending_amount.toFixed(2));
                            }
                        });
                }
            });






          
           

            $(document).on('click', '.addsalefields', function() {
                ++i;

                let  rowIndex = $('.auto_num').length+1;
                let  rowIndexx = $('.auto_num').length+1;

                $(".saleproduct_fields").append(
                    '<tr>' +
                    '<td><input class="auto_num form-control"  type="text" readonly value="'+rowIndexx+'"/></td>' +
                    '<td class=""><input type="hidden" id="sales_products_id" name="sales_products_id[]" />' +
                    '<select class="form-control  currency_id select js-example-basic-single"  name="currency_id[]" id="salecurrency_id' + i + '"required>' +
                    '<option value="" selected hidden class="text-muted">Select Currency</option></select>' +
                    '</td>' +
                    '<td><select class="form-control  currency_optimal_id select js-example-basic-single" name="currency_optimal_id[]" id="currency_optimal_id' + i + '" required>' +
                    '<option value="" selected hidden class="text-muted">Select CurrencyOptimal</option></select>' +
                    '<input type="hidden" class="form-control currencyoptimal_amount" id="currencyoptimal_amount' + i + '" name="currencyoptimal_amount[]"  value="" required /></td>' +
                    '<td><input type="text" class="form-control sale_count" id="sale_count' + i + '" name="sale_count[]" placeholder="Count" /></td>' +
                    '<td><input type="text" class="form-control sale_total" readonly id="sale_total' + i + '" name="sale_total[]" placeholder="Total" /></td>' +
                    '<td><button class="btn btn-primary form-plus-btn addsalefields" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button><button class="btn btn-danger form-plus-btn remove-tr" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button></td>' +
                    '</tr>'
                );
                $(".saleproduct_fields").find('.js-example-basic-single').select2();


                $.ajax({
                    url: '/getcurrencies/',
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        //console.log(response['data']);
                        var len = response['data'].length;

                        var selectedValues = new Array();

                        if (len > 0) {
                            for (var i = 0; i < len; i++) {

                                    var id = response['data'][i].id;
                                    var name = response['data'][i].name + '-' + response['data'][i].code;
                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    selectedValues.push(option);
                            }
                        }
                        ++j;
                        $('#salecurrency_id' + j).append(selectedValues);
                        //add_count.push(Object.keys(selectedValues).length);
                    }
                });

                if(i == '2'){
                    $('#salecurrency_id' + i).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#currency_optimal_id' + 2).empty();


                                    var $select = $('#currency_optimal_id' + 2).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#currency_optimal_id' + 2).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#currency_optimal_id' + 2).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#currency_optimal_id' + 2).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#currencyoptimal_amount' + 2).val('');
                                                console.log(response['data']);
                                                $('#currencyoptimal_amount' + 2).val(response['data']);
                                                var sale_count = $('#sale_count' + 2).val();
                                                var total = sale_count * response['data'];
                                                $('#sale_total' + 2).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.overallamount').val(grand_total.toFixed(2));
                                                $('.sale_overallamount').text(grand_total.toFixed(2));

                                                var salepaid_amount = $('.salepaid_amount').val();
                                                var balance = Number(grand_total) - Number(salepaid_amount);
                                                $('.balance_amount').val(balance.toFixed(2));
                                                $('.salebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }
                    

                if(i == '3'){
                    $('#salecurrency_id' + i).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#currency_optimal_id' + 3).empty();


                                    var $select = $('#currency_optimal_id' + 3).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#currency_optimal_id' + 3).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#currency_optimal_id' + 3).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));
                                        $('#currency_optimal_id' + 3).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#currencyoptimal_amount' + 3).val('');
                                                console.log(response['data']);
                                                $('#currencyoptimal_amount' + 3).val(response['data']);
                                                var sale_count = $('#sale_count' + 3).val();
                                                var total = sale_count * response['data'];
                                                $('#sale_total' + 3).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.overallamount').val(grand_total.toFixed(2));
                                                $('.sale_overallamount').text(grand_total.toFixed(2));

                                                var salepaid_amount = $('.salepaid_amount').val();
                                                var balance = Number(grand_total) - Number(salepaid_amount);
                                                $('.balance_amount').val(balance.toFixed(2));
                                                $('.salebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }

                if(i == '4'){
                    $('#salecurrency_id' + i).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#currency_optimal_id' + 4).empty();


                                    var $select = $('#currency_optimal_id' + 4).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#currency_optimal_id' + 4).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#currency_optimal_id' + 4).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#currency_optimal_id' + 4).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#currencyoptimal_amount' + 4).val('');
                                                console.log(response['data']);
                                                $('#currencyoptimal_amount' + 4).val(response['data']);
                                                var sale_count = $('#sale_count' + 4).val();
                                                var total = sale_count * response['data'];
                                                $('#sale_total' + 4).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.overallamount').val(grand_total.toFixed(2));
                                                $('.sale_overallamount').text(grand_total.toFixed(2));

                                                var salepaid_amount = $('.salepaid_amount').val();
                                                var balance = Number(grand_total) - Number(salepaid_amount);
                                                $('.balance_amount').val(balance.toFixed(2));
                                                $('.salebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }



                if(i == '5'){
                    $('#salecurrency_id' + i).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#currency_optimal_id' + 5).empty();


                                    var $select = $('#currency_optimal_id' + 5).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#currency_optimal_id' + 5).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#currency_optimal_id' + 5).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#currency_optimal_id' + 5).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#currencyoptimal_amount' + 5).val('');
                                                console.log(response['data']);
                                                $('#currencyoptimal_amount' + 5).val(response['data']);
                                                var sale_count = $('#sale_count' + 5).val();
                                                var total = sale_count * response['data'];
                                                $('#sale_total' + 5).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.overallamount').val(grand_total.toFixed(2));
                                                $('.sale_overallamount').text(grand_total.toFixed(2));

                                                var salepaid_amount = $('.salepaid_amount').val();
                                                var balance = Number(grand_total) - Number(salepaid_amount);
                                                $('.balance_amount').val(balance.toFixed(2));
                                                $('.salebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }


                if(i == '6'){
                    $('#salecurrency_id' + i).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#currency_optimal_id' + 6).empty();


                                    var $select = $('#currency_optimal_id' + 6).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#currency_optimal_id' + 6).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#currency_optimal_id' + 6).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#currency_optimal_id' + 6).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#currencyoptimal_amount' + 6).val('');
                                                console.log(response['data']);
                                                $('#currencyoptimal_amount' + 6).val(response['data']);
                                                var sale_count = $('#sale_count' + 6).val();
                                                var total = sale_count * response['data'];
                                                $('#sale_total' + 6).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.overallamount').val(grand_total.toFixed(2));
                                                $('.sale_overallamount').text(grand_total.toFixed(2));

                                                var salepaid_amount = $('.salepaid_amount').val();
                                                var balance = Number(grand_total) - Number(salepaid_amount);
                                                $('.balance_amount').val(balance.toFixed(2));
                                                $('.salebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }


                if(i == '7'){
                    $('#salecurrency_id' + i).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#currency_optimal_id' + 7).empty();


                                    var $select = $('#currency_optimal_id' + 7).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#currency_optimal_id' + 7).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#currency_optimal_id' + 7).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#currency_optimal_id' + 7).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#currencyoptimal_amount' + 7).val('');
                                                console.log(response['data']);
                                                $('#currencyoptimal_amount' + 7).val(response['data']);
                                                var sale_count = $('#sale_count' + 7).val();
                                                var total = sale_count * response['data'];
                                                $('#sale_total' + 7).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.overallamount').val(grand_total.toFixed(2));
                                                $('.sale_overallamount').text(grand_total.toFixed(2));

                                                var salepaid_amount = $('.salepaid_amount').val();
                                                var balance = Number(grand_total) - Number(salepaid_amount);
                                                $('.balance_amount').val(balance.toFixed(2));
                                                $('.salebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }


                if(i == '8'){
                    $('#salecurrency_id' + i).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#currency_optimal_id' + 8).empty();


                                    var $select = $('#currency_optimal_id' + 8).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#currency_optimal_id' + 8).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#currency_optimal_id' + 8).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#currency_optimal_id' + 8).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#currencyoptimal_amount' + 8).val('');
                                                console.log(response['data']);
                                                $('#currencyoptimal_amount' + 8).val(response['data']);
                                                var sale_count = $('#sale_count' + 8).val();
                                                var total = sale_count * response['data'];
                                                $('#sale_total' + 8).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.overallamount').val(grand_total.toFixed(2));
                                                $('.sale_overallamount').text(grand_total.toFixed(2));

                                                var salepaid_amount = $('.salepaid_amount').val();
                                                var balance = Number(grand_total) - Number(salepaid_amount);
                                                $('.balance_amount').val(balance.toFixed(2));
                                                $('.salebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }


                if(i == '9'){
                    $('#salecurrency_id' + i).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#currency_optimal_id' + 9).empty();


                                    var $select = $('#currency_optimal_id' + 9).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#currency_optimal_id' + 9).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#currency_optimal_id' + 9).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#currency_optimal_id' + 9).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#currencyoptimal_amount' + 9).val('');
                                                console.log(response['data']);
                                                $('#currencyoptimal_amount' + 9).val(response['data']);
                                                var sale_count = $('#sale_count' + 9).val();
                                                var total = sale_count * response['data'];
                                                $('#sale_total' + 9).val(total);


                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.overallamount').val(grand_total.toFixed(2));
                                                $('.sale_overallamount').text(grand_total.toFixed(2));

                                                var salepaid_amount = $('.salepaid_amount').val();
                                                var balance = Number(grand_total) - Number(salepaid_amount);
                                                $('.balance_amount').val(balance.toFixed(2));
                                                $('.salebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }


                if(i == '10'){
                    $('#salecurrency_id' + i).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#currency_optimal_id' + 10).empty();


                                    var $select = $('#currency_optimal_id' + 10).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#currency_optimal_id' + 10).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#currency_optimal_id' + 10).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#currency_optimal_id' + 10).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#currencyoptimal_amount' + 10).val('');
                                                console.log(response['data']);
                                                $('#currencyoptimal_amount' + 10).val(response['data']);
                                                var sale_count = $('#sale_count' + 10).val();
                                                var total = sale_count * response['data'];
                                                $('#sale_total' + 10).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.overallamount').val(grand_total.toFixed(2));
                                                $('.sale_overallamount').text(grand_total.toFixed(2));

                                                var salepaid_amount = $('.salepaid_amount').val();
                                                var balance = Number(grand_total) - Number(salepaid_amount);
                                                $('.balance_amount').val(balance.toFixed(2));
                                                $('.salebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }

                    


            });






            $(document).on('click', '.addpurchasefields', function() {
                ++k;

                let  rowIndex = $('.purchaseauto_num').length+1;
                let  rowIndexx = $('.purchaseauto_num').length+1;

                $(".purchaseproduct_fields").append(
                    '<tr>' +
                    '<td><input class="purchaseauto_num form-control"  type="text" readonly value="'+rowIndexx+'"/></td>' +
                    '<td class=""><input type="hidden" id="purchase_products_id" name="purchase_products_id[]" />' +
                    '<select class="form-control  currency_id select js-example-basic-single"  name="currency_id[]" id="purchasecurrency_id' + k + '"required>' +
                    '<option value="" selected hidden class="text-muted">Select Currency</option></select>' +
                    '</td>' +
                    '<td><select class="form-control  purchasecurrency_optimal_id select js-example-basic-single" name="purchasecurrency_optimal_id[]" id="purchasecurrency_optimal_id' + k + '" required>' +
                    '<option value="" selected hidden class="text-muted">Select CurrencyOptimal</option></select>' +
                    '<input type="hidden" class="form-control purchasecurrencyoptimal_amount" id="purchasecurrencyoptimal_amount' + k + '" name="purchasecurrencyoptimal_amount[]"  value="" required /></td>' +
                    '<td><input type="text" class="form-control purchase_count" id="purchase_count' + k + '" name="purchase_count[]" placeholder="Count" /></td>' +
                    '<td><input type="text" class="form-control purchase_total" readonly id="purchase_total' + k + '" name="purchase_total[]" placeholder="Total" /></td>' +
                    '<td><button class="btn btn-primary form-plus-btn addpurchasefields" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>' +
                    '<button class="btn btn-danger form-plus-btn remove-purchasetr" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button></td>' +
                    '</tr>'
                );
                $(".purchaseproduct_fields").find('.js-example-basic-single').select2();


                $.ajax({
                    url: '/getcurrencies/',
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        //console.log(response['data']);
                        var len = response['data'].length;

                        var selectedValues = new Array();

                        if (len > 0) {
                            for (var i = 0; i < len; i++) {

                                    var id = response['data'][i].id;
                                    var name = response['data'][i].name + '-' + response['data'][i].code;
                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    selectedValues.push(option);
                            }
                        }
                        ++l;
                        $('#purchasecurrency_id' + l).append(selectedValues);
                        //add_count.push(Object.keys(selectedValues).length);
                    }
                });

                if(k == '2'){
                    $('#purchasecurrency_id' + k).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#purchasecurrency_optimal_id' + 2).empty();


                                    var $select = $('#purchasecurrency_optimal_id' + 2).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#purchasecurrency_optimal_id' + 2).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#purchasecurrency_optimal_id' + 2).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#purchasecurrency_optimal_id' + 2).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#purchasecurrencyoptimal_amount' + 2).val('');
                                                console.log(response['data']);
                                                $('#purchasecurrencyoptimal_amount' + 2).val(response['data']);
                                                var purchase_count = $('#purchase_count' + 2).val();
                                                var total = purchase_count * response['data'];
                                                $('#purchase_total' + 2).val(total);

                                                var sum = 0;
                                                $(".purchase_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".purchasegrandtotal").val(sum.toFixed(2));
                                                $('.purchasegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".purchaseoldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.purchaseoverallamount').val(grand_total.toFixed(2));
                                                $('.purchase_overallamount').text(grand_total.toFixed(2));

                                                var purchasepaid_amount = $('.purchasepaid_amount').val();
                                                var balance = Number(grand_total) - Number(purchasepaid_amount);
                                                $('.purchasebalanceamount').val(balance.toFixed(2));
                                                $('.purchasebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }
                    

                if(k == '3'){
                    $('#purchasecurrency_id' + k).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#purchasecurrency_optimal_id' + 3).empty();


                                    var $select = $('#purchasecurrency_optimal_id' + 3).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#purchasecurrency_optimal_id' + 3).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#purchasecurrency_optimal_id' + 3).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#purchasecurrency_optimal_id' + 3).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#purchasecurrencyoptimal_amount' + 3).val('');
                                                console.log(response['data']);
                                                $('#purchasecurrencyoptimal_amount' + 3).val(response['data']);
                                                var purchase_count = $('#purchase_count' + 3).val();
                                                var total = purchase_count * response['data'];
                                                $('#purchase_total' + 3).val(total);

                                                var sum = 0;
                                                $(".purchase_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".purchasegrandtotal").val(sum.toFixed(2));
                                                $('.purchasegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".purchaseoldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.purchaseoverallamount').val(grand_total.toFixed(2));
                                                $('.purchase_overallamount').text(grand_total.toFixed(2));

                                                var purchasepaid_amount = $('.purchasepaid_amount').val();
                                                var balance = Number(grand_total) - Number(purchasepaid_amount);
                                                $('.purchasebalanceamount').val(balance.toFixed(2));
                                                $('.purchasebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }


                if(k == '4'){
                    $('#purchasecurrency_id' + k).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#purchasecurrency_optimal_id' + 4).empty();


                                    var $select = $('#purchasecurrency_optimal_id' + 4).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#purchasecurrency_optimal_id' + 4).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#purchasecurrency_optimal_id' + 4).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#purchasecurrency_optimal_id' + 4).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#purchasecurrencyoptimal_amount' + 4).val('');
                                                console.log(response['data']);
                                                $('#purchasecurrencyoptimal_amount' + 4).val(response['data']);
                                                var purchase_count = $('#purchase_count' + 4).val();
                                                var total = purchase_count * response['data'];
                                                $('#purchase_total' + 4).val(total);

                                                var sum = 0;
                                                $(".purchase_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".purchasegrandtotal").val(sum.toFixed(2));
                                                $('.purchasegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".purchaseoldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.purchaseoverallamount').val(grand_total.toFixed(2));
                                                $('.purchase_overallamount').text(grand_total.toFixed(2));

                                                var purchasepaid_amount = $('.purchasepaid_amount').val();
                                                var balance = Number(grand_total) - Number(purchasepaid_amount);
                                                $('.purchasebalanceamount').val(balance.toFixed(2));
                                                $('.purchasebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }


                if(k == '5'){
                    $('#purchasecurrency_id' + k).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#purchasecurrency_optimal_id' + 5).empty();


                                    var $select = $('#purchasecurrency_optimal_id' + 5).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#purchasecurrency_optimal_id' + 5).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#purchasecurrency_optimal_id' + 5).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#purchasecurrency_optimal_id' + 5).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#purchasecurrencyoptimal_amount' + 5).val('');
                                                console.log(response['data']);
                                                $('#purchasecurrencyoptimal_amount' + 5).val(response['data']);
                                                var purchase_count = $('#purchase_count' + 5).val();
                                                var total = purchase_count * response['data'];
                                                $('#purchase_total' + 5).val(total);

                                                var sum = 0;
                                                $(".purchase_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".purchasegrandtotal").val(sum.toFixed(2));
                                                $('.purchasegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".purchaseoldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.purchaseoverallamount').val(grand_total.toFixed(2));
                                                $('.purchase_overallamount').text(grand_total.toFixed(2));

                                                var purchasepaid_amount = $('.purchasepaid_amount').val();
                                                var balance = Number(grand_total) - Number(purchasepaid_amount);
                                                $('.purchasebalanceamount').val(balance.toFixed(2));
                                                $('.purchasebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }


                if(k == '6'){
                    $('#purchasecurrency_id' + k).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#purchasecurrency_optimal_id' + 6).empty();


                                    var $select = $('#purchasecurrency_optimal_id' + 6).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#purchasecurrency_optimal_id' + 6).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#purchasecurrency_optimal_id' + 6).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#purchasecurrency_optimal_id' + 6).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#purchasecurrencyoptimal_amount' + 6).val('');
                                                console.log(response['data']);
                                                $('#purchasecurrencyoptimal_amount' + 6).val(response['data']);
                                                var purchase_count = $('#purchase_count' + 6).val();
                                                var total = purchase_count * response['data'];
                                                $('#purchase_total' + 6).val(total);

                                                var sum = 0;
                                                $(".purchase_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".purchasegrandtotal").val(sum.toFixed(2));
                                                $('.purchasegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".purchaseoldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.purchaseoverallamount').val(grand_total.toFixed(2));
                                                $('.purchase_overallamount').text(grand_total.toFixed(2));

                                                var purchasepaid_amount = $('.purchasepaid_amount').val();
                                                var balance = Number(grand_total) - Number(purchasepaid_amount);
                                                $('.purchasebalanceamount').val(balance.toFixed(2));
                                                $('.purchasebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }


                if(k == '7'){
                    $('#purchasecurrency_id' + k).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#purchasecurrency_optimal_id' + 7).empty();


                                    var $select = $('#purchasecurrency_optimal_id' + 7).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#purchasecurrency_optimal_id' + 7).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#purchasecurrency_optimal_id' + 7).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#purchasecurrency_optimal_id' + 7).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#purchasecurrencyoptimal_amount' + 7).val('');
                                                console.log(response['data']);
                                                $('#purchasecurrencyoptimal_amount' + 7).val(response['data']);
                                                var purchase_count = $('#purchase_count' + 7).val();
                                                var total = purchase_count * response['data'];
                                                $('#purchase_total' + 7).val(total);

                                                var sum = 0;
                                                $(".purchase_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".purchasegrandtotal").val(sum.toFixed(2));
                                                $('.purchasegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".purchaseoldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.purchaseoverallamount').val(grand_total.toFixed(2));
                                                $('.purchase_overallamount').text(grand_total.toFixed(2));

                                                var purchasepaid_amount = $('.purchasepaid_amount').val();
                                                var balance = Number(grand_total) - Number(purchasepaid_amount);
                                                $('.purchasebalanceamount').val(balance.toFixed(2));
                                                $('.purchasebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }


                if(k == '8'){
                    $('#purchasecurrency_id' + k).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#purchasecurrency_optimal_id' + 8).empty();


                                    var $select = $('#purchasecurrency_optimal_id' + 8).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#purchasecurrency_optimal_id' + 8).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#purchasecurrency_optimal_id' + 8).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#purchasecurrency_optimal_id' + 8).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#purchasecurrencyoptimal_amount' + 8).val('');
                                                console.log(response['data']);
                                                $('#purchasecurrencyoptimal_amount' + 8).val(response['data']);
                                                var purchase_count = $('#purchase_count' + 8).val();
                                                var total = purchase_count * response['data'];
                                                $('#purchase_total' + 8).val(total);

                                                var sum = 0;
                                                $(".purchase_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".purchasegrandtotal").val(sum.toFixed(2));
                                                $('.purchasegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".purchaseoldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.purchaseoverallamount').val(grand_total.toFixed(2));
                                                $('.purchase_overallamount').text(grand_total.toFixed(2));

                                                var purchasepaid_amount = $('.purchasepaid_amount').val();
                                                var balance = Number(grand_total) - Number(purchasepaid_amount);
                                                $('.purchasebalanceamount').val(balance.toFixed(2));
                                                $('.purchasebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }


                if(k == '9'){
                    $('#purchasecurrency_id' + k).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#purchasecurrency_optimal_id' + 9).empty();


                                    var $select = $('#purchasecurrency_optimal_id' + 9).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#purchasecurrency_optimal_id' + 9).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#purchasecurrency_optimal_id' + 9).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#purchasecurrency_optimal_id' + 9).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#purchasecurrencyoptimal_amount' + 9).val('');
                                                console.log(response['data']);
                                                $('#purchasecurrencyoptimal_amount' + 9).val(response['data']);
                                                var purchase_count = $('#purchase_count' + 9).val();
                                                var total = purchase_count * response['data'];
                                                $('#purchase_total' + 9).val(total);

                                                var sum = 0;
                                                $(".purchase_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".purchasegrandtotal").val(sum.toFixed(2));
                                                $('.purchasegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".purchaseoldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.purchaseoverallamount').val(grand_total.toFixed(2));
                                                $('.purchase_overallamount').text(grand_total.toFixed(2));

                                                var purchasepaid_amount = $('.purchasepaid_amount').val();
                                                var balance = Number(grand_total) - Number(purchasepaid_amount);
                                                $('.purchasebalanceamount').val(balance.toFixed(2));
                                                $('.purchasebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }

                    
                if(k == '10'){
                    $('#purchasecurrency_id' + k).on('change', function() {
                        var currency_id = this.value;

                        $.ajax({
                            url: '/getcurrencyamount/' + currency_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response['data']);

                                var output = response['data'].length;
                                    $('#purchasecurrency_optimal_id' + 10).empty();


                                    var $select = $('#purchasecurrency_optimal_id' + 10).append(
                                        $('<option>', {
                                            value: '0',
                                            text: 'Select'
                                        }));
                                    $('#purchasecurrency_optimal_id' + 10).append($select);

                                    for (var i = 0; i < output; i++) {
                                        $('#purchasecurrency_optimal_id' + 10).append($('<option>', {
                                            value: response['data'][i].id,
                                            text: response['data'][i].name
                                        }));

                                        $('#purchasecurrency_optimal_id' + 10).on('change', function() {
                                            var currency_optimal_id = this.value;

                                            $.ajax({
                                            url: '/getcurrencyoptimalamount/' + currency_optimal_id,
                                            type: 'get',
                                            dataType: 'json',
                                            success: function(response) {
                                                $('#purchasecurrencyoptimal_amount' + 10).val('');
                                                console.log(response['data']);
                                                $('#purchasecurrencyoptimal_amount' + 10).val(response['data']);
                                                var purchase_count = $('#purchase_count' + 10).val();
                                                var total = purchase_count * response['data'];
                                                $('#purchase_total' + 10).val(total);

                                                var sum = 0;
                                                $(".purchase_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".purchasegrandtotal").val(sum.toFixed(2));
                                                $('.purchasegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".purchaseoldbalanceamount").val();
                                                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                                                $('.purchaseoverallamount').val(grand_total.toFixed(2));
                                                $('.purchase_overallamount').text(grand_total.toFixed(2));

                                                var purchasepaid_amount = $('.purchasepaid_amount').val();
                                                var balance = Number(grand_total) - Number(purchasepaid_amount);
                                                $('.purchasebalanceamount').val(balance.toFixed(2));
                                                $('.purchasebalance_amount').text('₹ ' + balance.toFixed(2));
                                                }
                                            });
                                        });
                                    }

                            }
                        });
                    });
                }

            });


           

});

$(document).on('click', '.remove-tr', function() {
    $(this).parents('tr').remove();
    regenerate_auto_num();

                var sum = 0;
                $(".sale_total").each(function(){
                    sum += +$(this).val();
                });
                $(".grand_total").val(sum.toFixed(2));
                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                $('.balance_amount').val(sum.toFixed(2));
                $('.salebalance_amount').text('₹ ' + sum.toFixed(2));

                var oldbalanceamount = $(".oldbalanceamount").val();
                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                $('.overallamount').val(grand_total.toFixed(2));
                $('.sale_overallamount').text(grand_total.toFixed(2));

                var salepaid_amount = $('.salepaid_amount').val();
                var balance = Number(grand_total) - Number(salepaid_amount);
                $('.balance_amount').val(balance.toFixed(2));
                $('.salebalance_amount').text('₹ ' + balance.toFixed(2));
});



$(document).on("keyup", "input[name*=sale_count]", function() {
    var sale_count = $(this).val();
    var currencyoptimal_amount = $(this).parents('tr').find('.currencyoptimal_amount').val();
    var total = sale_count * currencyoptimal_amount;
    $(this).parents('tr').find('.sale_total').val(total);
    //alert(total);


    var sum = 0;
                $(".sale_total").each(function(){
                    sum += +$(this).val();
                });
                $(".grand_total").val(sum.toFixed(2));
                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                $('.balance_amount').val(sum.toFixed(2));
                $('.salebalance_amount').text('₹ ' + sum.toFixed(2));

                var oldbalanceamount = $(".oldbalanceamount").val();
                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                $('.overallamount').val(grand_total.toFixed(2));
                $('.sale_overallamount').text(grand_total.toFixed(2));

                var salepaid_amount = $('.salepaid_amount').val();
                var balance = Number(grand_total) - Number(salepaid_amount);
                $('.balance_amount').val(balance.toFixed(2));
                $('.salebalance_amount').text('₹ ' + balance.toFixed(2));
});





$(document).on("keyup", 'input.salepaid_amount', function() {
        var salepaid_amount = $(this).val();
        var grand_total = $(".overallamount").val();
        //alert(bill_paid_amount);
        var salebalance = Number(grand_total) - Number(salepaid_amount);
        $('.balance_amount').val(salebalance.toFixed(2));
        $('.salebalance_amount').text('₹ ' + salebalance.toFixed(2));
    });






function regenerate_auto_num(){
                let count  = 1;
                $(".auto_num").each(function(i,v){
                $(this).val(count);
                count++;
              })
            }




$(document).on('click', '.remove-purchasetr', function() {
    $(this).parents('tr').remove();
    regenerate_auto_purchasenum();

                var sum = 0;
                $(".purchase_total").each(function(){
                    sum += +$(this).val();
                });
                $(".purchasegrandtotal").val(sum.toFixed(2));
                $('.purchasegrand_total').text('₹ ' + sum.toFixed(2));

                $('.purchasebalanceamount').val(sum.toFixed(2));
                $('.purchasebalance_amount').text('₹ ' + sum.toFixed(2));

                var oldbalanceamount = $(".purchaseoldbalanceamount").val();
                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                $('.purchaseoverallamount').val(grand_total.toFixed(2));
                $('.purchase_overallamount').text(grand_total.toFixed(2));

                var purchasepaid_amount = $('.purchasepaid_amount').val();
                var balance = Number(grand_total) - Number(purchasepaid_amount);
                $('.purchasebalanceamount').val(balance.toFixed(2));
                $('.purchasebalance_amount').text('₹ ' + balance.toFixed(2));
});


$(document).on("keyup", "input[name*=purchase_count]", function() {
    var purchase_count = $(this).val();
    var purchasecurrencyoptimal_amount = $(this).parents('tr').find('.purchasecurrencyoptimal_amount').val();
    var total = purchase_count * purchasecurrencyoptimal_amount;
    $(this).parents('tr').find('.purchase_total').val(total);
    //alert(total);


    var sum = 0;
                $(".purchase_total").each(function(){
                    sum += +$(this).val();
                });
                $(".purchasegrandtotal").val(sum.toFixed(2));
                $('.purchasegrand_total').text('₹ ' + sum.toFixed(2));

                $('.purchasebalanceamount').val(sum.toFixed(2));
                $('.purchasebalance_amount').text('₹ ' + sum.toFixed(2));

                var oldbalanceamount = $(".purchaseoldbalanceamount").val();
                var grand_total = Number(oldbalanceamount) + Number(sum.toFixed(2));
                $('.purchaseoverallamount').val(grand_total.toFixed(2));
                $('.purchase_overallamount').text(grand_total.toFixed(2));

                var purchasepaid_amount = $('.purchasepaid_amount').val();
                var balance = Number(grand_total) - Number(purchasepaid_amount);
                $('.purchasebalanceamount').val(balance.toFixed(2));
                $('.purchasebalance_amount').text('₹ ' + balance.toFixed(2));
});


    $(document).on("keyup", 'input.purchasepaid_amount', function() {
        var purchasepaid_amount = $(this).val();
        var grand_total = $(".purchaseoverallamount").val();
        //alert(bill_paid_amount);
        var salebalance = Number(grand_total) - Number(purchasepaid_amount);
        $('.purchasebalanceamount').val(salebalance.toFixed(2));
        $('.purchasebalance_amount').text('₹ ' + salebalance.toFixed(2));
    });

        

            function regenerate_auto_purchasenum(){
                let count  = 1;
                $(".purchaseauto_num").each(function(i,v){
                $(this).val(count);
                count++;
              })
            }



            
</script>