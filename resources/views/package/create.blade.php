@extends('layouts.master')
@section('title', 'Create Package')
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
                        <a href="{{url('packages')}}">Packages</a>
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
                    <form  id="package_form" method="post" action="" enctype="multipart/form-data">
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
                                                    <label for=""><b>Package Name</b></label>
                                                    <input type="text" class="form-control" name="name" id="name" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Vehicle Name</b></label>
                                                    <input type="text" class="form-control" name="vehicle_name" id="vehicle_name" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Package Price</b></label>
                                                    <input type="text" class="form-control" name="package_price" id="package_price" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Package Validity</b></label>
                                                    <input type="text" class="form-control datepicker" name="package_validity" id="package_validity" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Conditions</b></label>
                                                    <input type="text" class="form-control" name="conditions" id="conditions" value="">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <span><h4>Package Details Section</h4></span>
                                            </div>

                                            <div class="col-md-12" id="package_details_area">
                                                <div class="row package_details" style="border: 1px solid;padding: 10px; margin:5px">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for=""><b>Package Details</b></label>
                                                            <input type="text" class="form-control PackageDetailsName" name="package_detail_name[]" id="package_detail_name" value="">
                                                            <input type="hidden" class="package_detail_index" name="package_detail_index[]" id="package_detail_index" value="0">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 package_sub_details_area">
                                                        <label for=""><b>Package Sub Details</b></label>
                                                        <div class="row package_sub_details" style="padding: 10px; margin:5px">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control vehicleName" name="package_sub_detail_name[0][]" id="package_sub_detail_name" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for=""></label>
                                                                    <button type="button" title="Add Sub Details" class="btn btn-success add_sub_details_button"><i class="icon-plus"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" title="Add Package Details" class="btn btn-primary add_details_button">Add Package Details</button>
                                            </div>

                                            <div class="col-md-12">
                                                <span><h4>Package Features and Benefits Section</h4></span>
                                            </div>

                                            <div class="col-md-12" id="package_benefits_area">
                                                <label for=""><b>Package Features and Benefits</b></label>
                                                <div class="row package_benefits" style="padding: 10px; margin:5px">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control PackageBenefit" name="package_benefits[]" id="package_benefits" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for=""></label>
                                                            <button type="button" title="Add Package Benefits" class="btn btn-success add_benefits_button"><i class="icon-plus"></i></button>
                                                        </div>
                                                    </div>
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



        $(document).on('click', '.add_details_button', function(){
            var count = $("#package_details_area .package_details").length;

            var html = '';
            html +='<div class="row package_details" style="border: 1px solid;padding: 10px; margin:5px">';
            html +='<div class="col-md-6">';
            html +='<div class="form-group">';
            html +='<label for=""><b>Package Details</b></label>';
            html +='<input type="text" class="form-control PackageDetailsName" name="package_detail_name[]" id="package_detail_name" value="">';
            html +='<input type="hidden" class="package_detail_index" name="package_detail_index[]" id="package_detail_index" value="'+count+'">';
            html +='</div>';
            html +='</div>';
            html +='<div class="col-md-6">';
            html +='<label for=""></label>';
            html +='<button type="button" title="Remove Package Details" class="btn btn-danger remove_details_button"><i class="icon-trash"></i></button>';
            html +='</div>';
            html +='<div class="col-md-12 package_sub_details_area">';
            html +='<div class="row package_sub_details" style="padding: 10px; margin:5px">';
            html +='<div class="col-md-6">';
            html +='<div class="form-group">';
            html +='<input type="text" class="form-control vehicleName" name="package_sub_detail_name['+count+'][]" id="package_sub_detail_name" value="">';
            html +='</div>';
            html +='</div>';
            html +='<div class="col-md-6">';
            html +='<label for=""></label>';
            html +='<button type="button" class="btn btn-success add_sub_details_button"><i class="icon-plus"></i></button>';
            html +='</div>';
            html +='</div>';
            html +='</div>';
            html +='</div>';

            $('#package_details_area').append(html);

        });

        $(document).on('click', '.remove_details_button', function(){
            $(this).parents('.package_details').remove();
        });

        $(document).on('click', '.add_sub_details_button', function(){
            var index = $(this).parents('.package_details').find('.package_detail_index').val();
            var html = '';
            html +='<div class="row package_sub_details" style="padding: 10px; margin:5px">';
            html +='<div class="col-md-6">';
            html +='<div class="form-group">';
            html +='<input type="text" class="form-control vehicleName" name="package_sub_detail_name['+index+'][]" id="package_sub_detail_name" value="">';
            html +='</div>';
            html +='</div>';
            html +='<div class="col-md-6">';
            html +='<label for=""></label>';
            html +='<button type="button" title="Remove Sub Details" class="btn btn-danger remove_sub_details_button"><i class="icon-trash"></i></button>';
            html +='</div>';
            html +='</div>';

            $(this).parents('.package_sub_details_area').append(html);

        });

        $(document).on('click', '.remove_sub_details_button', function(){
            $(this).parents('.package_sub_details').remove();
        });

        $(document).on('click', '.add_benefits_button', function(){
            var html = '';
            html +='<div class="row package_benefits" style="padding: 10px; margin:5px">';
            html +='<div class="col-md-6">';
            html +='<div class="form-group">';
            html +='<input type="text" class="form-control PackageBenefit" name="package_benefits[]" id="package_benefits" value="">';
            html +='</div>';
            html +='</div>';
            html +='<div class="col-md-6">';
            html +='<label for=""></label>';
            html +='<button type="button" title="Remove Package Benefit" class="btn btn-danger remove_benefits_button"><i class="icon-trash"></button>';
            html +='</div>';
            html +='</div>';

            $('#package_benefits_area').append(html);

        });

        $(document).on('click', '.remove_benefits_button', function(){
            $(this).parents('.package_benefits').remove();
        });

        $(document).on("submit", "#package_form", function(event) {
            event.preventDefault();
            show_loader();

            var name = $("#name").val();
            var vehicle_name = $("#vehicle_name").val();
            var package_price = $("#package_price").val();
            var package_validity = $("#package_validity").val();

            var validate = "";
            var isValid = 1;

            if(name.trim() == "") {
                validate = validate + "Package name is required</br>";
            }
            if(vehicle_name.trim() == "") {
                validate = validate + "Vehicle name is required</br>";
            }
            if(package_price.trim() == "") {
                validate = validate + "Package price is required</br>";
            }
            if(package_validity.trim() == "") {
                validate = validate + "Package validity is required</br>";
            }
            $(".PackageDetailsName").each(function() {
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
                validate = validate+"Fill out all mandatory fields in vehicle details section</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#package_form")[0]);
                var url = "{{ url('packages/store') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#package_form')[0].reset();

                            $("#success_message").show();
                            $("#error_message").hide();
                            $("#success_message").html(data.reason);
                            setTimeout(function(){
                                window.location.href="{{url('packages')}}";
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

