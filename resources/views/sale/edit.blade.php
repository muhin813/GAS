@extends('layouts.master')
@section('title', 'Edit Sale')
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
                        <a href="{{url('sales')}}">Sale</a>
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
                    <form  id="sale_form" method="post" action="" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$sale->id}}">
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
                                                    <label for=""><b>Job Tracking Number</b></label>
                                                    <select name="job_tracking_number" id="job_tracking_number" class="form-control">
                                                        <option value="">Select Job Tracking Number</option>
                                                        @foreach($jobs as $job)
                                                            <option value="{{$job->tracking_number}}" @if($job->tracking_number==$sale->job_tracking_number) selected @endif>{{$job->tracking_number}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Sales Type</b></label>
                                                    <select name="sales_type" id="sales_type" class="form-control">
                                                        <option value="">Select Type</option>
                                                        <option value="service" @if($sale->sales_type=='service') selected @endif>Service Sale</option>
                                                        <option value="product" @if($sale->sales_type=='product') selected @endif>Product Sale</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Customer Registration Number</b></label>
                                                    <select name="customer_registration_number" id="customer_registration_number" class="form-control">
                                                        <option value="">Select Customer</option>
                                                        @foreach($customers as $customer)
                                                            <option value="{{$customer->registration_number}}" @if($customer->registration_number==$sale->customer_registration_number) selected @endif>{{$customer->registration_number}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="service_category_area" @if($sale->sales_type=='product') style="display:none" @endif>
                                                <div class="form-group">
                                                    <label for=""><b>Service Category</b></label>
                                                    <select name="service_category_id" id="service_category_id" class="form-control">
                                                        <option value="">Select Category</option>
                                                        @foreach($service_categories as $category)
                                                            <option value="{{$category->id}}"  @if($category->id==$sale->service_category_id) selected @endif>{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="service_type_area" @if($sale->sales_type=='product') style="display:none" @endif>
                                                <div class="form-group">
                                                    <label for=""><b>Service Type</b></label>
                                                    <select name="service_type_id" id="service_type_id" class="form-control">
                                                        <option value="">Select Type</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="service_amount_area" @if($sale->sales_type=='product') style="display:none" @endif>
                                                <div class="form-group">
                                                    <label for=""><b>Service Amount</b></label>
                                                    <div>
                                                        <input type="number" class="form-control" name="service_amount" id="service_amount" value="{{$sale->service_amount}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="discount_area" @if($sale->sales_type=='product') style="display:none" @endif>
                                                <div class="form-group">
                                                    <label for=""><b>Discount</b></label>
                                                    <div>
                                                        <input type="number" class="form-control" name="discount" id="discount" value="{{$sale->discount}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Vat</b></label>
                                                    <div>
                                                        <input type="number" class="form-control" name="vat" id="vat" value="{{$sale->vat}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="items_area" @if($sale->sales_type=='service') style="display:none" @endif>
                                            @foreach($sale->details as $key=>$s_detail)
                                            <div class="row single_item" style="border: 1px solid;padding: 10px; margin:5px">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for=""><b>Item Name</b></label>
                                                        <select name="products[]" id="products" class="form-control Item">
                                                            <option value="">Select Item</option>
                                                            @foreach($items as $item)
                                                                <option value="{{$item->id}}" @if($item->id==$s_detail->item_id) selected @endif >{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for=""><b>Quantity</b></label>
                                                        <input type="text" class="form-control Quantity" name="product_quantities[]" id="product_quantities" value="{{$s_detail->quantity}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for=""><b>Unit Price</b></label>
                                                        <input type="number" class="form-control UnitPrice" name="unit_prices[]" id="unit_prices" value="{{$s_detail->unit_price}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for=""><b>Discount</b></label>
                                                        <input type="number" class="form-control Discount" name="discounts[]" id="discounts" value="{{$s_detail->discount}}">
                                                    </div>
                                                </div>
                                                @if($key>0)
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-danger remove_item_button">Remove</button>
                                                </div>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="col-md-6" id="add_item_btn" @if($sale->sales_type=='service') style="display:none" @endif>
                                            <button type="button" class="btn btn-primary add_item_button">Add Item</button>
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
            var service_category_id = '{{$sale->service_category_id}}';
            var service_type_id = '{{$sale->service_type_id}}';
            populate_service_type(service_category_id,service_type_id);
        });

        $(document).on('change', '#service_category_id', function(){
            var service_category_id = $(this).val();
            populate_service_type(service_category_id);
        });

        function populate_service_type(service_category_id,service_type_id=''){
            var url = "{{ url('get_service_type_by_category') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {service_category_id:service_category_id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var service_types = data.service_types;
                        var options = '<option value="">Select Type</option>';
                        $.each(service_types , function(index, type) {
                            options +='<option value="'+type.id+'">'+type.name+'</option>';
                        });
                        $('#service_type_id').html(options);
                        $('#service_type_id').val(service_type_id);

                    } else {
                        show_error_message('Something went wrong.');
                    }
                },
                error: function(data) {
                    hide_loader();
                    show_error_message(data);
                }
            });
        }

        $(document).on('change', '#sales_type', function(){
            var sales_type = $(this).val();
            if(sales_type=='product'){
                $('#service_category_id, #service_type_id, #service_amount, #discount').val('');
                $('#service_category_area').hide();
                $('#service_type_area').hide();
                $('#service_amount_area').hide();
                $('#discount_area').hide();
                $('#items_area').show();
                $('#add_item_btn').show();
            }
            else{
                $('#service_category_area').show();
                $('#service_type_area').show();
                $('#service_amount_area').show();
                $('#discount_area').show();
                $('#items_area').hide();
                $('#add_item_btn').hide();
            }
        });

        $(document).on('click', '.add_item_button', function(){
            var html = '';
            html +='<div class="row single_item" style="border: 1px solid;padding: 10px; margin:5px">';
            html +='<div class="col-md-6">';
            html +='<div class="form-group">';
            html +='<label for=""><b>Item Name</b></label>';
            html +='<select name="products[]" id="products" class="form-control Item">';
            html +='<option value="">Select Item</option>';
            @foreach($items as $item)
                html +='<option value="{{$item->id}}" >{{$item->name}}</option>';
            @endforeach
                html +='</select>';
            html +='</div>';
            html +='</div>';
            html +='<div class="col-md-6">';
            html +='<div class="form-group">';
            html +='<label for=""><b>Quantity</b></label>';
            html +='<input type="text" class="form-control Quantity" name="product_quantities[]" id="product_quantities" value="">';
            html +='</div>';
            html +='</div>';
            html +='<div class="col-md-6">';
            html +='<div class="form-group">';
            html +='<label for=""><b>Unit Price</b></label>';
            html +='<input type="number" class="form-control UnitPrice" name="unit_prices[]" id="unit_prices" value="">';
            html +='</div>';
            html +='</div>';
            html +='<div class="col-md-6">';
            html +='<div class="form-group">';
            html +='<label for=""><b>Discount</b></label>';
            html +='<input type="number" class="form-control Discount" name="discounts[]" id="discounts" value="">';
            html +='</div>';
            html +='</div>';
            html +='<div class="col-md-6">';
            html +='<button type="button" class="btn btn-danger remove_item_button">Remove</button>';
            html +='</div>';
            html +='</div>';

            $('#items_area').append(html);

        });

        $(document).on('click', '.remove_item_button', function(){
            $(this).parents('.single_item').remove();
        });

        $(document).on("submit", "#sale_form", function(event) {
            event.preventDefault();
            show_loader();

            var job_tracking_number = $("#job_tracking_number").val();
            var sales_type = $("#sales_type").val();
            var customer_registration_number = $("#customer_registration_number").val();
            var service_category_id = $("#service_category_id").val();
            var service_type_id = $("#service_type_id").val();
            var service_amount = $("#service_amount").val();

            var validate = "";
            var isValid = 1;

            if (sales_type.trim() == "service") {
                if (job_tracking_number.trim() == "") {
                    validate = validate + "Job tracking number is required</br>";
                }
                if (service_amount.trim() == "") {
                    validate = validate + "Service amount is required</br>";
                }
                if (service_category_id.trim() == "") {
                    validate = validate + "Service category is required</br>";
                }
                if (service_type_id.trim() == "") {
                    validate = validate + "Service type is required</br>";
                }
            }
            if (sales_type.trim() == "") {
                validate = validate + "Sales type is required</br>";
            }
            if (customer_registration_number.trim() == "") {
                validate = validate + "Customer Registration number is required</br>";
            }

            if (sales_type.trim() == "product") {
                $(".Item").each(function () {
                    var element = $(this);
                    if (element.val() == '') {
                        isValid = 0;
                        $(this).css('border', '1px solid #ef0530');
                    } else {
                        $(this).css('border', '1px solid #c2cad8');
                    }
                });
                $(".Quantity").each(function () {
                    var element = $(this);
                    if (element.val() == '') {
                        isValid = 0;
                        $(this).css('border', '1px solid #ef0530');
                    } else {
                        $(this).css('border', '1px solid #c2cad8');
                    }
                });
                $(".UnitPrice").each(function () {
                    var element = $(this);
                    if (element.val() == '') {
                        isValid = 0;
                        $(this).css('border', '1px solid #ef0530');
                    } else {
                        $(this).css('border', '1px solid #c2cad8');
                    }
                });
                if(isValid==0){
                    validate = validate+"Fill out all mandatory fields in item section</br>";
                }
            }

            if (validate == "") {
                var formData = new FormData($("#sale_form")[0]);
                var url = "{{ url('sales/update') }}";

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

