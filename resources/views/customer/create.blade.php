@extends('layouts.master')
@section('title', 'Create Customer')
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
                        <a href="{{url('customers')}}">Customers</a>
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
                    <form  id="customer_form" method="post" action="" enctype="multipart/form-data">
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
                                                    <label for=""><b>First Name</b></label>
                                                    <input type="text" class="form-control" name="first_name" id="first_name" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Last Name</b></label>
                                                    <input type="text" class="form-control" name="last_name" id="last_name" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Phone</b></label>
                                                    <div>
                                                        <input type="number" class="form-control" name="phone" id="phone" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Email</b></label>
                                                    <div>
                                                        <input type="text" class="form-control" name="email" id="email" value="" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Password</b></label>
                                                    <div>
                                                        <input type="password" class="form-control" name="password" id="password" value="" autocomplete="new-password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Confirm Password</b></label>
                                                    <div>
                                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="" autocomplete="new-password">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Address</b></label>
                                                    <input type="text" class="form-control" name="address" id="address" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-12" id="vehicle_credentials_area">
                                                <div class="row vehicle_credentials" style="border: 1px solid;padding: 10px; margin:5px">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for=""><b>Vehicle Name</b></label>
                                                            <input type="text" class="form-control vehicleName" name="vehicle_name[]" id="vehicle_name" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for=""><b>Vehicle Registration Number</b></label>
                                                            <input type="text" class="form-control vehicleRegistrationNumber" name="vehicle_registration_number[]" id="vehicle_registration_number" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for=""><b>Vehicle Model</b></label>
                                                            <input type="text" class="form-control vehicleModel" name="vehicle_model[]" id="vehicle_model" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-primary add_button">Add Vehicle Credentials</button>
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

        $(document).on('click', '#image_change_btn', function(){
            $('#image_change_hidden_btn').trigger('click');
        });

        $(document).on('change', '#image_change_hidden_btn', function(){
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#image')
                        .attr('src', e.target.result)
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).on('click', '.add_button', function(){
            var html = '';
            html +='<div class="row vehicle_credentials" style="border: 1px solid;padding: 10px; margin:5px">';
                html +='<div class="col-md-6">';
                    html +='<div class="form-group">';
                    html +='<label for=""><b>Vehicle Name</b></label>';
                        html +='<input type="text" class="form-control vehicleName" name="vehicle_name[]" id="vehicle_name" value="">';
                    html +='</div>';
                html +='</div>';
                html +='<div class="col-md-6">';
                    html +='<div class="form-group">';
                        html +='<label for=""><b>Vehicle Registration Number</b></label>';
                        html +='<input type="text" class="form-control vehicleRegistrationNumber" name="vehicle_registration_number[]" id="vehicle_registration_number" value="">';
                    html +='</div>';
                html +='</div>';
                html +='<div class="col-md-6">';
                    html +='<div class="form-group">';
                        html +='<label for=""><b>Vehicle Model</b></label>';
                        html +='<input type="text" class="form-control vehicleModel" name="vehicle_model[]" id="vehicle_model" value="">';
                    html +='</div>';
                html +='</div>';
                html +='<div class="col-md-6">';
                    html +='<button type="button" class="btn btn-danger remove_button">Remove</button>';
                html +='</div>';
            html +='</div>';

            $('#vehicle_credentials_area').append(html);

        });

        $(document).on('click', '.remove_button', function(){
            $(this).parents('.vehicle_credentials').remove();
        });

        $(document).on("submit", "#customer_form", function(event) {
            event.preventDefault();
            show_loader();

            var first_name = $("#first_name").val();
            var address = $("#address").val();
            var phone = $("#phone").val();
            var email = $("#email").val();
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();

            var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            var validate = "";
            var isValid = 1;

            if (first_name.trim() == "") {
                validate = validate + "First name is required</br>";
            }
            if (phone.trim() == "") {
                validate = validate + "Phone is required</br>";
            }
            if (email.trim() == "") {
                validate = validate + "Email is required</br>";
            }
            if (password.trim() == "") {
                validate = validate + "Password is required</br>";
            }
            if (password.trim() != confirm_password.trim()) {
                validate = validate + "Password and confirm password not matched</br>";
            }
            if(email.trim()!=''){
                if(!re.test(email)){
                    validate = validate+'Email is invalid<br>';
                }
            }
            $(".vehicleName").each(function() {
                var element = $(this);
                if (element.val() == '') {
                    isValid = 0;
                    $(this).css('border','1px solid #ef0530');
                }
                else{
                    $(this).css('border','1px solid #c2cad8');
                }
            });
            $(".vehicleRegistrationNumber").each(function() {
                var element = $(this);
                if (element.val() == '') {
                    isValid = 0;
                    $(this).css('border','1px solid #ef0530');
                }
                else{
                    $(this).css('border','1px solid #c2cad8');
                }
            });
            $(".vehicleModel").each(function() {
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
                validate = validate+"Fill out all mandatory fields in vehicle credentials section</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#customer_form")[0]);
                var url = "{{ url('customers/store') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#customer_form')[0].reset();

                            $("#success_message").show();
                            $("#error_message").hide();
                            $("#success_message").html(data.reason);
                            setTimeout(function(){
                                window.location.href="{{url('customers')}}";
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

