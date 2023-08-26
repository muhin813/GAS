@extends('layouts.master')
@section('title', 'Create Bank Reconciliation')
@section('content')

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{url('/')}}">Home</a>
                        <i class=""></i>
                    </li>
                    <li>
                        <a href="{{url('bank_reconciliations')}}">Bank Reconciliations</a>
                        <i class=""></i>
                    </li>
                    <li>
                        <span>Create</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title"> Projects
                <small>dashboard &amp; statistics</small>
            </h3> -->
            <!-- END PAGE TITLE-->
            <!-- END PAGE BAR -->
            <!-- END PAGE HEADER-->

            <div class="row mt-3">
                <div class="col-md-12">
                    <form  id="bank_reconciliation_form" method="post" action="" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="alert alert-success" id="success_message" style="display:none"></div>
                        <div class="alert alert-danger" id="error_message" style="display: none"></div>

                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN PORTLET -->
                                <div class="portlet light ">
                                    <div class="portlet-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Year</b></label>
                                                    <select name="year" id="year" class="form-control">
                                                        @for($year=2023; $year>=2020; $year--)
                                                            <option value="{{$year}}">{{$year}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Month</b></label>
                                                    <select name="month" id="month" class="form-control">
                                                        <option value="">Select Month</option>
                                                        @foreach($months as $key=>$month)
                                                            <option value="{{($key+1)}}">{{$month}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Bank</b></label>
                                                    <select name="bank_id" id="bank_id" class="form-control">
                                                        <option value="">Select Bank</option>
                                                        @foreach($banks as $bank)
                                                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Account</b></label>
                                                    <select name="account_id" id="account_id" class="form-control">
                                                        <option value="">Select Account</option>
                                                        @foreach($bank_accounts as $bank_account)
                                                            <option value="{{$bank_account->id}}">{{$bank_account->account_number}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Bank Statement Closing Balance</b></label>
                                                    <input type="number" class="form-control" name="bank_statement_closing_balance" id="bank_statement_closing_balance" value="" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Outstanding Cheques</b></label>
                                                    <select name="outstanding_cheques[]" id="outstanding_cheques" class="form-control" multiple>
                                                        <option value="">Select Cheque</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Outstanding Cheque Amount</b></label>
                                                    <input type="number" class="form-control" name="outstanding_cheque_amount" id="outstanding_cheque_amount" value="" readonly >
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <span><h4>Outstanding Deposit Section</h4></span>
                                            </div>
                                            <div class="col-md-12" id="outstanding_deposit_area" style="border: 1px solid;padding: 10px; margin:5px">
                                                <div class="row outstanding_deposit">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for=""><b>Date</b></label>
                                                            <input type="text" class="form-control datepicker outstandingDepositeDate" name="outstanding_deposit[0][date]" id="outstanding_deposit_date" value="" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for=""><b>Nature Of Deposit</b></label>
                                                            <input type="text" class="form-control natureOfDeposite" name="outstanding_deposit[0][nature]" id="nature_of_deposite" value="" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for=""><b>Amount</b></label>
                                                            <input type="number" class="form-control outstandingDepositAmount" name="outstanding_deposit[0][amount]" id="amount" value="" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for=""><b>Narration</b></label>
                                                            <input type="text" class="form-control outstandingDepositeNarration" name="outstanding_deposit[0][narration]" id="narration" value="" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" title="Add outstanding deposit" class="btn btn-primary add_outstanding_deposit_button">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Outstanding Deposit Amount</b></label>
                                                    <input type="number" class="form-control" name="total_outstanding_deposit_amount" id="total_outstanding_deposit_amount" value="" readonly >
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <span><h4>Other Payment Section</h4></span>
                                            </div>
                                            <div class="col-md-12" id="other_payment_area" style="border: 1px solid;padding: 10px; margin:5px">
                                                <div class="row other_payment">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for=""><b>Date</b></label>
                                                            <input type="text" class="form-control datepicker otherPaymentDate" name="other_payment[0][date]" id="other_payment_date" value="" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for=""><b>Nature of Adjustment</b></label>
                                                            <input type="text" class="form-control otherPaymentNatureOfAdjustment" name="other_payment[0][nature_of_adjustment]" id="other_payment_nature_of_adjustment" value="" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for=""><b>Amount</b></label>
                                                            <input type="number" class="form-control otherPaymentAmount" name="other_payment[0][amount]" id="other_payment_amount" value="" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for=""><b>Narration</b></label>
                                                            <input type="text" class="form-control otherPaymentNarration" name="other_payment[0][narration]" id="other_payment_narration" value="" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" title="Add other payment" class="btn btn-primary add_other_payment_button">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Other Payment Amount</b></label>
                                                    <input type="number" class="form-control" name="total_other_payment_amount" id="total_other_payment_amount" value="" readonly >
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <span><h4>Other Deposit Section</h4></span>
                                            </div>
                                            <div class="col-md-12" id="other_deposit_area" style="border: 1px solid;padding: 10px; margin:5px">
                                                <div class="row other_deposit">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for=""><b>Date</b></label>
                                                            <input type="text" class="form-control datepicker otherDepositDate" name="other_deposit[0][date]" id="other_deposit_date" value="" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for=""><b>Nature of Adjustment</b></label>
                                                            <input type="text" class="form-control otherDepositNatureOfAdjustment" name="other_deposit[0][nature_of_adjustment]" id="other_deposit_nature_of_adjustment" value="" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for=""><b>Amount</b></label>
                                                            <input type="number" class="form-control otherDepositAmount" name="other_deposit[0][amount]" id="other_deposit_amount" value="" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for=""><b>Narration</b></label>
                                                            <input type="text" class="form-control otherDepositNarration" name="other_deposit[0][narration]" id="other_deposit_narration" value="" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" title="Add other deposit" class="btn btn-primary add_other_deposit_button">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Other Deposit Amount</b></label>
                                                    <input type="number" class="form-control" name="total_other_deposit_amount" id="total_other_deposit_amount" value="" readonly >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Closing Balance Bank Book</b></label>
                                                    <input type="number" class="form-control" name="closing_balance_bank_book" id="closing_balance_bank_book" value="" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Variance</b></label>
                                                    <input type="number" class="form-control" name="opening_variance" id="opening_variance" value="" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group text-right">
                                            <button type="submit" class="btn green submit-btn" id="profile_button">Save</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- END PORTLET -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->

@endsection

@section('js')

    <script>
        $(document).ready(function(){

        });

        $(document).on('change', '#month, #year', function(){
            var month = $('#month').val();
            var year = $('#year').val();
            var url = "{{ url('bank_books/get_cheques_by_month') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {month:month,year:year,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var options = '<option value="">Select Cheque</option>';
                        $.each(data.bank_books, function( index, b_book ) {
                            options += '<option value="'+b_book.cheque_number+'#'+b_book.amount+'">'+b_book.cheque_number+'</option>';
                        });
                        $('#outstanding_cheques').html(options);
                    } else {
                        show_error_message('Something went wrong.');
                    }
                },
                error: function(data) {
                    hide_loader();
                    show_error_message(data);
                }
            });
        });

        $(document).on('change', '#outstanding_cheques', function(){
            var total_amount = 0;
            var cheque_value = $('#outstanding_cheques').val();
            $.each(cheque_value, function( index, option ) {
                var value_array = option.split('#');
                total_amount = total_amount+parseFloat(value_array[1]);
            });

            $('#outstanding_cheque_amount').val(total_amount);
        });

        $(document).on('click', '.add_outstanding_deposit_button', function(){
            var index = $('#outstanding_deposit_area').find('.outstanding_deposit').length;

            var html = '';
            html +='<div class="row outstanding_deposit">';
                html +='<div class="col-md-2">';
                html +='<div class="form-group">';
                html +='<label for=""><b>Date</b></label>';
            html +='<input type="text" class="form-control datepicker outstandingDepositeDate" name="outstanding_deposit['+index+'][date]" id="outstanding_deposit_date" value="" autocomplete="off">';
                html +='</div>';
            html +='</div>';
                html +='<div class="col-md-3">';
                    html +='<div class="form-group">';
                        html +='<label for=""><b>Nature Of Deposit</b></label>';
                        html +='<input type="text" class="form-control natureOfDeposite" name="outstanding_deposit['+index+'][nature]" id="nature_of_deposite" value="" >';
                    html +='</div>';
                html +='</div>';
                html +='<div class="col-md-2">';
                    html +='<div class="form-group">';
                        html +='<label for=""><b>Amount</b></label>';
                        html +='<input type="number" class="form-control outstandingDepositAmount" name="outstanding_deposit['+index+'][amount]" id="amount" value="" >';
                    html +='</div>';
                html +='</div>';
                html +='<div class="col-md-3">';
                    html +='<div class="form-group">';
                        html +='<label for=""><b>Narration</b></label>';
                        html +='<input type="text" class="form-control outstandingDepositeNarration" name="outstanding_deposit['+index+'][narration]" id="narration" value="" >';
                    html +='</div>';
                html +='</div>';
                html +='<div class="col-md-2">';
                    html +='<button type="button" title="Remove outstanding deposit" class="btn btn-danger remove_outstanding_deposit_button">Remove</button>';
                html +='</div>';
            html +='</div>';

            $('#outstanding_deposit_area').append(html);
            $(".datepicker" ).datepicker();

        });

        $(document).on('click', '.remove_outstanding_deposit_button', function(){
            var amount = $(this).parents('.outstanding_deposit').find('.outstandingDepositAmount').val();
            var total_amount = $('#total_outstanding_deposit_amount').val();
            $('#total_outstanding_deposit_amount').val(total_amount-amount);
            $(this).parents('.outstanding_deposit').remove();
        });

        $(document).on('click', '.add_other_payment_button', function(){
            var index = $('#other_payment_area').find('.other_payment').length;

            var html = '';
            html +='<div class="row other_payment">';
                html +='<div class="col-md-2">';
                html +='<div class="form-group">';
                html +='<label for=""><b>Date</b></label>';
            html +='<input type="text" class="form-control datepicker otherPaymentDate" name="other_payment['+index+'][date]" id="other_payment_date" value="" autocomplete="off">';
                html +='</div>';
            html +='</div>';
                html +='<div class="col-md-3">';
                    html +='<div class="form-group">';
                        html +='<label for=""><b>Nature of Adjustment</b></label>';
                        html +='<input type="text" class="form-control otherPaymentNatureOfAdjustment" name="other_payment['+index+'][nature_of_adjustment]" id="other_payment_nature_of_adjustment" value="" >';
                    html +='</div>';
                html +='</div>';
                html +='<div class="col-md-2">';
                    html +='<div class="form-group">';
                        html +='<label for=""><b>Amount</b></label>';
                        html +='<input type="number" class="form-control otherPaymentAmount" name="other_payment['+index+'][amount]" id="other_payment_amount" value="" >';
                    html +='</div>';
                html +='</div>';
                html +='<div class="col-md-3">';
                    html +='<div class="form-group">';
                        html +='<label for=""><b>Narration</b></label>';
                        html +='<input type="text" class="form-control otherPaymentNarration" name="other_payment['+index+'][narration]" id="other_payment_narration" value="" >';
                    html +='</div>';
                html +='</div>';
                html +='<div class="col-md-2">';
                    html +='<button type="button" title="Remove other payment" class="btn btn-danger remove_other_payment_button">Remove</button>';
                html +='</div>';
            html +='</div>';

            $('#other_payment_area').append(html);
            $(".datepicker" ).datepicker();

        });

        $(document).on('click', '.remove_other_payment_button', function(){
            var amount = $(this).parents('.other_payment').find('.otherPaymentAmount').val();
            var total_amount = $('#total_other_payment_amount').val();
            $('#total_other_payment_amount').val(total_amount-amount);
            $(this).parents('.other_payment').remove();
        });

        $(document).on('click', '.add_other_deposit_button', function(){
            var index = $('#other_deposit_area').find('.other_deposit').length;
            var html = '';
            html +='<div class="row other_deposit">';
                html +='<div class="col-md-2">';
                html +='<div class="form-group">';
                html +='<label for=""><b>Date</b></label>';
            html +='<input type="text" class="form-control datepicker otherDepositDate" name="other_deposit['+index+'][date]" id="other_deposit_date" value="" autocomplete="off">';
                html +='</div>';
            html +='</div>';
                html +='<div class="col-md-3">';
                    html +='<div class="form-group">';
                        html +='<label for=""><b>Nature of Adjustment</b></label>';
                        html +='<input type="text" class="form-control otherDepositNatureOfAdjustment" name="other_deposit['+index+'][nature_of_adjustment]" id="other_deposit_nature_of_adjustment" value="" >';
                    html +='</div>';
                html +='</div>';
                html +='<div class="col-md-2">';
                    html +='<div class="form-group">';
                        html +='<label for=""><b>Amount</b></label>';
                        html +='<input type="number" class="form-control otherDepositAmount" name="other_deposit['+index+'][amount]" id="other_deposit_amount" value="" >';
                    html +='</div>';
                html +='</div>';
                html +='<div class="col-md-3">';
                    html +='<div class="form-group">';
                        html +='<label for=""><b>Narration</b></label>';
                        html +='<input type="text" class="form-control otherDepositNarration" name="other_deposit['+index+'][narration]" id="other_deposit_narration" value="" >';
                    html +='</div>';
                html +='</div>';
                html +='<div class="col-md-2">';
                    html +='<button type="button" title="Remove other deposit" class="btn btn-danger remove_other_deposit_button">Remove</button>';
                html +='</div>';
            html +='</div>';

            $('#other_deposit_area').append(html);
            $(".datepicker" ).datepicker();

        });

        $(document).on('click', '.remove_other_deposit_button', function(){
            var amount = $(this).parents('.other_deposit').find('.otherDepositAmount').val();
            var total_amount = $('#total_other_deposit_amount').val();
            $('#total_other_deposit_amount').val(total_amount-amount);
            $(this).parents('.other_deposit').remove();
        });

        $(document).on('keyup', '.outstandingDepositAmount', function(){
            var total_amount = 0;
            $(".outstandingDepositAmount").each(function() {
                var amount = $(this).val();
                if(amount != ''){
                    total_amount = total_amount+parseFloat(amount);
                }
            });
            $('#total_outstanding_deposit_amount').val(total_amount);
        });

        $(document).on('keyup', '.otherPaymentAmount', function(){
            var total_amount = 0;
            $(".otherPaymentAmount").each(function() {
                var amount = $(this).val();
                if(amount != ''){
                    total_amount = total_amount+parseFloat(amount);
                }
            });
            $('#total_other_payment_amount').val(total_amount);
        });

        $(document).on('keyup', '.otherDepositAmount', function(){
            var total_amount = 0;
            $(".otherDepositAmount").each(function() {
                var amount = $(this).val();
                if(amount != ''){
                    total_amount = total_amount+parseFloat(amount);
                }
            });
            $('#total_other_deposit_amount').val(total_amount);
        });

        $(document).on("submit", "#bank_reconciliation_form", function(event) {
            event.preventDefault();
            show_loader();

            var month = $("#month").val();
            var bank_id = $("#bank_id").val();
            var account_id = $("#account_id").val();
            var bank_statement_closing_balance = $("#bank_statement_closing_balance").val();
            var outstanding_cheque_amount = $("#outstanding_cheque_amount").val();

            var validate = "";
            var isValid = 1;

            if (month.trim() == "") {
                validate = validate + "Month is required</br>";
            }
            if (bank_id.trim() == "") {
                validate = validate + "Bank is required</br>";
            }
            if (account_id.trim() == "") {
                validate = validate + "Account is required</br>";
            }
            if (bank_statement_closing_balance.trim() == "") {
                validate = validate + "Bank statement closing balance is required</br>";
            }
            if (outstanding_cheque_amount.trim() == "" || outstanding_cheque_amount.trim() == 0) {
                validate = validate + "Outstanding cheque amount is required</br>";
            }

            $(".natureOfDeposite").each(function() {
                var element = $(this);
                if (element.val() == '') {
                    isValid = 0;
                    $(this).css('border','1px solid #ef0530');
                }
                else{
                    $(this).css('border','1px solid #c2cad8');
                }
            });
            $(".outstandingDepositAmount").each(function() {
                var element = $(this);
                if (element.val() == '') {
                    isValid = 0;
                    $(this).css('border','1px solid #ef0530');
                }
                else{
                    $(this).css('border','1px solid #c2cad8');
                }
            });
            $(".otherPaymentNatureOfAdjustment").each(function() {
                var element = $(this);
                if (element.val() == '') {
                    isValid = 0;
                    $(this).css('border','1px solid #ef0530');
                }
                else{
                    $(this).css('border','1px solid #c2cad8');
                }
            });
            $(".otherPaymentAmount").each(function() {
                var element = $(this);
                if (element.val() == '') {
                    isValid = 0;
                    $(this).css('border','1px solid #ef0530');
                }
                else{
                    $(this).css('border','1px solid #c2cad8');
                }
            });
            $(".otherDepositNatureOfAdjustment").each(function() {
                var element = $(this);
                if (element.val() == '') {
                    isValid = 0;
                    $(this).css('border','1px solid #ef0530');
                }
                else{
                    $(this).css('border','1px solid #c2cad8');
                }
            });
            $(".otherDepositAmount").each(function() {
                var element = $(this);
                if (element.val() == '') {
                    isValid = 0;
                    $(this).css('border','1px solid #ef0530');
                }
                else{
                    $(this).css('border','1px solid #c2cad8');
                }
            });

            if(isValid==0){
                validate = validate+"Fill out all mandatory fields in deposit and payment sections</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#bank_reconciliation_form")[0]);
                var url = "{{ url('bank_reconciliations/store') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        $("html, body").animate({ scrollTop: 0 }, 1000);
                        hide_loader();
                        if (data.status == 200) {
                            $('#bank_reconciliation_form')[0].reset();

                            $("#success_message").show();
                            $("#error_message").hide();
                            $("#success_message").html(data.reason);
                            setTimeout(function(){
                                window.location.href="{{url('bank_reconciliations')}}";
                            },1000)
                        } else {
                            $("#success_message").hide();
                            $("#error_message").show();
                            $("#error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        $("html, body").animate({ scrollTop: 0 }, 1000);
                        hide_loader();
                        $("#success_message").hide();
                        $("#error_message").show();
                        $("#error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                $("html, body").animate({ scrollTop: 0 }, 1000);
                hide_loader();
                $("#success_message").hide();
                $("#error_message").show();
                $("#error_message").html(validate);
            }
        });
    </script>
@endsection

