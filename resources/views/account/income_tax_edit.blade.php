@extends('layouts.master')
@section('title', 'Edit Income Tax')
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
                        <a href="{{url('income_taxes')}}">Income Taxes</a>
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
                    <form  id="income_tax_form" method="post" action="" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$income_tax->id}}">
                        <div class="alert alert-success" id="success_message" style="display:none"></div>
                        <div class="alert alert-danger" id="error_message" style="display: none"></div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Year</b></label>
                                    <select name="year" id="year" class="form-control">
                                        @for($year=date('Y'); $year>=2020; $year--)
                                            <option value="{{$year}}" @if($income_tax->year==$year) selected @endif>{{$year}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Month</b></label>
                                    <select name="month" id="month" class="form-control">
                                        <option value="">Select Month</option>
                                        @foreach($months as $month)
                                            <option value="{{$month}}" @if($income_tax->month==$month) selected @endif>{{$month}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Tax Amount</b></label>
                                    <input type="text" class="form-control price" name="tax_amount" id="tax_amount" value="{{$income_tax->tax_amount}}" >
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

        $(document).on("submit", "#income_tax_form", function(event) {
            event.preventDefault();
            show_loader();

            var year = $("#year").val();
            var month = $("#month").val();
            var tax_amount = $("#tax_amount").val();

            var validate = "";

            if (year.trim() == "") {
                validate = validate + "Year is required</br>";
            }
            if (month.trim() == "") {
                validate = validate + "Month is required</br>";
            }
            if (tax_amount.trim() == "") {
                validate = validate + "Tax amount is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#income_tax_form")[0]);
                var url = "{{ url('income_taxes/update') }}";

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

