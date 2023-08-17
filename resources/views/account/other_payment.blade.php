@extends('layouts.master')
@section('title', 'Other Payments')
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
                        <span>Other Payments</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title">
                other_payments
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
                                    <h3 class="page-title">All Other Payments</h3>

                                    <div class="portlet-body patients-info">
                                        <a href="{{url('other_payments/create')}}" class="btn btn-primary"><i class="icon-other_payment"></i>&nbsp; Add Other Payments</a>
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
                                            <table id="other_payment_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Date of Payment</th>
                                                        <th class="text-center">Payment Month</th>
                                                        <th class="text-center">Purpose of Payment</th>
                                                        <th class="text-center">Type</th>
                                                        <th class="text-center">Amount</th>
                                                        <th class="text-center">Payment Mode</th>
                                                        <th class="text-center">Voucher Number</th>
                                                        <th class="text-center">Remarks</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($other_payments as $key=>$o_payment)
                                                        <tr id="other_payment_{{$o_payment->id}}">
                                                            <td class="text-center">{{date('d/m/Y',strtotime($o_payment->payment_date))}}</td>
                                                            <td class="text-center">{{date('F/Y',strtotime($o_payment->payment_date))}}</td>
                                                            <td class="text-center">{{$o_payment->purpose_of_payment}}</td>
                                                            <td class="text-center">{{$o_payment->payment_type}}</td>
                                                            <td class="text-center">{{$o_payment->amount}}</td>
                                                            <td class="text-center">{{$o_payment->payment_mode}}</td>
                                                            <td class="text-center">{{$o_payment->voucher_number}}</td>
                                                            <td class="text-center">{{$o_payment->remarks}}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-success btn-sm" href="{{url('other_payments',$o_payment->id)}}" title="Edit"><i class="icon-pencil"></i></a>
                                                                <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Delete" onclick="delete_other_payment({{$o_payment->id}})"><i class="icon-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            {{-- Pagination --}}
                                            <div class="">
                                                {{ $other_payments->appends($_GET)->links() }}
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
        function delete_other_payment(id){
            $(".warning_message").text('Are you sure you delete this other_payment? This can not be undone.');
            $("#warning_modal").modal('show');
            $( "#warning_ok" ).on('click',function() {
                show_loader();
                var url = "{{ url('other_payments/delete') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {other_payment_id:id,'_token':'{{csrf_token()}}'},
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#other_payment_'+id).remove();
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

