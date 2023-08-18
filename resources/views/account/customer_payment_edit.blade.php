@extends('layouts.master')
@section('title', 'Edit Customer Payment')
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
                        <a href="{{url('customer_payments')}}">Customer Payment</a>
                        <i class=""></i>
                    </li>
                    <li>
                        <span>Edit</span>
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
                    <form  id="customer_payment_form" method="post" action="" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$customer_payment->id}}">
                        <div class="alert alert-success" id="success_message" style="display:none"></div>
                        <div class="alert alert-danger" id="error_message" style="display: none"></div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Invoice Number</b></label>
                                    <select name="sales_id" id="sales_id" class="form-control">
                                        <option value="">Select Invoice Number</option>
                                        @foreach($sales as $sale)
                                            <option value="{{$sale->id}}" @if($customer_payment->sales_id==$sale->id) selected @endif>{{$sale->invoice_number}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Total Amount</b></label>
                                    <input type="text" class="form-control" name="total_amount" id="total_amount" value="{{$customer_payment->total_value}}" readonly >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Received Amount</b></label>
                                    <input type="text" class="form-control price" name="received_amount" id="received_amount" value="{{$customer_payment->received_amount}}">
                                </div>
                            </div>
<!--                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Due Amount</b></label>
                                    <input type="text" class="form-control" name="due_amount" id="due_amount" value="{{$customer_payment->due_amount}}" readonly >
                                </div>
                            </div>-->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Payment Date</b></label>
                                    <input type="text" class="form-control datepicker" name="payment_date" id="payment_date" value="{{date('m/d/Y', strtotime($customer_payment->payment_date))}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn green submit-btn" id="profile_button">Save</button>
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

        $(document).on('change', '#sales_id', function(){
            var sales_id = $(this).val();
            var url = "{{ url('sales/get_details') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {sales_id:sales_id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var received_amount = $('#received_amount').val();
                        var due_amount = data.sale.total_value-received_amount;
                        $('#total_amount').val(data.sale.total_value);
                        $('#due_amount').val(due_amount.toFixed(2));
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

        $(document).on("submit", "#customer_payment_form", function(event) {
            event.preventDefault();
            show_loader();

            var sales_id = $("#sales_id").val();
            var received_amount = $("#received_amount").val();
            var payment_date = $("#payment_date").val();

            var validate = "";

            if (sales_id.trim() == "") {
                validate = validate + "Invoice number is required</br>";
            }
            if (received_amount.trim() == "") {
                validate = validate + "Received amount is required</br>";
            }
            if (payment_date.trim() == "") {
                validate = validate + "Payment Date is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#customer_payment_form")[0]);
                var url = "{{ url('customer_payments/update') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $("#success_message").show();
                            $("#error_message").hide();
                            $("#success_message").html(data.reason);
                            setTimeout(function(){
                                $("#success_message").hide();
                            },1000)
                        } else {
                            $("#success_message").hide();
                            $("#error_message").show();
                            $("#error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
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
                hide_loader();
                $("#success_message").hide();
                $("#error_message").show();
                $("#error_message").html(validate);
            }
        });
    </script>
@endsection

