@extends('layouts.master')
@section('title', 'Edit Other Payment')
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
                        <a href="{{url('other_payments')}}">Other Payment</a>
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
                    <form  id="other_payment_form" method="post" action="" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$other_payment->id}}">
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
                                                    <label for=""><b>Payment Type</b></label>
                                                    <select name="payment_type" id="payment_type" class="form-control">
                                                        <option value="">Select Payment Type</option>
                                                        <option value="Received" @if($other_payment->payment_type=='Received') selected @endif>Received</option>
                                                        <option value="Paid" @if($other_payment->payment_type=='Paid') selected @endif>Paid</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Purpose of Payment</b></label>
                                                    <input type="text" class="form-control" name="purpose_of_payment" id="purpose_of_payment" value="{{$other_payment->purpose_of_payment}}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Amount</b></label>
                                                    <input type="number" class="form-control" name="amount" id="amount" value="{{$other_payment->amount}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Payment Mode</b></label>
                                                    <input type="text" class="form-control" name="payment_mode" id="payment_mode" value="{{$other_payment->payment_mode}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Voucher Number</b></label>
                                                    <input type="text" class="form-control" name="voucher_number" id="voucher_number" value="{{$other_payment->voucher_number}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Remarks</b></label>
                                                    <input type="text" class="form-control" name="remarks" id="remarks" value="{{$other_payment->remarks}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Payment Date</b></label>
                                                    <input type="text" class="form-control datepicker" name="payment_date" id="payment_date" value="{{date('m/d/Y',strtotime($other_payment->payment_date))}}">
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

        $(document).on("submit", "#other_payment_form", function(event) {
            event.preventDefault();
            show_loader();

            var payment_type = $("#payment_type").val();
            var purpose_of_payment = $("#purpose_of_payment").val();
            var amount = $("#amount").val();
            var payment_date = $("#payment_date").val();

            var validate = "";

            if (payment_type.trim() == "") {
                validate = validate + "Payment type is required</br>";
            }
            if (purpose_of_payment.trim() == "") {
                validate = validate + "Purpose of payment is required</br>";
            }
            if (amount.trim() == "") {
                validate = validate + "Amount is required</br>";
            }
            if (payment_date.trim() == "") {
                validate = validate + "Payment Date is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#other_payment_form")[0]);
                var url = "{{ url('other_payments/update') }}";

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

