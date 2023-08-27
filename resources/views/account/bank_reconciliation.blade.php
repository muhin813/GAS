@extends('layouts.master')
@section('title', 'Bank Reconciliations')
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
                        <span>Bank Reconciliations</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title">
                monthly_salary_statements
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
                                    <h3 class="page-title">Bank Reconciliations</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet light ">
                        <div class="row">
                            <div class="col-md-8">
                                <form id="search_form" method="get" action="">
                                    <div class="col-md-3">
                                        <div class="form-group mb-0">
                                            <select name="year" id="year" class="form-control" required>
                                                <option value="">Select Year</option>
                                                @for($year=date('Y'); $year>=2020; $year--)
                                                    <option value="{{$year}}" @if($year==request('year')) selected @endif>{{$year}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-0">
                                            <select name="month" id="month" class="form-control" required>>
                                                <option value="">Select Month</option>
                                                @foreach($months as $key=>$month)
                                                <option value="{{$key+1}}" @if(($key+1)==request('month')) selected @endif>{{$month}}</option>
                                                        @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-0">
                                            <button type="submit" class="btn btn-primary">Generate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <a href="{{url('bank_reconciliations')}}" class="btn btn-success">Clear Filter</a>
                                <a href="{{url('bank_reconciliations/create')}}" class="btn btn-primary"><i class="icon-bank_book"></i>Add New</a>
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
                                            <table id="monthly_salary_statement_table" class="table table-striped table-bordered data-table">
                                                <thead>
                                                <tr>
                                                    <th colspan="2" class="text-center">
                                                        BANK RECONCILIATION STATEMENT Month of
                                                        @if(!empty($bank_reconciliations))
                                                            {{$months[request('month')-1]." ".request('year')}}
                                                            <a style="float: right" href="{{url('bank_reconciliations/'.$bank_reconciliations->id)}}" class="btn btn-success"><i class="icon-bank_book"></i>Edit</a>
                                                        @endif
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" class="text-center">
                                                        @if(!empty($bank_reconciliations))
                                                            {{$bank_reconciliations->bank_name}}
                                                        @endif
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2" class="text-center">
                                                        @if(!empty($bank_reconciliations))
                                                        {{$bank_reconciliations->account_number}}
                                                        @endif
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">Statement Date</th>
                                                    <th class="text-center">
                                                        @if(!empty($bank_reconciliations))
                                                        {{$months[request('month')-1]}}
                                                        @endif
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="text-center">Closing Balance Bank Statement</td>
                                                    <td class="text-center">@if(!empty($bank_reconciliations)){{$bank_reconciliations->bank_statement_closing_balance}}@endif</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Closing Balance Bank Book</td>
                                                    <td class="text-center">@if(!empty($bank_reconciliations)){{$bank_reconciliations->closing_balance_bank_book}}@endif</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Opening Variance</td>
                                                    <td class="text-center">@if(!empty($bank_reconciliations)){{$bank_reconciliations->opening_variance}}@endif</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0)" @if(!empty($bank_reconciliations)) onclick="view_outstanding_cheques({{$bank_reconciliations->id}})" @endif>Less: Outstanding Cheques</a>
                                                    </td>
                                                    <td class="text-center">@if(!empty($bank_reconciliations)){{$bank_reconciliations->outstanding_cheque_amount}}@endif</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0)" @if(!empty($bank_reconciliations)) onclick="view_outstanding_deposits({{$bank_reconciliations->id}})" @endif>Add: Outstanding Deposits</a>
                                                    </td>
                                                    <td class="text-center">@if(!empty($bank_reconciliations)){{$bank_reconciliations->outstanding_deposit_amount}}@endif</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0)" @if(!empty($bank_reconciliations)) onclick="view_other_payments({{$bank_reconciliations->id}})" @endif>Less: Other Payments</a>
                                                    </td>
                                                    <td class="text-center">@if(!empty($bank_reconciliations)){{$bank_reconciliations->other_payment_amount}}@endif</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0)" @if(!empty($bank_reconciliations)) onclick="view_other_deposits({{$bank_reconciliations->id}})" @endif>Add: Other Deposits</a>
                                                    </td>
                                                    <td class="text-center">@if(!empty($bank_reconciliations)){{$bank_reconciliations->other_deposit_amount}}@endif</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Closing Balance Bank Book</td>
                                                    <td class="text-center">@if(!empty($bank_reconciliations)) @endif</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Closing Variance</td>
                                                    <td class="text-center">@if(!empty($bank_reconciliations)) @endif</td>
                                                </tr>
                                                </tbody>
                                            </table>
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

            <div class="modal fade" id="outstanding_cheques_modal" tabindex="-1" role="dialog" aria-labelledby="prescriptionDetailsModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Outstanding Cheques</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-hover data-table focus-table">
                                        <thead>
                                        <tr>
                                            <th>Cheque Number</th>
                                            <th>Amount</th>
                                        </tr>
                                        </thead>

                                        <tbody id="outstanding_cheque_list">

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

            <div class="modal fade" id="outstanding_deposits_modal" tabindex="-1" role="dialog" aria-labelledby="prescriptionDetailsModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Outstanding Deposits</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-hover data-table focus-table">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Nature Of Deposit</th>
                                            <th>Amount</th>
                                            <th>Narration</th>
                                        </tr>
                                        </thead>

                                        <tbody id="outstanding_deposit_list">

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

            <div class="modal fade" id="other_payments_modal" tabindex="-1" role="dialog" aria-labelledby="prescriptionDetailsModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Other Payments</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-hover data-table focus-table">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Nature of Adjustment</th>
                                            <th>Amount</th>
                                            <th>Narration</th>
                                        </tr>
                                        </thead>

                                        <tbody id="other_payment_list">

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

            <div class="modal fade" id="other_deposits_modal" tabindex="-1" role="dialog" aria-labelledby="prescriptionDetailsModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Other Deposits</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-hover data-table focus-table">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Nature of Adjustment</th>
                                            <th>Amount</th>
                                            <th>Narration</th>
                                        </tr>
                                        </thead>

                                        <tbody id="other_deposit_list">

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
    <!-- END CONTENT -->
@endsection

@section('js')
    <script>
        function view_outstanding_cheques(id){
            var url = "{{ url('bank_reconciliations/get_details') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {id:id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var outstanding_cheques = data.bank_reconciliation.outstanding_cheques.split(',');
                        var html = '';
                        $.each(outstanding_cheques, function( index, out_cheque ) {
                            var cheque_data = out_cheque.split('#');
                            html += '<tr>';
                            html += '<td>'+cheque_data[0]+'</td>';
                            html += '<td>'+cheque_data[1]+'</td>';
                            html += '</tr>';
                        });
                        $('#outstanding_cheque_list').html(html);
                        $('#outstanding_cheques_modal').modal('show');
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

        function view_outstanding_deposits(id){
            var url = "{{ url('bank_reconciliations/get_details') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {id:id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var outstanding_deposits = jQuery.parseJSON( data.bank_reconciliation.outstanding_deposits );;
                        var html = '';
                        $.each(outstanding_deposits, function( index, out_deposit ) {
                            html += '<tr>';
                            html += '<td>'+out_deposit.date+'</td>';
                            html += '<td>'+out_deposit.nature+'</td>';
                            html += '<td>'+out_deposit.amount+'</td>';
                            html += '<td>'+out_deposit.narration+'</td>';
                            html += '</tr>';
                        });
                        $('#outstanding_deposit_list').html(html);
                        $('#outstanding_deposits_modal').modal('show');
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

        function view_other_payments(id){
            var url = "{{ url('bank_reconciliations/get_details') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {id:id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var other_payments = jQuery.parseJSON( data.bank_reconciliation.other_payments );;
                        var html = '';
                        $.each(other_payments, function( index, other_payment ) {
                            html += '<tr>';
                            html += '<td>'+other_payment.date+'</td>';
                            html += '<td>'+other_payment.nature_of_adjustment+'</td>';
                            html += '<td>'+other_payment.amount+'</td>';
                            html += '<td>'+other_payment.narration+'</td>';
                            html += '</tr>';
                        });
                        $('#other_payment_list').html(html);
                        $('#other_payments_modal').modal('show');
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

        function view_other_deposits(id){
            var url = "{{ url('bank_reconciliations/get_details') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {id:id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var other_deposits = jQuery.parseJSON( data.bank_reconciliation.other_deposits );;
                        var html = '';
                        $.each(other_deposits, function( index, other_deposit ) {
                            html += '<tr>';
                            html += '<td>'+other_deposit.date+'</td>';
                            html += '<td>'+other_deposit.nature_of_adjustment+'</td>';
                            html += '<td>'+other_deposit.amount+'</td>';
                            html += '<td>'+other_deposit.narration+'</td>';
                            html += '</tr>';
                        });
                        $('#other_deposit_list').html(html);
                        $('#other_deposits_modal').modal('show');
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
    </script>
@endsection

