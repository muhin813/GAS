@extends('layouts.master')
@section('title', 'Purchases')
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
                        <span>Purchases</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title">
                purchases
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
                                    <h3 class="page-title">All Purchases</h3>

                                    <div class="portlet-body patients-info">
                                        <a href="{{url('purchases/create')}}" class="btn btn-primary"><i class="icon-plus"></i>&nbsp; Add Purchase</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet light ">
                        <div class="row">
                            <div class="col-md-8">
                                <form id="search_form" method="get" action="">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="item" id="item" class="form-control">
                                                <option value="">Select Item</option>
                                                @foreach($items as $item)
                                                    <option value="{{$item->id}}" @if($item->id==request('item')) selected @endif>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="supplier" id="supplier" class="form-control">
                                                <option value="">Select Supplier</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{$supplier->id}}" @if($supplier->id==request('supplier')) selected @endif>{{$supplier->name}}</option>
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
                                <a href="{{url('purchases')}}" class="btn btn-success">Clear Filter</a>
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
                                            <table id="purchase_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Item Category</th>
                                                        <th class="text-center">Date of Purchase</th>
                                                        <th class="text-center">Purchase Month</th>
                                                        <th class="text-center">Item Name</th>
                                                        <th class="text-center">Supplier Name</th>
                                                        <th class="text-center">Item Qty</th>
                                                        <th class="text-center">Item UOM</th>
                                                        <th class="text-center">Package</th>
                                                        <th class="text-center">Package UOM</th>
                                                        <th class="text-center">Invoice/Challan</th>
                                                        <th class="text-center">Unit Price</th>
                                                        <th class="text-center">Total Value</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($purchases as $key=>$purchase)
                                                        <tr id="purchase_{{$purchase->id}}">
                                                            <td class="text-center">{{$purchase->category_name}}</td>
                                                            <td class="text-center">{{date('d/m/Y',strtotime($purchase->date_of_purchase))}}</td>
                                                            <td class="text-center">{{date('M/Y',strtotime($purchase->date_of_purchase))}}</td>
                                                            <td class="text-center">{{$purchase->item_name}}</td>
                                                            <td class="text-center">{{$purchase->supplier_name}}</td>
                                                            <td class="text-center">{{$purchase->quantity}}</td>
                                                            <td class="text-center">{{$purchase->item_uom}}</td>
                                                            <td class="text-center">{{$purchase->package}}</td>
                                                            <td class="text-center">{{$purchase->package_uom}}</td>
                                                            <td class="text-center">{{$purchase->challan_no}}</td>
                                                            <td class="text-center">{{$purchase->unit_price}}</td>
                                                            <td class="text-center">{{$purchase->total_value}}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-success btn-sm" href="{{url('purchases',$purchase->id)}}" title="Edit"><i class="icon-pencil"></i></a>
                                                                <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Delete" onclick="delete_purchase({{$purchase->id}})"><i class="icon-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            {{-- Pagination --}}
                                            <div class="">
                                                {{ $purchases->appends($_GET)->links() }}
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
        function delete_purchase(id){
            $(".warning_message").text('Are you sure you delete this purchase detail? This can not be undone.');
            $("#warning_modal").modal('show');
            $( "#warning_ok" ).on('click',function() {
                show_loader();
                var url = "{{ url('purchases/delete') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {purchase_id:id,'_token':'{{csrf_token()}}'},
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#purchase_'+id).remove();
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

