@extends('layouts.master')
@section('title', 'Create Purchase')
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
                        <a href="{{url('purchases')}}">Purchases</a>
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
                    <form  id="purchase_form" method="post" action="" enctype="multipart/form-data">
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
                                                    <label for=""><b>Purchase Date</b></label>
                                                    <input type="text" class="form-control datepicker" name="date_of_purchase" id="date_of_purchase" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Item</b></label>
                                                    <select name="item_id" id="item_id" class="form-control">
                                                        <option value="">Select Item</option>
                                                        @foreach($items as $item)
                                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Supplier</b></label>
                                                    <select name="supplier_id" id="supplier_id" class="form-control">
                                                        <option value="">Select Supplier</option>
                                                        @foreach($suppliers as $supplier)
                                                            <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Item UOM</b></label>
                                                    <select name="item_uom_id" id="item_uom_id" class="form-control">
                                                        <option value="">Select Item UOM</option>
                                                        @foreach($item_uoms as $item_uom)
                                                            <option value="{{$item_uom->id}}">{{$item_uom->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Package</b></label>
                                                    <div>
                                                        <input type="number" class="form-control" name="package" id="package" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Package UOM</b></label>
                                                    <select name="package_uom_id" id="package_uom_id" class="form-control">
                                                        <option value="">Select Package UOM</option>
                                                        @foreach($package_uoms as $package_uom)
                                                            <option value="{{$package_uom->id}}">{{$package_uom->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Challan Number</b></label>
                                                    <div>
                                                        <input type="text" class="form-control" name="challan_no" id="challan_no" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Quantity</b></label>
                                                    <div>
                                                        <input type="number" class="form-control" name="quantity" id="quantity" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""><b>Unit Price</b></label>
                                                    <div>
                                                        <input type="text" class="form-control price" name="unit_price" id="unit_price" value="">
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

        $(document).on("submit", "#purchase_form", function(event) {
            event.preventDefault();
            show_loader();

            var date_of_purchase = $("#date_of_purchase").val();
            var item_id = $("#item_id").val();
            var supplier_id = $("#supplier_id").val();
            var item_uom_id = $("#item_uom_id").val();
            var package = $("#package").val();
            var package_uom_id = $("#item_uom_id").val();
            var challan_no = $("#challan_no").val();
            var quantity = $("#quantity").val();
            var unit_price = $("#unit_price").val();

            var validate = "";

            if (date_of_purchase.trim() == "") {
                validate = validate + "Date of purchase is required</br>";
            }
            if (item_id.trim() == "") {
                validate = validate + "Item is required</br>";
            }
            if (supplier_id.trim() == "") {
                validate = validate + "Supplier is required</br>";
            }
            if (item_uom_id.trim() == "") {
                validate = validate + "Item UOM is required</br>";
            }
            if (package.trim() == "") {
                validate = validate + "Package is required</br>";
            }
            if (package_uom_id.trim() == "") {
                validate = validate + "Package UOM is required</br>";
            }
            if (challan_no.trim() == "") {
                validate = validate + "Challan number is required</br>";
            }
            if (quantity.trim() == "") {
                validate = validate + "Quantity is required</br>";
            }
            if (unit_price.trim() == "") {
                validate = validate + "Unit price is required</br>";
            }

            if (validate == "") {
                var formData = new FormData($("#purchase_form")[0]);
                var url = "{{ url('purchases/store') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#purchase_form')[0].reset();

                            $("#success_message").show();
                            $("#error_message").hide();
                            $("#success_message").html(data.reason);
                            setTimeout(function(){
                                window.location.href="{{url('purchases')}}";
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

