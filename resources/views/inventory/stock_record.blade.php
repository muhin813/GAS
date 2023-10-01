@extends('layouts.master')
@section('title', 'Stock Records')
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
                        <span>Stock Records</span>
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
                                    <h3 class="page-title">All Stock Records</h3>
                                    <h3 class="page-title">Total Amount: <span id="total_balance_amount"></span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet light ">
                        <div class="row">
                            <div class="col-md-10">
                                <form id="search_form" method="get" action="">
                                    <div class="col-md-2">
                                        <div class="form-group mb-0">
                                            <select name="month" id="month" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                                                <option value="">Select Month</option>
                                                <option value="1" @if(request('month')==1) selected @endif>January</option>
                                                <option value="2" @if(request('month')==2) selected @endif>February</option>
                                                <option value="3" @if(request('month')==3) selected @endif>March</option>
                                                <option value="4" @if(request('month')==4) selected @endif>April</option>
                                                <option value="5" @if(request('month')==5) selected @endif>May</option>
                                                <option value="6" @if(request('month')==6) selected @endif>June</option>
                                                <option value="7" @if(request('month')==7) selected @endif>July</option>
                                                <option value="8" @if(request('month')==8) selected @endif>August</option>
                                                <option value="9" @if(request('month')==9) selected @endif>September</option>
                                                <option value="10" @if(request('month')==10) selected @endif>October</option>
                                                <option value="11" @if(request('month')==11) selected @endif>November</option>
                                                <option value="12" @if(request('month')==12) selected @endif>December</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-0">
                                            <select name="item_id" id="item_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                                                <option value="">Select Item</option>
                                                @foreach($items as $item)
                                                    <option value="{{$item->id}}" @if($item->id==request('item_id')) selected @endif>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-0">
                                            <select name="supplier_id" id="supplier_id" class="form-control selectpicker" data-show-subtext="true" data-live-search="true">
                                                <option value="">Select Supplier</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{$supplier->id}}" @if($supplier->id==request('supplier_id')) selected @endif>{{$supplier->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select name="challan_no" id="challan_no" class="form-control">
                                                <option value="">Select Challan No.</option>
                                                @foreach($all_purchases as $purchase)
                                                    <option value="{{$purchase->challan_no}}" @if($purchase->challan_no==request('challan_no')) selected @endif>{{$purchase->challan_no}}</option>
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
                            <div class="col-md-2">
                                <a href="{{url('stock_record')}}" class="btn btn-success">Clear Filter</a>
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
                                                        <th class="text-center">Item Description</th>
                                                        <th class="text-center">Supplier Name</th>
                                                        <th class="text-center">Item Qty</th>
                                                        <th class="text-center">Balance Qty</th>
                                                        <th class="text-center">Item UOM</th>
                                                        <th class="text-center">Package</th>
                                                        <th class="text-center">Package UOM</th>
                                                        <th class="text-center">Invoice/Challan</th>
                                                        <th class="text-center">Unit Price</th>
                                                        <th class="text-center">Total Value</th>
                                                        <th class="text-center">Value of Balance Quantity</th>
                                                        <th class="text-center">Ageing</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $total_value_balance_quantity = 0;
                                                        foreach($purchases as $key=>$purchase) {
                                                        $inventory_age = \App\Common::getDateDiffDays(date('Y-m-d'),$purchase->date_of_purchase);
                                                        $value_balance_quantity = $purchase->balance_quantity*$purchase->unit_price;
                                                        $total_value_balance_quantity = $total_value_balance_quantity+$value_balance_quantity;
                                                    ?>
                                                        <tr id="purchase_{{$purchase->id}}">
                                                            <td class="text-center">{{$purchase->category_name}}</td>
                                                            <td class="text-center">{{date('d/m/Y',strtotime($purchase->date_of_purchase))}}</td>
                                                            <td class="text-center">{{date('M/Y',strtotime($purchase->date_of_purchase))}}</td>
                                                            <td class="text-center">{{$purchase->item_name}}</td>
                                                            <td class="text-center">{{$purchase->item_description}}</td>
                                                            <td class="text-center">{{$purchase->supplier_name}}</td>
                                                            <td class="text-center">{{$purchase->quantity}}</td>
                                                            <td class="text-center">{{$purchase->balance_quantity}}</td>
                                                            <td class="text-center">{{$purchase->item_uom}}</td>
                                                            <td class="text-center">{{$purchase->package}}</td>
                                                            <td class="text-center">{{$purchase->package_uom}}</td>
                                                            <td class="text-center">{{$purchase->challan_no}}</td>
                                                            <td class="text-center">{{$purchase->unit_price}}</td>
                                                            <td class="text-center">{{$purchase->total_value}}</td>
                                                            <td class="text-center">{{$value_balance_quantity}}</td>
                                                            <td class="text-center">{{$inventory_age}} Days</td>
                                                        </tr>
                                                    <?php } ?>
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
        $(document).ready(function(){
            $('#total_balance_amount').text('{{$total_value_balance_quantity}}');
        });
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

