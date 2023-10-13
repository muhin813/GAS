@extends('layouts.master')
@section('title', 'Create Job')
@section('content')

// Timepicker documentation  https://github.com/jonthornton/jquery-timepicker#timepicker-plugin-for-jquery

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
                        <a href="{{url('jobs')}}">Jobs</a>
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
                    <form  id="job_form" method="post" action="" enctype="multipart/form-data">
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
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for=""><b>Opening Date</b></label>
                                                            <div>
                                                                <input type="text" class="form-control datepicker" name="opening_date" id="opening_date" value="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for=""><b>Opening Time</b></label>
                                                            <div>
                                                                <input type="text" class="form-control timepicker" name="opening_time" id="opening_time" value="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Job Category</b></label>
                                                    <select name="job_category" id="job_category" class="form-control">
                                                        <option value="">Select Category</option>
                                                        @foreach($service_categories as $s_category)
                                                        <option value="{{$s_category->id}}">{{$s_category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Job Type</b></label>
                                                    <select name="job_type" id="job_type" class="form-control">
                                                        <option value="">Select Type</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Customer</b></label>
                                                    <select name="customer_id" id="customer_id" class="form-control">
                                                        <option value="">Select Customer</option>
                                                        @foreach($customers as $customer)
                                                            <option value="{{$customer->id}}">{{$customer->first_name." ".$customer->last_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Customer Vehicle</b></label>
                                                    <select name="customer_vehicle_credential_id" id="customer_vehicle_credential_id" class="form-control">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Job Assigned Person</b></label>
                                                    <select name="job_assigned_person_id" id="job_assigned_person_id" class="form-control">
                                                        <option value="">Select Person</option>
                                                        @foreach($mechanics as $mechanic)
                                                            <option value="{{$mechanic->id}}">{{$mechanic->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
<!--                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Job Closing Date Time</b></label>
                                                    <input type="text" class="form-control datepicker" name="job_closing_date" id="job_closing_date" value="">
                                                </div>
                                            </div>-->
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
            // $(document).on('change', '.timepicker', function(){
            //   alert( $('.timepicker').val());
            // });
        });

        $(document).on('change', '#job_category', function(){
            var job_category_id = $(this).val();
            var url = "{{ url('get_service_type_by_category') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {service_category_id:job_category_id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var service_types = data.service_types;
                        var options = '<option value="">Select Type</option>';
                        $.each(service_types , function(index, type) {
                            options +='<option value="'+type.id+'">'+type.name+'</option>';
                        });
                        $('#job_type').html(options);

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

        $(document).on('change', '#customer_id', function(){
            var customer_id = $(this).val();
            var url = "{{ url('customers/get_vehicles') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {customer_id:customer_id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var vehicles = data.vehicles;
                        var options = '';
                        $.each(vehicles , function(index, vehicle) {
                            options +='<option value="'+vehicle.id+'">'+vehicle.name+' '+vehicle.model+' '+vehicle.registration_number+'</option>';
                        });
                        $('#customer_vehicle_credential_id').html(options);

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

        $(document).on("submit", "#job_form", function(event) {
            event.preventDefault();
            show_loader();

            var opening_date = $("#opening_date").val();
            var opening_time = $("#opening_time").val();
            var job_category = $("#job_category").val();
            var job_type = $("#job_type").val();
            var customer_id = $("#customer_id").val();
            var job_assigned_person_id = $("#job_assigned_person_id").val();
            //var job_closing_date = $("#job_closing_date").val();

            var validate = "";

            if (opening_date.trim() == "") {
                validate = validate + "Job opening date is required</br>";
            }
            if (opening_time.trim() == "") {
                validate = validate + "Job opening time is required</br>";
            }
            if (job_category.trim() == "") {
                validate = validate + "Job category is required</br>";
            }
            /*if (job_type.trim() == "") {
                validate = validate + "Job type is required</br>";
            }*/
            if (customer_id.trim() == "") {
                validate = validate + "Customer is required</br>";
            }
            if (job_assigned_person_id.trim() == "") {
                validate = validate + "Job assigned persion is required</br>";
            }
            /*if (job_closing_date.trim() == "") {
                validate = validate + "Job closing daten is required</br>";
            }*/

            if (validate == "") {
                var formData = new FormData($("#job_form")[0]);
                var url = "{{ url('jobs/store') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#job_form')[0].reset();

                            $("#success_message").show();
                            $("#error_message").hide();
                            $("#success_message").html(data.reason);
                            setTimeout(function(){
                                window.location.href="{{url('jobs')}}";
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

