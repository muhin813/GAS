@extends('layouts.master')
@section('title', 'Edit supplier')
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
                        <a href="{{url('suppliers')}}">Suppliers</a>
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
                    <form  id="supplier_form" method="post" action="" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$supplier->id}}">
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
                                                    <label for=""><b>Name</b></label>
                                                    <input type="text" class="form-control" name="name" id="name" value="{{$supplier->name}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>address</b></label>
                                                    <input type="text" class="form-control" name="address" id="address" value="{{$supplier->address}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Phone</b></label>
                                                    <div>
                                                        <input type="text" class="form-control" name="phone" id="phone" value="{{$supplier->phone}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Email</b></label>
                                                    <div>
                                                        <input type="text" class="form-control" name="email" id="email" value="{{$supplier->email}}">
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

        $(document).on("submit", "#supplier_form", function(event) {
            event.preventDefault();
            show_loader();

            var name = $("#name").val();
            var address = $("#address").val();
            var phone = $("#phone").val();
            var email = $("#email").val();

            var re = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            var validate = "";

            if (name.trim() == "") {
                validate = validate + "Name is required</br>";
            }
            if (phone.trim() == "") {
                validate = validate + "Phone is required</br>";
            }
            if(email.trim()!=''){
                if(!re.test(email)){
                    validate = validate+'Email is invalid<br>';
                }
            }

            if (validate == "") {
                var formData = new FormData($("#supplier_form")[0]);
                var url = "{{ url('suppliers/update') }}";

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

