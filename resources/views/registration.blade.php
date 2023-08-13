<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>Registration</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/global/img/icons/favicon.ico')}}" type="image/x-icon">
    <!-- END Favicon -->
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{asset('assets/global/plugins/morris/morris.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{asset('assets/global/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{asset('assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->

    <!-- BEGIN GLOBAL PAGE STYLES -->
    <link href="{{asset('assets/pages/css/login.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/intl-tel-input-master/css/intlTelInput.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL PAGE STYLES-->

    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{asset('assets/layouts/layout/css/layout.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/layouts/layout/css/themes/blue.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{asset('assets/layouts/layout/css/custom.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('assets/holdon/holdon.min.css')}}" rel="stylesheet" />
    <!-- END THEME LAYOUT STYLES -->
</head>

<body class=" login">

<!--<div class="login-header">-->
<!--    <div class="page-logo">-->
<!--        <a href="{{url('/')}}" class="nav-item ajax_item item-1  " data-name="dashboard" data-item="1">-->
<!--        <img style="width: 100%;" src="{{asset('assets/layouts/layout/img/logo.png')}}" alt="Vujadetec logo" class="logo-default">-->
<!--        </a>-->
<!--    </div>-->
<!--</div>-->

<!-- BEGIN LOGIN -->
<div class="page-content-wrapper">
    <!-- BEGIN LOGIN FORM -->
    <form  id="customer_form" method="post" action="" enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PORTLET -->
                <div class="portlet light ">
                    <div class="alert alert-success" id="success_message" style="display:none"></div>
                    <div class="alert alert-danger" id="error_message" style="display: none"></div>
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
    <!-- END LOGIN FORM -->
</div>

<!--[if lt IE 9]>
<script src="{{asset('assets/global/plugins/respond.min.js')}}"></script>
<script src="{{asset('assets/global/plugins/excanvas.min.js')}}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{asset('assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{asset('assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>

<!--For chart START-->
<script src="{{asset('assets/global/plugins/flot/jquery.flot.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/flot/jquery.flot.categories.min.js')}}" type="text/javascript"></script>
<!--For chart END-->
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{asset('assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
<!-- input with country flag & code-->
<script src="{{asset('assets/global/plugins/intl-tel-input-master/js/intlTelInput-jquery.min.js')}}" type="text/javascript"></script>
<!-- For Documentation https://github.com/jackocnr/intl-tel-input#demo-and-examples-->
<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{asset('assets/layouts/layout/scripts/layout.min.js')}}" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{asset('assets/pages/scripts/dashboard.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script src="{{ asset('assets/holdon/holdon.min.js')}}"></script>

<!-- BEGIN GLOABL CUSTOM SCRIPTS -->
{{--<script src="{{asset('assets/global/scripts/custom.js')}}" type="text/javascript"></script>--}}
<!-- END GLOABL CUSTOM SCRIPTS -->

<script type="text/javascript">
    $(document).ready(function(){

    });

    function show_loader(message=''){
        if(message==''){
            message = 'Please wait while saving all data.....'; // Showing default message
        }
        var options = {
            theme: "sk-cube-grid",
            message: message,
            backgroundColor: "#1847B1",
            textColor: "white"
        };

        HoldOn.open(options);
    }

    function hide_loader(){
        HoldOn.close();
    }

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
            var url = "{{ url('registration/store') }}";

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
                    window.location.href="{{url('login')}}";
                    },1000)
                }
                else {
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
        }
        else {
            hide_loader();
            $("#success_message").hide();
            $("#error_message").show();
            $("#error_message").html(validate);
        }
    });
</script>

</body>

</html>
