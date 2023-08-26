@extends('layouts.master')
@section('title', 'Create Bank Account')
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
                        <a href="{{url('bank_accounts')}}">Bank Accounts</a>
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
                    <form  id="bank_account_form" method="post" action="" enctype="multipart/form-data">
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
                                                    <label for=""><b>Bank</b></label>
                                                    <select name="bank_id" id="bank_id" class="form-control">
                                                        <option value="">Select Bank</option>
                                                        @foreach($banks as $bank)
                                                            <option value="{{$bank->id}}" >{{$bank->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Bank Branch</b></label>
                                                    <select name="branch_id" id="branch_id" class="form-control">
                                                        <option value="">Select Branch</option>
                                                        @foreach($bank_branches as $bank_branch)
                                                            <option value="{{$bank_branch->id}}" >{{$bank_branch->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Account Name</b></label>
                                                    <input type="text" class="form-control" name="account_name" id="account_name" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Account Number</b></label>
                                                    <input type="text" class="form-control" name="account_number" id="account_number" value="">
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

        $(document).on("submit", "#bank_account_form", function(event) {
            event.preventDefault();
            show_loader();

            var bank_id = $("#bank_id").val();
            var branch_id = $("#branch_id").val();
            var account_name = $("#account_name").val();
            var account_number = $("#account_number").val();

            var validate = "";

            if (bank_id.trim() == "") {
                validate = validate + "Bank is required</br>";
            }
            if (branch_id.trim() == "") {
                validate = validate + "Bank Branch is required</br>";
            }
            if (account_name.trim() == "") {
                validate = validate + "Account Name is required</br>";
            }
            if (account_number.trim() == "") {
                validate = validate + "Account Number is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#bank_account_form")[0]);
                var url = "{{ url('bank_accounts/store') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#bank_account_form')[0].reset();

                            $("#success_message").show();
                            $("#error_message").hide();
                            $("#success_message").html(data.reason);
                            setTimeout(function(){
                                window.location.href="{{url('bank_accounts')}}";
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

