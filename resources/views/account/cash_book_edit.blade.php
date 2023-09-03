@extends('layouts.master')
@section('title', 'Edit Cash Book')
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
                        <a href="{{url('cash_books')}}">Cash Book</a>
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
                    <form  id="cash_book_form" method="post" action="" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$cash_book->id}}">
                        <div class="alert alert-success" id="success_message" style="display:none"></div>
                        <div class="alert alert-danger" id="error_message" style="display: none"></div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Date</b></label>
                                    <input type="text" class="form-control datepicker" name="date" id="date" value="{{date('m/d/Y',strtotime($cash_book->date))}}" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Debit Party</b></label>
                                    <input type="text" class="form-control" name="debit_party" id="debit_party" value="{{$cash_book->debit_party}}" >
                                    <input type="hidden" class="" name="debit_party_old" id="debit_party_old" value="{{$cash_book->debit_party}}" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Credit Party</b></label>
                                    <input type="text" class="form-control" name="credit_party" id="credit_party" value="{{$cash_book->credit_party}}" >
                                    <input type="hidden" class="" name="credit_party_old" id="credit_party_old" value="{{$cash_book->credit_party}}" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Amount</b></label>
                                    <input type="number" class="form-control" name="amount" id="amount" value="{{$cash_book->amount}}" >
                                    <input type="hidden" class="" name="amount_old" id="amount_old" value="{{$cash_book->amount}}" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Narration</b></label>
                                    <input type="text" class="form-control" name="narration" id="narration" value="{{$cash_book->narration}}" >
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn green submit-btn" id="profile_button">Save</button>
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

        $(document).on("submit", "#cash_book_form", function(event) {
            event.preventDefault();
            show_loader();

            var date = $("#date").val();
            var debit_party = $("#debit_party").val();
            var credit_party = $("#credit_party").val();
            var amount = $("#amount").val();

            var validate = "";

            if (date.trim() == "") {
                validate = validate + "Date is required</br>";
            }
            if (debit_party.trim() == "") {
                validate = validate + "Debit party is required</br>";
            }
            if (credit_party.trim() == "") {
                validate = validate + "Credit party is required</br>";
            }
            if (amount.trim() == "") {
                validate = validate + "Amount is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#cash_book_form")[0]);
                var url = "{{ url('cash_books/update') }}";

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
                                location.reload();
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

