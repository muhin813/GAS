@extends('layouts.master')
@section('title', 'Stock Issues')
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
                        <span>Stock Issues</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title">
                stock_issues
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
                                    <h3 class="page-title">All Stock Issues</h3>

                                    <div class="portlet-body patients-info">
                                        <a href="{{url('stock_issues/create')}}" class="btn btn-primary"><i class="icon-plus"></i>&nbsp; Add Stock Issue</a>
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
                                            <table id="stock_issue_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Date of Issue</th>
                                                        <th class="text-center">Issue Month</th>
                                                        <th class="text-center">Supplier Invoice Number</th>
                                                        <th class="text-center">Item Name</th>
                                                        <th class="text-center">Item UOM</th>
                                                        <th class="text-center">Item Qty</th>
                                                        <th class="text-center">Unit Price</th>
                                                        <th class="text-center">Total Value</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($stock_issues as $key=>$stock_issue)
                                                        <tr id="stock_issue_{{$stock_issue->id}}">
                                                            <td class="text-center">{{date('d/m/Y',strtotime($stock_issue->date_of_issue))}}</td>
                                                            <td class="text-center">{{date('M/Y',strtotime($stock_issue->date_of_issue))}}</td>
                                                            <td class="text-center">{{$stock_issue->supplier_invoice_number}}</td>
                                                            <td class="text-center">{{$stock_issue->item_name}}</td>
                                                            <td class="text-center">{{$stock_issue->item_uom}}</td>
                                                            <td class="text-center">{{$stock_issue->quantity}}</td>
                                                            <td class="text-center">{{$stock_issue->unit_price}}</td>
                                                            <td class="text-center">{{$stock_issue->total_value}}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-success btn-sm" href="{{url('stock_issues',$stock_issue->id)}}" title="Edit"><i class="icon-pencil"></i></a>
                                                                <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Delete" onclick="delete_stock_issue({{$stock_issue->id}})"><i class="icon-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            {{-- Pagination --}}
                                            <div class="">
                                                {{ $stock_issues->appends($_GET)->links() }}
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
        function delete_stock_issue(id){
            $(".warning_message").text('Are you sure you delete this issue detail? This can not be undone.');
            $("#warning_modal").modal('show');
            $( "#warning_ok" ).on('click',function() {
                show_loader();
                var url = "{{ url('stock_issues/delete') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {stock_issue_id:id,'_token':'{{csrf_token()}}'},
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#stock_issue_'+id).remove();
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

