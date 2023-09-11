@extends('layouts.master')
@section('title', 'Customers')
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
                        <span>Customers</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title">
                customers
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
                                    <h3 class="page-title">All Customers</h3>

                                    <div class="portlet-body patients-info">
                                        <a href="{{url('customers/create')}}" class="btn btn-primary"><i class="icon-plus"></i>&nbsp; Add Customer</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="portlet light ">
                        <div class="row">
                            <div class="col-md-8">
                                <form id="search_form" method="get" action="">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{request('name')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="registration_number" id="registration_number" placeholder="Registration Number" value="{{request('registration_number')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="{{request('phone')}}">
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
                                <a href="{{url('customers')}}" class="btn btn-success">Clear Filter</a>
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
                                            <table id="customer_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Customer Name</th>
                                                        <th class="text-center">Registration Date</th>
                                                        <th class="text-center">GAS Registration Number</th>
                                                        <th class="text-center">Phone</th>
                                                        <th class="text-center">Email</th>
                                                        <th class="text-center">Address</th>
                                                        <th class="text-center">Number of Vehicle</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($customers as $key=>$customer)
                                                        <tr id="customer_{{$customer->id}}">
                                                            <td class="text-center">{{$customer->first_name." ".$customer->last_name}}</td>
                                                            <td class="text-center">{{date('d/m/Y',strtotime($customer->created_at))}}</td>
                                                            <td class="text-center">{{$customer->registration_number}}</td>
                                                            <td class="text-center">{{$customer->phone}}</td>
                                                            <td class="text-center">{{$customer->email}}</td>
                                                            <td class="text-center">{{$customer->address}}</td>
                                                            <td class="text-center">
                                                                {{count($customer->vehicles)}}
                                                                <a class="btn btn-info btn-sm" href="javascript:void(0)" title="View" onclick="view_vehicles({{$customer->id}})"><i class="icon-eye"></i></a>
                                                            </td>
                                                            <td class="text-center">
                                                                <a class="btn btn-success btn-sm" href="{{url('customers',$customer->id)}}" title="Edit"><i class="icon-pencil"></i></a>
                                                                <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Delete" onclick="delete_customer({{$customer->id}})"><i class="icon-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            {{-- Pagination --}}
                                            <div class="">
                                                {{ $customers->appends($_GET)->links() }}
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

        <div class="modal fade" id="vehicle_list_model" tabindex="-1" role="dialog" aria-labelledby="prescriptionDetailsModalTitle" aria-hidden="true">
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
                            <div class="col-md-12">
                                <table id="" class="table table-striped table-bordered table-hover data-table focus-table">
                                    <thead>
                                    <tr>
                                        <th>Vehicle Name</th>
                                        <th>Vehicle Model</th>
                                        <th>Vehicle Registration Number</th>
                                    </tr>
                                    </thead>
                                    <tbody id="vehicle_list">
                                    <tr>
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

        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
@endsection

@section('js')
    <script>
        function view_vehicles(id){
            var url = "{{ url('customers/get_vehicles') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {customer_id:id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var vehicles = data.vehicles;

                        var html = '';
                        $.each(vehicles , function(index, vehicle) {
                            html +='<tr>';
                            html +='<td>'+vehicle.name+'</td>';
                            html +='<td>'+vehicle.model+'</td>';
                            html +='<td>'+vehicle.registration_number+'</td>';
                            html +='</tr>';
                        });

                        $('#vehicle_list').html(html);

                        $('#vehicle_list_model').modal('show');
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

        function delete_customer(id){
            $(".warning_message").text('Are you sure you delete this customer? This can not be undone.');
            $("#warning_modal").modal('show');
            $( "#warning_ok" ).on('click',function() {
                show_loader();
                var url = "{{ url('customers/delete') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {customer_id:id,'_token':'{{csrf_token()}}'},
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#customer_'+id).remove();
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

