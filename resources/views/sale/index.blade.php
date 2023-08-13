@extends('layouts.master')
@section('title', 'Sales')
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
                        <span>Sales</span>
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
                                    <h3 class="page-title">All Sales</h3>

                                    <div class="portlet-body patients-info">
                                        <a href="{{url('sales/create')}}" class="btn btn-primary"><i class="icon-plus"></i>&nbsp; Add Sale</a>
                                    </div>
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
                                                        <th class="text-center">Sale Type</th>
                                                        <th class="text-center">Invoice Date</th>
                                                        <th class="text-center">Invoice Month</th>
                                                        <th class="text-center">Customer Name</th>
                                                        <th class="text-center">Customer Registration Number</th>
                                                        <th class="text-center">Job Tracking Number</th>
                                                        <th class="text-center">Invoice Number</th>
                                                        <th class="text-center">Invoice Amount</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($sales as $key=>$sale)
                                                        <tr id="sale_{{$sale->id}}">
                                                            <td class="text-center">{{$sales_types[$sale->sales_type]}}</td>
                                                            <td class="text-center">{{date('d/m/Y',strtotime($sale->created_at))}}</td>
                                                            <td class="text-center">{{date('M/Y',strtotime($sale->created_at))}}</td>
                                                            <td class="text-center">{{$sale->first_name." ".$sale->last_name}}</td>
                                                            <td class="text-center">{{$sale->customer_registration_number}}</td>
                                                            <td class="text-center">{{$sale->job_tracking_number}}</td>
                                                            <td class="text-center">{{$sale->invoice_number}}</td>
                                                            <td class="text-center">{{$sale->total_amount}}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-primary btn-sm" href="javascript:void(0)" title="View Details" onclick="view_details({{$sale->id}})"><i class="icon-eye"></i></a>
                                                                <a class="btn btn-info btn-sm" href="javascript:void(0)" title="Print" onclick="print_sales_invoice({{$sale->id}})"><i class="icon-printer"></i></a>
                                                                <a class="btn btn-success btn-sm" href="{{url('sales',$sale->id)}}" title="Edit"><i class="icon-pencil"></i></a>
                                                                <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Delete" onclick="delete_sale({{$sale->id}})"><i class="icon-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
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

            <div class="modal fade" id="sales_details_modal" tabindex="-1" role="dialog" aria-labelledby="prescriptionDetailsModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Sales Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    Invoice Number: <span id="invoice_number_view"></span>
                                </div>
                                <div class="col-md-6">
                                    Date of Sale: <span id="sale_date_view"></span>
                                </div>
                                <div class="col-md-6">
                                    Customer Name: <span id="customer_name_view"></span>
                                </div>
                                <div class="col-md-6 service_information">
                                    Service Amount: <span id="service_amount_view"></span>
                                </div>
                                <div class="col-md-6 service_information">
                                    Discount: <span id="discount_view"></span>
                                </div>
                                <div class="col-md-6">
                                    Vat: <span id="vat_view"></span>
                                </div>
                                <div class="col-md-6 service_information">
                                    Total Amount: <span id="total_amount_view"></span>
                                </div>
                                <br><br>
                                <div class="col-md-12" id="item_details_view">
                                    <table id="" class="table table-striped table-bordered table-hover data-table focus-table">
                                        <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Discount</th>
                                            <th>Total Value</th>
                                        </tr>
                                        </thead>
                                        <tbody id="sale_detail_item_list">
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

    <div id="print_area" style="display: none">
        <div style="text-align: center;">
            <h1>Grand Auto Service</h1>
            <span>All kind of auto service and products</span> <br>
            <span>Address, Dhaka-0000</span> <br>
            <span>Mob: 01xxxxxxxxx, E-mail: admin@gmail.com</span>
        </div>
        <br><br>
        <div class="row">
            <div style="float:left;margin-left:15px">
                Invoice No: <span id="print_invoice_number_view"></span>
            </div>
            <div style="float:left;margin-left:130px; padding:5px; border:1px solid;border-radius: 25px; background:#000000; color:#FFFFFF">
                Cash Memo/Challan
            </div>
            <div style="float:right;">
                Date: <span id="print_sale_date_view"></span>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div style="margin-left:15px">
                Name: <span id="print_customer_name_view"></span>
            </div>
            <div style="float:left;margin-left:15px">
                Address: <span id="print_customer_address_view"></span>
            </div>
            <div style="float:left;margin-left:15px">
                Phone: <span id="print_customer_phone_view"></span>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-12">
                <table id="" class="table table-striped table-bordered table-hover data-table focus-table">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Discount</th>
                        <th>Total Value</th>
                    </tr>
                    </thead>
                    <tbody id="print_sale_detail_item_list">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- END CONTENT -->
@endsection

@section('js')
    <script>

        function view_details(id){
            var url = "{{ url('sales/get_details') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {sales_id:id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var sales_details = data.sale.details;

                        $('#invoice_number_view').text(data.sale.invoice_number);
                        $('#sale_date_view').text(getFormattedDate(data.sale.date_of_sale,'d/m/Y'));
                        $('#customer_name_view').text(data.sale.first_name+' '+data.sale.last_name);
                        $('#service_amount_view').text(data.sale.service_amount);
                        $('#discount_view').text(parseFloat(data.sale.discount)+'%');
                        $('#vat_view').text(parseFloat(data.sale.vat)+'%');
                        $('#total_amount_view').text(data.sale.total_amount);

                        var html = '';
                        var grant_total_value = 0;
                        $.each(sales_details , function(index, details) {
                            html +='<tr>';
                            html +='<td>'+details.item_name+'</td>';
                            html +='<td>'+details.quantity+'</td>';
                            html +='<td>'+details.unit_price+'</td>';
                            html +='<td>'+(details.discount !== null ? details.discount :'')+'</td>';
                            html +='<td>'+details.total_value+'</td>';
                            html +='</tr>';

                            grant_total_value = grant_total_value+parseFloat(details.total_value);
                        });
                        // For total row in footer
                        html +='<tr>';
                        html +='<td><b>Total</b></td>';
                        html +='<td></td>';
                        html +='<td></td>';
                        html +='<td></td>';
                        html +='<td>'+grant_total_value.toFixed(2)+'</td>';
                        html +='</tr>';

                        $('#sale_detail_item_list').html(html);

                        if(data.sale.sales_type=='product'){
                            $('#item_details_view').show();
                            $('.service_information').hide();
                        }
                        else{
                            $('#item_details_view').hide();
                            $('.service_information').show();
                        }

                        $('#sales_details_modal').modal('show');
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

        function print_sales_invoice(id){
            var url = "{{ url('sales/get_details') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {sales_id:id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var sales_details = data.sale.details;

                        $('#print_invoice_number_view').text(data.sale.invoice_number);
                        $('#print_sale_date_view').text(getFormattedDate(data.sale.date_of_sale,'d/m/Y'));
                        $('#print_customer_name_view').text(data.sale.first_name+''+data.sale.last_name);
                        $('#print_customer_address_view').text(data.sale.customer_address);
                        $('#print_customer_phone_view').text(data.sale.customer_phone);

                        var html = '';
                        var grant_total_value = 0;
                        $.each(sales_details , function(index, details) {
                            html +='<tr>';
                            html +='<td>'+details.item_name+'</td>';
                            html +='<td>'+details.quantity+'</td>';
                            html +='<td>'+details.unit_price+'</td>';
                            html +='<td>'+(details.discount !== null ? details.discount :'')+'</td>';
                            html +='<td>'+details.total_value+'</td>';
                            html +='</tr>';

                            grant_total_value = grant_total_value+parseFloat(details.total_value);
                        });
                        // For total row in footer
                        html +='<tr>';
                        html +='<td><b>Total</b></td>';
                        html +='<td></td>';
                        html +='<td></td>';
                        html +='<td></td>';
                        html +='<td>'+grant_total_value.toFixed(2)+'</td>';
                        html +='</tr>';

                        $('#print_sale_detail_item_list').html(html);

                        $('.page-content-wrapper').hide();
                        $('#print_area').show();
                        window.print();

                        $('.page-content-wrapper').show();
                        $('#print_area').hide();
                        window.close();
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

        function delete_sale(id){
            $(".warning_message").text('Are you sure you delete this sale detail? This can not be undone.');
            $("#warning_modal").modal('show');
            $( "#warning_ok" ).on('click',function() {
                show_loader();
                var url = "{{ url('sales/delete') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {sale_id:id,'_token':'{{csrf_token()}}'},
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#sale_'+id).remove();
                        } else {
                            show_error_message(data.reason);
                        }
                    },
                    error: function(data) {
                        hide_loader();
                        show_error_message(data);
                    }
                });
            });
        }
    </script>
@endsection

