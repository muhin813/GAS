@extends('layouts.customer_master')
@section('title', 'Edit Booking')
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
                        <a href="{{url('bookings')}}">Bookings</a>
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
                    <form  id="booking_form" method="post" action="" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$booking->id}}">
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
                                                    <label for=""><b>Booking Reference Number</b></label>
                                                    <input type="text" class="form-control" name="booking_number" id="booking_number" value="{{$booking->booking_number}}" disabled >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Service Category</b></label>
                                                    <input type="text" class="form-control" name="service_category_id" id="service_category_id" value="{{$booking->service_category}}" disabled >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Service Type</b></label>
                                                    <input type="text" class="form-control" name="service_type_id" id="service_type_id" value="{{$booking->service_type}}" disabled >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Customer Name</b></label>
                                                    <input type="text" class="form-control" name="customer_name" id="vecustomer_namehicle_name" value="{{$booking->first_name." ".$booking->last_name}}" disabled >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Phone</b></label>
                                                    <input type="text" class="form-control" name="customer_phone" id="customer_phone" value="{{$booking->phone}}" disabled >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Vehicle Name</b></label>
                                                    <input type="text" class="form-control" name="vehicle_name" id="vehicle_name" value="{{$booking->vehicle_name}}" disabled >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Vehicle Model</b></label>
                                                    <input type="text" class="form-control" name="vehicle_model" id="vehicle_model" value="{{$booking->vehicle_model}}" disabled >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Special Note</b></label>
                                                    <input type="text" class="form-control" name="special_note" id="special_note" value="{{$booking->special_note}}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="checkbox" class="" name="emergency" id="emergency" value="Yes" @if($booking->emergency=='Yes') checked @endif disabled>
                                                    <label for="emergency"><b>Emergency</b></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Confirmation Date</b></label>
                                                    <input type="text" class="form-control datepicker" name="confirmation_date" id="confirmation_date" value="@if($booking->confirmation_date != ''){{date('d/m/Y', strtotime($booking->confirmation_date))}} @endif">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Confirmation Time</b></label>
                                                    <input type="text" class="form-control timepicker" name="confirmation_time" id="confirmation_time" value="@if($booking->confirmation_time != ''){{date('h:i:s a', strtotime($booking->confirmation_time))}} @endif">
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
            $('.timepicker').timepicker();
        });

        $(document).on("submit", "#booking_form", function(event) {
            event.preventDefault();
            show_loader();

            var confirmation_date = $("#confirmation_date").val();
            var confirmation_time = $("#confirmation_time").val();

            var validate = "";

            if (confirmation_date.trim() == "") {
                validate = validate + "Confirmation date is required</br>";
            }
            if (confirmation_time.trim() == "") {
                validate = validate + "Confirmation time is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#booking_form")[0]);
                var url = "{{ url('bookings/update') }}";

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

