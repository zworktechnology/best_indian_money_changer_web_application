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


            // Sales


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
                                    $('#doller_rate' + 1).val('');
                                    $('#dollertotal' + 1).val('');
                                    $('#sale_count' + 1).val('');
                                    $('#sale_total' + 1).val('');

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

                                        var doller_rate = $('#doller_rate' + 1).val();
                                        var doller_total = doller_rate * response['data'];
                                        $('#dollertotal' + 1).val(doller_total);

                                                var sale_count = $('#sale_count' + 1).val();
                                                var total = sale_count * doller_total;
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
                                        var grand_total = Number(gross_amount) - Number(response['data']);
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
                    '<td><input type="text" class="form-control doller_rate" id="doller_rate' + i + '" name="doller_rate[]" placeholder="Rate" /></td>' +
                    '<td hidden><input type="text" class="form-control dollertotal" id="dollertotal' + i + '" name="dollertotal[]" readonly /></td>' +
                    '<td><input type="text" class="form-control sale_count" id="sale_count' + i + '" name="sale_count[]" placeholder="Count" placeholder="Qty"/></td>' +
                    '<td><input type="text" class="form-control sale_total" readonly id="sale_total' + i + '" name="sale_total[]"  /></td>' +
                    '<td><button class="additemplus_button addsalefields" style="margin-right: 3px;" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>' +
                    '<button class="additemminus_button remove-tr" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button></td>' +
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
                                    $('#currencyoptimal_amount' + 2).val('');
                                    $('#doller_rate' + 2).val('');
                                    $('#dollertotal' + 2).val('');
                                    $('#sale_count' + 2).val('');
                                    $('#sale_total' + 2).val('');


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

                                                var doller_rate = $('#doller_rate' + 2).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#dollertotal' + 2).val(doller_total);


                                                var sale_count = $('#sale_count' + 2).val();
                                                var total = sale_count * doller_total;
                                                $('#sale_total' + 2).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(sum.toFixed(2)) - Number(oldbalanceamount);
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
                                    $('#currencyoptimal_amount' + 3).val('');
                                    $('#doller_rate' + 3).val('');
                                    $('#dollertotal' + 3).val('');
                                    $('#sale_count' + 3).val('');
                                    $('#sale_total' + 3).val('');


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

                                                var doller_rate = $('#doller_rate' + 3).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#dollertotal' + 3).val(doller_total);

                                                var sale_count = $('#sale_count' + 3).val();
                                                var total = sale_count * doller_total;
                                                $('#sale_total' + 3).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(sum.toFixed(2)) - Number(oldbalanceamount);
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
                                    $('#currencyoptimal_amount' + 4).val('');
                                    $('#doller_rate' + 4).val('');
                                    $('#dollertotal' + 4).val('');
                                    $('#sale_count' + 4).val('');
                                    $('#sale_total' + 4).val('');


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

                                                var doller_rate = $('#doller_rate' + 4).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#dollertotal' + 4).val(doller_total);

                                                var sale_count = $('#sale_count' + 4).val();
                                                var total = sale_count * doller_total;
                                                $('#sale_total' + 4).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(sum.toFixed(2)) - Number(oldbalanceamount);
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
                                    $('#currencyoptimal_amount' + 5).val('');
                                    $('#doller_rate' + 5).val('');
                                    $('#dollertotal' + 5).val('');
                                    $('#sale_count' + 5).val('');
                                    $('#sale_total' + 5).val('');


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

                                                var doller_rate = $('#doller_rate' + 5).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#dollertotal' + 5).val(doller_total);

                                                var sale_count = $('#sale_count' + 5).val();
                                                var total = sale_count * doller_total;
                                                $('#sale_total' + 5).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(sum.toFixed(2)) - Number(oldbalanceamount);
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
                                    $('#currencyoptimal_amount' + 6).val('');
                                    $('#doller_rate' + 6).val('');
                                    $('#dollertotal' + 6).val('');
                                    $('#sale_count' + 6).val('');
                                    $('#sale_total' + 6).val('');


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

                                                var doller_rate = $('#doller_rate' + 6).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#dollertotal' + 6).val(doller_total);

                                                var sale_count = $('#sale_count' + 6).val();
                                                var total = sale_count * doller_total;
                                                $('#sale_total' + 6).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(sum.toFixed(2)) - Number(oldbalanceamount);
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
                                    $('#currencyoptimal_amount' + 7).val('');
                                    $('#doller_rate' + 7).val('');
                                    $('#dollertotal' + 7).val('');
                                    $('#sale_count' + 7).val('');
                                    $('#sale_total' + 7).val('');


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

                                                var doller_rate = $('#doller_rate' + 7).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#dollertotal' + 7).val(doller_total);

                                                var sale_count = $('#sale_count' + 7).val();
                                                var total = sale_count * doller_total;
                                                $('#sale_total' + 7).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(sum.toFixed(2)) - Number(oldbalanceamount);
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
                                    $('#currencyoptimal_amount' + 8).val('');
                                    $('#doller_rate' + 8).val('');
                                    $('#dollertotal' + 8).val('');
                                    $('#sale_count' + 8).val('');
                                    $('#sale_total' + 8).val('');


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

                                                var doller_rate = $('#doller_rate' + 8).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#dollertotal' + 8).val(doller_total);

                                                var sale_count = $('#sale_count' + 8).val();
                                                var total = sale_count * doller_total;
                                                $('#sale_total' + 8).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(sum.toFixed(2)) - Number(oldbalanceamount);
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
                                    $('#currencyoptimal_amount' + 9).val('');
                                    $('#doller_rate' + 9).val('');
                                    $('#dollertotal' + 9).val('');
                                    $('#sale_count' + 9).val('');
                                    $('#sale_total' + 9).val('');


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

                                                var doller_rate = $('#doller_rate' + 9).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#dollertotal' + 9).val(doller_total);

                                                var sale_count = $('#sale_count' + 9).val();
                                                var total = sale_count * doller_total;
                                                $('#sale_total' + 9).val(total);


                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(sum.toFixed(2)) - Number(oldbalanceamount);
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
                                    $('#currencyoptimal_amount' + 10).val('');
                                    $('#doller_rate' + 10).val('');
                                    $('#dollertotal' + 10).val('');
                                    $('#sale_count' + 10).val('');
                                    $('#sale_total' + 10).val('');


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

                                                var doller_rate = $('#doller_rate' + 10).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#dollertotal' + 10).val(doller_total);


                                                var sale_count = $('#sale_count' + 10).val();
                                                var total = sale_count * doller_total;
                                                $('#sale_total' + 10).val(total);

                                                var sum = 0;
                                                $(".sale_total").each(function(){
                                                    sum += +$(this).val();
                                                });
                                                $(".grand_total").val(sum.toFixed(2));
                                                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                                                var oldbalanceamount = $(".oldbalanceamount").val();
                                                var grand_total = Number(sum.toFixed(2)) - Number(oldbalanceamount);
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


            // Purchase



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
                                    $('#purchasedoller_rate' + 1).val('');
                                    $('#purchasedollertotal' + 1).val('');
                                    $('#purchase_count' + 1).val('');
                                    $('#purchase_total' + 1).val('');

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

                                                var doller_rate = $('#purchasedoller_rate' + 1).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#purchasedollertotal' + 1).val(doller_total);


                                                var purchase_count = $('#purchase_count' + 1).val();
                                                var total = purchase_count * doller_total;
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
                var salecustomer_id = $(this).val();
                if(salecustomer_id){
                        $('.purchaseold_balance').text('');
                        $('.purchaseoldbalanceamount').val('');
                        $.ajax({
                        url: '/getoldbalance/',
                        type: 'get',
                        data: {_token: "{{ csrf_token() }}",
                        salecustomer_id: salecustomer_id,
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
                    '<td><input type="text" class="form-control purchasedoller_rate" id="purchasedoller_rate' + k + '" name="purchasedoller_rate[]" placeholder="Rate" /></td>' +
                    '<td hidden><input type="text" class="form-control purchasedollertotal" id="purchasedollertotal' + k + '" name="purchasedollertotal[]" readonly /></td>' +
                    '<td><input type="text" class="form-control purchase_count" id="purchase_count' + k + '" name="purchase_count[]" placeholder="Qty" /></td>' +
                    '<td><input type="text" class="form-control purchase_total" readonly id="purchase_total' + k + '" name="purchase_total[]" placeholder="Total" /></td>' +
                    '<td><button class="additemplus_button addpurchasefields" style="margin-right: 3px;" type="button" id="" value="Add"><i class="fe fe-plus-circle"></i></button>' +
                    '<button class="additemminus_button remove-purchasetr" type="button" id="" value="Add"><i class="fe fe-minus-circle"></i></button></td>' +
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
                                    $('#purchasecurrencyoptimal_amount' + 2).val('');
                                    $('#purchasedoller_rate' + 2).val('');
                                    $('#purchasedollertotal' + 2).val('');
                                    $('#purchase_count' + 2).val('');
                                    $('#purchase_total' + 2).val('');


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

                                                var doller_rate = $('#purchasedoller_rate' + 2).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#purchasedollertotal' + 2).val(doller_total);


                                                var purchase_count = $('#purchase_count' + 2).val();
                                                var total = purchase_count * doller_total;
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
                                    $('#purchasecurrencyoptimal_amount' + 3).val('');
                                    $('#purchasedoller_rate' + 3).val('');
                                    $('#purchasedollertotal' + 3).val('');
                                    $('#purchase_count' + 3).val('');
                                    $('#purchase_total' + 3).val('');


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


                                                var doller_rate = $('#purchasedoller_rate' + 3).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#purchasedollertotal' + 3).val(doller_total);


                                                var purchase_count = $('#purchase_count' + 3).val();
                                                var total = purchase_count * doller_total;
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
                                    $('#purchasecurrencyoptimal_amount' + 4).val('');
                                    $('#purchasedoller_rate' + 4).val('');
                                    $('#purchasedollertotal' + 4).val('');
                                    $('#purchase_count' + 4).val('');
                                    $('#purchase_total' + 4).val('');


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


                                               var doller_rate = $('#purchasedoller_rate' + 4).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#purchasedollertotal' + 4).val(doller_total);


                                                var purchase_count = $('#purchase_count' + 4).val();
                                                var total = purchase_count * doller_total;
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
                                    $('#purchasecurrencyoptimal_amount' + 5).val('');
                                    $('#purchasedoller_rate' + 5).val('');
                                    $('#purchasedollertotal' + 5).val('');
                                    $('#purchase_count' + 5).val('');
                                    $('#purchase_total' + 5).val('');


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


                                                var doller_rate = $('#purchasedoller_rate' + 5).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#purchasedollertotal' + 5).val(doller_total);


                                                var purchase_count = $('#purchase_count' + 5).val();
                                                var total = purchase_count * doller_total;
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
                                    $('#purchasecurrencyoptimal_amount' + 6).val('');
                                    $('#purchasedoller_rate' + 6).val('');
                                    $('#purchasedollertotal' + 6).val('');
                                    $('#purchase_count' + 6).val('');
                                    $('#purchase_total' + 6).val('');


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


                                                var doller_rate = $('#purchasedoller_rate' + 6).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#purchasedollertotal' + 6).val(doller_total);


                                                var purchase_count = $('#purchase_count' + 6).val();
                                                var total = purchase_count * doller_total;
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
                                    $('#purchasecurrencyoptimal_amount' + 7).val('');
                                    $('#purchasedoller_rate' + 7).val('');
                                    $('#purchasedollertotal' + 7).val('');
                                    $('#purchase_count' + 7).val('');
                                    $('#purchase_total' + 7).val('');


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


                                                 var doller_rate = $('#purchasedoller_rate' + 7).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#purchasedollertotal' + 7).val(doller_total);


                                                var purchase_count = $('#purchase_count' + 7).val();
                                                var total = purchase_count * doller_total;
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
                                    $('#purchasecurrencyoptimal_amount' + 8).val('');
                                    $('#purchasedoller_rate' + 8).val('');
                                    $('#purchasedollertotal' + 8).val('');
                                    $('#purchase_count' + 8).val('');
                                    $('#purchase_total' + 8).val('');


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


                                                 var doller_rate = $('#purchasedoller_rate' + 8).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#purchasedollertotal' + 8).val(doller_total);


                                                var purchase_count = $('#purchase_count' + 8).val();
                                                var total = purchase_count * doller_total;
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
                                    $('#purchasecurrencyoptimal_amount' + 9).val('');
                                    $('#purchasedoller_rate' + 9).val('');
                                    $('#purchasedollertotal' + 9).val('');
                                    $('#purchase_count' + 9).val('');
                                    $('#purchase_total' + 9).val('');


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

                                                 var doller_rate = $('#purchasedoller_rate' + 9).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#purchasedollertotal' + 9).val(doller_total);


                                                var purchase_count = $('#purchase_count' + 9).val();
                                                var total = purchase_count * doller_total;
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
                                    $('#purchasecurrencyoptimal_amount' + 10).val('');
                                    $('#purchasedoller_rate' + 10).val('');
                                    $('#purchasedollertotal' + 10).val('');
                                    $('#purchase_count' + 10).val('');
                                    $('#purchase_total' + 10).val('');


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


                                                var doller_rate = $('#purchasedoller_rate' + 10).val();
                                                var doller_total = doller_rate * response['data'];
                                                $('#purchasedollertotal' + 10).val(doller_total);


                                                var purchase_count = $('#purchase_count' + 10).val();
                                                var total = purchase_count * doller_total;
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


// Sales


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
                var grand_total = Number(sum.toFixed(2)) - Number(oldbalanceamount);
                $('.overallamount').val(grand_total.toFixed(2));
                $('.sale_overallamount').text(grand_total.toFixed(2));

                var salepaid_amount = $('.salepaid_amount').val();
                var balance = Number(grand_total) - Number(salepaid_amount);
                $('.balance_amount').val(balance.toFixed(2));
                $('.salebalance_amount').text('₹ ' + balance.toFixed(2));
});


$(document).on("keyup", "input[name*=doller_rate]", function() {
    var doller_rate = $(this).val();
    var currencyoptimal_amount = $(this).parents('tr').find('.currencyoptimal_amount').val();
    var dollertotal = doller_rate * currencyoptimal_amount;
    $(this).parents('tr').find('.dollertotal').val(dollertotal);

    var sale_count = $(this).parents('tr').find('.sale_count').val();
    var total = sale_count * dollertotal;
    $(this).parents('tr').find('.sale_total').val(total);

    var sum = 0;
                $(".sale_total").each(function(){
                    sum += +$(this).val();
                });
                $(".grand_total").val(sum.toFixed(2));
                $('.salegrand_total').text('₹ ' + sum.toFixed(2));

                $('.balance_amount').val(sum.toFixed(2));
                $('.salebalance_amount').text('₹ ' + sum.toFixed(2));

                var oldbalanceamount = $(".oldbalanceamount").val();
                var grand_total = Number(sum.toFixed(2)) - Number(oldbalanceamount);
                $('.overallamount').val(grand_total.toFixed(2));
                $('.sale_overallamount').text(grand_total.toFixed(2));

                var salepaid_amount = $('.salepaid_amount').val();
                var balance = Number(grand_total) - Number(salepaid_amount);
                $('.balance_amount').val(balance.toFixed(2));
                $('.salebalance_amount').text('₹ ' + balance.toFixed(2));
});


$(document).on("keyup", "input[name*=sale_count]", function() {
    var sale_count = $(this).val();
    var dollertotal = $(this).parents('tr').find('.dollertotal').val();
    var total = sale_count * dollertotal;
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
                var grand_total = Number(sum.toFixed(2)) - Number(oldbalanceamount);
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



    $(document).on("keyup", 'input.salepaid_amount', function() {
            var salepaid_amount = $(this).val();
            var overallamount = $(".overallamount").val();

            if (Number(salepaid_amount) > Number(overallamount)) {
                alert('You are entering Maximum Amount of Total');
                $('.salepaid_amount').val('');
                $('.balance_amount').val('');
                $('.salebalance_amount').text('');
            }
        });


function regenerate_auto_num(){
                let count  = 1;
                $(".auto_num").each(function(i,v){
                $(this).val(count);
                count++;
              })
            }




// Purchase

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


$(document).on("keyup", "input[name*=purchasedoller_rate]", function() {
    var purchasedoller_rate = $(this).val();
    var purchasecurrencyoptimal_amount = $(this).parents('tr').find('.purchasecurrencyoptimal_amount').val();
    var purchasedollertotal = purchasedoller_rate * purchasecurrencyoptimal_amount;
    $(this).parents('tr').find('.purchasedollertotal').val(purchasedollertotal);

    var purchase_count = $(this).parents('tr').find('.purchase_count').val();
    var total = purchase_count * purchasedollertotal;
    $(this).parents('tr').find('.purchase_total').val(total);

    var sum = 0;
                $(".purchase_total").each(function(){
                    sum += +$(this).val();
                });
                $(".purchasegrandtotal").val(sum.toFixed(2));
                $('.purchasegrand_total').text('₹ ' + sum.toFixed(2));

                $('.purchasebalanceamount').val(sum.toFixed(2));
                $('.purchasebalance_amount').text('₹ ' + sum.toFixed(2));

                var purchaseoldbalanceamount = $(".purchaseoldbalanceamount").val();
                var grand_total = Number(purchaseoldbalanceamount) + Number(sum.toFixed(2));
                $('.purchaseoverallamount').val(grand_total.toFixed(2));
                $('.purchase_overallamount').text(grand_total.toFixed(2));

                var purchasepaid_amount = $('.purchasepaid_amount').val();
                var balance = Number(grand_total) - Number(purchasepaid_amount);
                $('.purchasebalanceamount').val(balance.toFixed(2));
                $('.purchasebalance_amount').text('₹ ' + balance.toFixed(2));
});


$(document).on("keyup", "input[name*=purchase_count]", function() {
    var purchase_count = $(this).val();
    var purchasedollertotal = $(this).parents('tr').find('.purchasedollertotal').val();
    var total = purchase_count * purchasedollertotal;
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


    $(document).on("keyup", 'input.purchasepaid_amount', function() {
            var purchasepaid_amount = $(this).val();
            var purchaseoverallamount = $(".purchaseoverallamount").val();

            if (Number(purchasepaid_amount) > Number(purchaseoverallamount)) {
                alert('You are entering Maximum Amount of Total');
                $('.purchasepaid_amount').val('');
                $('.purchasebalanceamount').val('');
                $('.purchasebalance_amount').text('');
            }
        });

            function regenerate_auto_purchasenum(){
                let count  = 1;
                $(".purchaseauto_num").each(function(i,v){
                $(this).val(count);
                count++;
              })
            }




</script>
