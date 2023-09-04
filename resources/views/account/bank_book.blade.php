@extends('layouts.master')
@section('title', 'Bank Books')
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
                        <span>Bank Books</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title">
                bank_books
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
                                    <h3 class="page-title">All Bank Books</h3>

                                    <div class="portlet-body patients-info">
                                        <a href="{{url('bank_books/create')}}" class="btn btn-primary"><i class="icon-bank_book"></i>&nbsp; Add Bank Books</a>
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
                                            <table id="bank_book_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Date</th>
                                                        <th class="text-center">Month</th>
                                                        <th class="text-center">Transaction Type</th>
                                                        <th class="text-center">Bank</th>
                                                        <th class="text-center">Account</th>
                                                        <th class="text-center">Cheque Book</th>
                                                        <th class="text-center">Cheque Number</th>
                                                        <th class="text-center">Amount</th>
                                                        <th class="text-center">Party Name</th>
                                                        <th class="text-center">Narration</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($bank_books as $key=>$b_book)
                                                        <tr id="bank_book_{{$b_book->id}}">
                                                            <td class="text-center">{{date('d/m/Y',strtotime($b_book->date))}}</td>
                                                            <td class="text-center">{{date('F/Y',strtotime($b_book->date))}}</td>
                                                            <td class="text-center">{{$b_book->transaction_type}}</td>
                                                            <td class="text-center">{{$b_book->bank_name}}</td>
                                                            <td class="text-center">{{$b_book->account_number}}</td>
                                                            <td class="text-center">{{$b_book->cheque_book_number}}</td>
                                                            <td class="text-center">{{$b_book->cheque_number}}</td>
                                                            <td class="text-center">{{number_format($b_book->amount, 2, '.', ',')}}</td>
                                                            <td class="text-center">{{$b_book->party_name}}</td>
                                                            <td class="text-center">{{$b_book->narration}}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-success btn-sm" href="{{url('bank_books',$b_book->id)}}" title="Edit"><i class="icon-pencil"></i></a>
                                                                <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Delete" onclick="delete_bank_book({{$b_book->id}})"><i class="icon-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            {{-- Pagination --}}
                                            <div class="">
                                                {{ $bank_books->appends($_GET)->links() }}
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
        function delete_bank_book(id){
            $(".warning_message").text('Are you sure you delete this bank book? This can not be undone.');
            $("#warning_modal").modal('show');
            $( "#warning_ok" ).on('click',function() {
                show_loader();
                var url = "{{ url('bank_books/delete') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {bank_book_id:id,'_token':'{{csrf_token()}}'},
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#bank_book_'+id).remove();
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

