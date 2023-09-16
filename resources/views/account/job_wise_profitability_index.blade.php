@extends('layouts.master')
@section('title', 'Job Wise Profitability')
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
                        <span>Job Wise Profitability</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title">
                sales
            </h3> -->
            <!-- END PAGE TITLE-->
            <!-- END PAGE BAR -->
            <!-- END PAGE HEADER-->

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="page-top-header">
                                    <h3 class="page-title">Job Wise Profitability</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- BEGIN PROFILE SIDEBAR -->
                    <!-- <div class="profile-sidebar">

                        <div class="portlet light profile-sidebar-portlet ">

                        </div>

                    </div> -->
                    <!-- END BEGIN PROFILE SIDEBAR -->
                    <!-- BEGIN PROFILE CONTENT -->
                    <div class="profile-content">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN PORTLET -->
                                <div class="portlet light ">
                                    <!-- <div class="portlet-title" style="border: 1px solid #000; padding: 10px;">

                                    </div> -->
                                    <div class="portlet-body">
                                        <div class="row">
                                            <table id="sale_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Invoice Date</th>
                                                        <th class="text-center">Invoice Month</th>
                                                        <th class="text-center">Invoice Number</th>
                                                        <th class="text-center">Invoice Amount</th>
                                                        <th class="text-center">Sales Type</th>
                                                        <th class="text-center">Costing Amount</th>
                                                        <th class="text-center">Profit Amount</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach($sales as $key=>$sale){
                                                        $profit_amount = $sale->total_amount-$sale->costing_amount;
                                                    ?>
                                                        <tr id="sale_{{$sale->id}}">
                                                            <td class="text-center">{{date('d/m/Y',strtotime($sale->created_at))}}</td>
                                                            <td class="text-center">{{date('M/Y',strtotime($sale->created_at))}}</td>
                                                            <td class="text-center">{{$sale->invoice_number}}</td>
                                                            <td class="text-center">{{$sale->total_amount}}</td>
                                                            <td class="text-center">{{$sales_types[$sale->sales_type]}}</td>
                                                            <td class="text-center">{{$sale->costing_amount}}</td>
                                                            <td class="text-center">{{number_format($profit_amount, 2, '.', '')}}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-success btn-sm" href="javascript:void(0)" title="Add Costing" onclick="add_costing({{$sale->id}})"><i class="icon-pencil"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>

                                            {{-- Pagination --}}
                                            <div class="">
                                                {{ $sales->appends($_GET)->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END PORTLET -->
                            </div>
                        </div>
                    </div>
                    <!-- END PROFILE CONTENT -->
                </div>
            </div>

            <div class="modal fade" id="service_sales_costing_modal" tabindex="-1" role="dialog" aria-labelledby="prescriptionDetailsModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Costing</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form  id="service_sales_costing_form" method="post" action="" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="alert alert-success" id="service_sales_costing_success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="service_sales_costing_error_message" style="display: none"></div>
                                <input type="hidden" name="sales_id" id="service_sales_id" value="">

                                <div class="row">
                                    <div class="col-md-12" id="service_sales_cost_area">

                                    </div>
                                </div>

                                <div class="form-group text-right">
                                    <button type="submit" class="btn green submit-btn" id="profile_button">Save</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" id="">Close</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- END CONTENT BODY -->
    </div>

    <!-- END CONTENT -->
@endsection

@section('js')
    <script>

        function add_costing(id){
            var url = "{{ url('sales/get_costing_details') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {sales_id:id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var sale_costings = data.sale_costings;

                        if(data.sale.sales_type=='product'){
                            $('#product_sales_costing_modal').modal('show');

                        }
                        else{
                            $('#service_sales_id').val(id);

                            var html = '';
                            var grant_total_value = 0;
                            $.each(sale_costings , function(index, costing) {
                                html +='<div class="row service_sales_cost">';
                                html +='<div class="col-md-4">';
                                html +='<div class="form-group">';
                                html +='<label for=""><b>Cost Name</b></label>';
                                html +='<input type="text" class="form-control costName" name="cost_name[]" id="cost_name" value="'+costing.cost_name+'" >';
                                html +='</div>';
                                html +='</div>';
                                html +='<div class="col-md-4">';
                                html +='<div class="form-group">';
                                html +='<label for=""><b>Amount</b></label>';
                                html +='<input type="number" class="form-control costAmount" name="amount[]" id="amount" value="'+costing.total_value+'" >';
                                html +='</div>';
                                html +='</div>';
                                html +='<div class="col-md-2">';
                                if(index==0){
                                    html +='<button type="button" title="Add outstanding deposit" class="btn btn-primary add_service_sales_cost_button">Add</button>';
                                }
                                else{
                                    html +='<button type="button" title="Remove cost" class="btn btn-danger remove_service_sales_cost_button">Remove</button>';
                                }
                                html +='</div>';
                                html +='</div>';

                                grant_total_value = grant_total_value+parseFloat(costing.total_value);
                            });

                            if(html==''){ // If no previous costing saved
                                html +='<div class="row service_sales_cost">';
                                html +='<div class="col-md-4">';
                                html +='<div class="form-group">';
                                html +='<label for=""><b>Cost Name</b></label>';
                                html +='<input type="text" class="form-control costName" name="cost_name[]" id="cost_name" value="" >';
                                html +='</div>';
                                html +='</div>';
                                html +='<div class="col-md-4">';
                                html +='<div class="form-group">';
                                html +='<label for=""><b>Amount</b></label>';
                                html +='<input type="number" class="form-control costAmount" name="amount[]" id="amount" value="" >';
                                html +='</div>';
                                html +='</div>';
                                html +='<div class="col-md-2">';
                                html +='<button type="button" title="Add outstanding deposit" class="btn btn-primary add_service_sales_cost_button">Add</button>';
                                html +='</div>';
                                html +='</div>';
                            }

                            $('#service_sales_cost_area').html(html);
                            $('#service_sales_costing_modal').modal('show');
                        }

                    } else {
                        show_error_message('Something went wrong. Please try again later');
                    }
                },
                error: function(data) {
                    hide_loader();
                    show_error_message(data);
                }
            });
        }

        $(document).on('click', '.add_service_sales_cost_button', function(){
            var html = '';
            html +='<div class="row service_sales_cost">';
            html +='<div class="col-md-4">';
            html +='<div class="form-group">';
            html +='<label for=""><b>Cost Name</b></label>';
            html +='<input type="text" class="form-control costName" name="cost_name[]" id="cost_name" value="" >';
            html +='</div>';
            html +='</div>';
            html +='<div class="col-md-4">';
            html +='<div class="form-group">';
            html +='<label for=""><b>Amount</b></label>';
            html +='<input type="number" class="form-control costAmount" name="amount[]" id="amount" value="" >';
            html +='</div>';
            html +='</div>';
            html +='<div class="col-md-2">';
            html +='<button type="button" title="Remove cost" class="btn btn-danger remove_service_sales_cost_button">Remove</button>';
            html +='</div>';
            html +='</div>';
            $('#service_sales_cost_area').append(html);

        });

        $(document).on('click', '.remove_service_sales_cost_button', function(){
            $(this).parents('.service_sales_cost').remove();
        });

        $(document).on("submit", "#service_sales_costing_form", function(event) {
            event.preventDefault();
            show_loader();

            var validate = "";
            var isValid = 1;

            $(".costName").each(function() {
                var element = $(this);
                if (element.val() == '') {
                    isValid = 0;
                    $(this).css('border','1px solid #ef0530');
                }
                else{
                    $(this).css('border','1px solid #c2cad8');
                }
            });
            $(".costAmount").each(function() {
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
                validate = validate+"Fill out all mandatory fields </br>";
            }

            if (validate == "") {
                var formData = new FormData($("#service_sales_costing_form")[0]);
                var url = "{{ url('sales/store_costing') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#service_sales_costing_form')[0].reset();

                            $("#service_sales_costing_success_message").show();
                            $("#service_sales_costing_error_message").hide();
                            $("#service_sales_costing_success_message").html(data.reason);
                            setTimeout(function(){
                                location.reload();
                            },1000)
                        } else {
                            $("#service_sales_costing_success_message").hide();
                            $("#service_sales_costing_error_message").show();
                            $("#service_sales_costing_error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        hide_loader();
                        $("#service_sales_costing_success_message").hide();
                        $("#service_sales_costing_error_message").show();
                        $("#service_sales_costing_error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                $("html, body").animate({ scrollTop: 0 }, 1000);
                hide_loader();
                $("#service_sales_costing_success_message").hide();
                $("#service_sales_costing_error_message").show();
                $("#service_sales_costing_error_message").html(validate);
            }
        });

    </script>
@endsection

