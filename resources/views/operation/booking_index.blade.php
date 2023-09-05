@extends('layouts.master')
@section('title', 'Bookings')
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
                        <span>Bookings</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title">
                bookings
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
                                    <h3 class="page-title">All Bookings</h3>
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
                                            <table id="booking_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Booking Reference Number</th>
                                                        <th class="text-center">Service Category</th>
                                                        <th class="text-center">Service Type</th>
                                                        <th class="text-center">Booking Date</th>
                                                        <th class="text-center">Booking Time</th>
                                                        <th class="text-center">Customer Name</th>
                                                        <th class="text-center">Customer Phone Number</th>
                                                        <th class="text-center">Vehicle Name</th>
                                                        <th class="text-center">Vehicle Model</th>
                                                        <th class="text-center">Special Note</th>
                                                        <th class="text-center">Emergency</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($bookings as $key=>$booking)
                                                        <tr id="booking_{{$booking->id}}">
                                                            <td class="text-center">{{$booking->booking_number}}</td>
                                                            <td class="text-center">{{$booking->service_category}}</td>
                                                            <td class="text-center">{{$booking->service_type}}</td>
                                                            <td class="text-center">
                                                                @if($booking->booking_date != '')
                                                                {{date('d/m/Y', strtotime($booking->booking_date))}}
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if($booking->booking_date != '')
                                                                {{date('h:i:s a', strtotime($booking->booking_date))}}
                                                                @endif
                                                            </td>
                                                            <td class="text-center">{{$booking->first_name." ".$booking->last_name}}</td>
                                                            <td class="text-center">{{$booking->phone}}</td>
                                                            <td class="text-center">{{$booking->vehicle_name}}</td>
                                                            <td class="text-center">{{$booking->vehicle_model}}</td>
                                                            <td class="text-center">{{$booking->special_note}}</td>
                                                            <td class="text-center">{{$booking->emergency}}</td>
                                                            <td class="text-center">{{$booking->confirmation_status}}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-success btn-sm" href="{{url('bookings',$booking->id)}}" title="Update Booking Status"><i class="icon-pencil"></i></a>
                                                                <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Delete" onclick="delete_booking({{$booking->id}})"><i class="icon-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            {{-- Pagination --}}
                                            <div class="">
                                                {{ $bookings->appends($_GET)->links() }}
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
        function delete_booking(id){
            $(".warning_message").text('Are you sure you delete this Booking? This can not be undone.');
            $("#warning_modal").modal('show');
            $( "#warning_ok" ).on('click',function() {
                show_loader();
                var url = "{{ url('bookings/delete') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {booking_id:id,'_token':'{{csrf_token()}}'},
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#booking_'+id).remove();
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

