@extends('layouts.master')
@section('title', 'Edit Stock Issue')
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
                        <a href="{{url('stock_issues')}}">Stock Issues</a>
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
                    <form  id="stock_issue_form" method="post" action="" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$stock_issue->id}}">
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
                                                    <label for=""><b>Issue Date</b></label>
                                                    <input type="text" class="form-control datepicker" name="date_of_issue" id="date_of_issue" value="{{date('m/d/Y',strtotime($stock_issue->date_of_issue))}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Supplier Invoice Number</b></label>
                                                    <select name="supplier_invoice_number" id="supplier_invoice_number" class="form-control" disabled>
                                                        <option value="">Select Invoice</option>
                                                        @foreach($purchases as $purchase)
                                                            <option value="{{$purchase->challan_no}}" @if($purchase->challan_no==$stock_issue->supplier_invoice_number) selected @endif >{{$purchase->challan_no}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Item</b></label>
                                                    <div>
                                                        <input type="text" class="form-control" name="item_name" id="item_name" value="{{$stock_issue->item_name}}" disabled >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Unit Price</b></label>
                                                    <div>
                                                        <input type="number" class="form-control" name="unit_price" id="unit_price" value="{{$stock_issue->unit_price}}" disabled >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Quantity</b></label>
                                                    <div>
                                                        <input type="number" class="form-control" name="quantity" id="quantity" value="{{$stock_issue->quantity}}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Total Value</b></label>
                                                    <div>
                                                        <input type="number" class="form-control" name="total_value" id="total_value" value="{{$stock_issue->total_value}}" disabled >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Job Tracking Number</b></label>
                                                    <select name="job_tracking_number" id="job_tracking_number" class="form-control">
                                                        <option value="">Select Job Tracking Number</option>
                                                        @foreach($jobs as $job)
                                                            <option value="{{$job->tracking_number}}" @if($job->tracking_number==$stock_issue->job_tracking_number) selected @endif>{{$job->tracking_number}}</option>
                                                        @endforeach
                                                    </select>
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

        $(document).on('keyup', '#quantity', function(){
            var quantity = $(this).val();
            var unit_price = $('#unit_price').val();
            var total_value = quantity*unit_price;
            $('#total_value').val(total_value);
        });

        $(document).on("submit", "#stock_issue_form", function(event) {
            event.preventDefault();
            show_loader();

            var date_of_issue = $("#date_of_issue").val();
            var supplier_invoice_number = $("#supplier_invoice_number").val();
            var quantity = $("#quantity").val();
            var quantity_left = $("#quantity_left").val();

            var validate = "";

            if (date_of_issue.trim() == "") {
                validate = validate + "Date of issue is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#stock_issue_form")[0]);
                var url = "{{ url('stock_issues/update') }}";

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

