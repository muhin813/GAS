@extends('layouts.master')
@section('title', 'Customer Payments')
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
                        <span>Customer Payments</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title">
                customer_payments
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
                                    <h3 class="page-title">All Customer Payments</h3>

                                    <div class="portlet-body patients-info">
                                        <a href="{{url('customer_payments/create')}}" class="btn btn-primary"><i class="icon-customer_payment"></i>&nbsp; Add Customer Payments</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet light ">
                        <div class="row">
                            <div class="col-md-8">
                                <form id="search_form" method="get" action="">
                                    <div class="col-md-5">
                                        <div class="form-group mb-0">
                                            <select name="invoice_number" id="invoice_number" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                                                <option value="">Select Invoice No.</option>
                                                @foreach($sales as $sale)
                                                    <option value="{{$sale->invoice_number}}" @if($sale->invoice_number==request('invoice_number')) selected @endif>{{$sale->invoice_number}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-0">
                                            <select name="customer_id" id="customer_id" class="form-control">
                                                <option value="">Select customer</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{$customer->id}}" @if($customer->id==request('customer_id')) selected @endif>{{$customer->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-0">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <a href="{{url('customer_payments')}}" class="btn btn-success">Clear Filter</a>
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
                                            <table id="customer_payment_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Invoice Number</th>
                                                        <th class="text-center">Customer Name</th>
                                                        <th class="text-center">Total Value</th>
                                                        <th class="text-center">Receive Amount</th>
<!--                                                        <th class="text-center">Due Amount</th>-->
                                                        <th class="text-center">Receive Date</th>
                                                        <th class="text-center">Month/Year</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($customer_payments as $key=>$c_payment)
                                                        <tr id="customer_payment_{{$c_payment->id}}">
                                                            <td class="text-center">{{$c_payment->invoice_number}}</td>
                                                            <td class="text-center">{{$c_payment->customer_name}}</td>
                                                            <td class="text-center">{{number_format($c_payment->total_value, 2, '.', ',')}}</td>
                                                            <td class="text-center">{{number_format($c_payment->received_amount, 2, '.', ',')}}</td>
<!--                                                            <td class="text-center">{{$c_payment->due_amount}}</td>-->
                                                            <td class="text-center">{{date('d/m/Y',strtotime($c_payment->payment_date))}}</td>
                                                            <td class="text-center">{{date('F/Y',strtotime($c_payment->payment_date))}}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-success btn-sm" href="{{url('customer_payments',$c_payment->id)}}" title="Edit"><i class="icon-pencil"></i></a>
                                                                <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Delete" onclick="delete_customer_payment({{$c_payment->id}})"><i class="icon-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            {{-- Pagination --}}
                                            <div class="">
                                                {{ $customer_payments->appends($_GET)->links() }}
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

        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
@endsection

@section('js')
    <script>
        function delete_customer_payment(id){
            $(".warning_message").text('Are you sure you delete this customer payment? This can not be undone.');
            $("#warning_modal").modal('show');
            $( "#warning_ok" ).on('click',function() {
                show_loader();
                var url = "{{ url('customer_payments/delete') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {customer_payment_id:id,'_token':'{{csrf_token()}}'},
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#customer_payment_'+id).remove();
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

