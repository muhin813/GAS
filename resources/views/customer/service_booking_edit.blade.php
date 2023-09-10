@extends('layouts.customer_master')
@section('title', 'Edit Service Booking')
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
                        <a href="{{url('service_bookings')}}">Service Bookings</a>
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
                    <form  id="service_booking_form" method="post" action="" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$service_booking->id}}">
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
                                                    <label for=""><b>Service Category</b></label>
                                                    <select name="service_category_id" id="service_category_id" class="form-control">
                                                        <option value="">Select Category</option>
                                                        @foreach($service_categories as $category)
                                                            <option value="{{$category->id}}" @if($category->id==$service_booking->service_category_id) selected @endif>{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Service Type</b></label>
                                                    <select name="service_type_id" id="service_type_id" class="form-control">
                                                        <option value="">Select Type</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for=""><b>Perfered Date</b></label>
                                                            <div>
                                                                <input type="text" class="form-control datepicker" name="opening_time" id="opening_time" value="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for=""><b>Perfered Time</b></label>
                                                            <div>
                                                                <input type="text" class="form-control timepicker" name="opening_time" id="opening_time" value="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Vehicle Credential</b></label>
                                                    <select name="vehicle_credential_id" id="vehicle_credential_id" class="form-control">
                                                        <option value="">Select Vehicle</option>
                                                        @foreach($vehicle_credentials as $vehicle)
                                                            <option value="{{$vehicle->id}}" @if($vehicle->id==$service_booking->vehicle_credential_id) selected @endif>{{$vehicle->name.'-'.$vehicle->model.'-'.$vehicle->registration_number}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Special Note</b></label>
                                                    <input type="text" class="form-control" name="special_note" id="special_note" value="{{$service_booking->special_note}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mt-1">
                                                    <input type="checkbox" class="" name="emergency" id="emergency" value="Yes" @if($service_booking->emergency=='Yes') checked @endif>
                                                    <label for="emergency"><b>Emergency</b></label>
                                                    <br><span id="emergency_message" @if($service_booking->emergency=='No') style="display:none" @endif>Minimum Emergency service is BDT 0000, Actual amount is subject to the based on the nature of emergency</span>
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
            var service_category_id = '{{$service_booking->service_category_id}}';
            var service_type_id = '{{$service_booking->service_type_id}}';
            populate_service_type(service_category_id,service_type_id);

            $('.timepicker').timepicker();
            $(document).on('change', '.timepicker', function(){
               alert( $('.timepicker').val()); 
            });
        });

        $(document).on('change', '#service_category_id', function(){
            var service_category_id = $(this).val();
            populate_service_type(service_category_id);
        });

        function populate_service_type(service_category_id,service_type_id=''){
            var url = "{{ url('get_service_type_by_category') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {service_category_id:service_category_id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var service_types = data.service_types;
                        var options = '<option value="">Select Type</option>';
                        $.each(service_types , function(index, type) {
                            options +='<option value="'+type.id+'">'+type.name+'</option>';
                        });
                        $('#service_type_id').html(options);
                        $('#service_type_id').val(service_type_id);

                    } else {
                        show_error_message('Something went wrong.');
                    }
                },
                error: function(data) {
                    hide_loader();
                    show_error_message(data);
                }
            });
        }

        $(document).on('click', '#emergency', function(){
            if( $(this).is(':checked') ){
                $('#emergency_message').show();
            }
            else{
                $('#emergency_message').hide();
            }
        });

        $(document).on("submit", "#service_booking_form", function(event) {
            event.preventDefault();
            show_loader();

            var service_category_id = $("#service_category_id").val();
            var service_type_id = $("#service_type_id").val();
            var vehicle_credential_id = $("#vehicle_credential_id").val();

            var validate = "";

            if (service_category_id.trim() == "") {
                validate = validate + "Service category is required</br>";
            }
            if (service_type_id.trim() == "") {
                validate = validate + "Service type is required</br>";
            }
            if (vehicle_credential_id.trim() == "") {
                validate = validate + "Vehicle credential is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#service_booking_form")[0]);
                var url = "{{ url('service_bookings/update') }}";

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

