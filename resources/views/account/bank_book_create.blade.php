@extends('layouts.master')
@section('title', 'Create Bank Book')
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
                        <a href="{{url('bank_books')}}">Bank Books</a>
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
                    <form  id="bank_book_form" method="post" action="" enctype="multipart/form-data">
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
                                                    <label for=""><b>Date</b></label>
                                                    <input type="text" class="form-control datepicker" name="date" id="date" value="" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Transaction Type</b></label>
                                                    <select name="transaction_type" id="transaction_type" class="form-control">
                                                        <option value="">Select Type</option>
                                                        <option value="Receive">Receive</option>
                                                        <option value="Issue">Issue</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Bank</b></label>
                                                    <select name="bank_id" id="bank_id" class="form-control">
                                                        <option value="">Select Bank</option>
                                                        @foreach($banks as $bank)
                                                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Account</b></label>
                                                    <select name="account_number" id="account_number" class="form-control">
                                                        <option value="">Select Account</option>
                                                        @foreach($bank_accounts as $bank_account)
                                                            <option value="{{$bank_account->account_number}}">{{$bank_account->account_number}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Cheque Book</b></label>
                                                    <select name="cheque_book_number" id="cheque_book_number" class="form-control">
                                                        <option value="">Select Cheque Book Number</option>
                                                        @foreach($cheque_books as $cheque_book)
                                                            <option value="{{$cheque_book->book_number}}">{{$cheque_book->book_number}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Cheque Number</b></label>
                                                    <input type="text" class="form-control" name="cheque_number" id="cheque_number" value="" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Party</b></label>
                                                    <select name="party" id="party" class="form-control">
                                                        <option value="">Select Party</option>
                                                        @foreach($parties as $party)
                                                            <option value="{{$party->id}}">{{$party->party_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Amount</b></label>
                                                    <input type="number" class="form-control" name="amount" id="amount" value="" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Narration</b></label>
                                                    <input type="text" class="form-control" name="narration" id="narration" value="" >
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

        $(document).on("submit", "#bank_book_form", function(event) {
            event.preventDefault();
            show_loader();

            var date = $("#date").val();
            var transaction_type = $("#transaction_type").val();
            var bank_id = $("#bank_id").val();
            var account_number = $("#account_number").val();
            var cheque_book_number = $("#cheque_book_number").val();
            var cheque_number = $("#cheque_number").val();
            var party = $("#party").val();
            var amount = $("#amount").val();

            var validate = "";

            if (date.trim() == "") {
                validate = validate + "Date is required</br>";
            }
            if (transaction_type.trim() == "") {
                validate = validate + "Transaction type is required</br>";
            }
            if (bank_id.trim() == "") {
                validate = validate + "Bank is required</br>";
            }
            if (account_number.trim() == "") {
                validate = validate + "Account number is required</br>";
            }
            if (cheque_book_number.trim() == "" && transaction_type=="Issue") {
                validate = validate + "Cheque book number is required</br>";
            }
            if (cheque_number.trim() == "" && transaction_type=="Issue") {
                validate = validate + "Cheque number is required</br>";
            }
            if (party.trim() == "") {
                validate = validate + "Party is required</br>";
            }
            if (amount.trim() == "") {
                validate = validate + "Amount is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#bank_book_form")[0]);
                var url = "{{ url('bank_books/store') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#bank_book_form')[0].reset();

                            $("#success_message").show();
                            $("#error_message").hide();
                            $("#success_message").html(data.reason);
                            setTimeout(function(){
                                window.location.href="{{url('bank_books')}}";
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

