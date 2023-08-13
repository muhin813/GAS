@extends('layouts.customer_master')
@section('title', 'Packages')
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
                        <span>Packages</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title">
                packages
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
                                    <h3 class="page-title">All Packages</h3>
                                    @if(Session::get('role') == 4) {{-- If user is a customer--}}
                                    <span>Please contact in hotline number for package booking by mentioning the package ID</span>
                                    @endif

                                    <div class="portlet-body patients-info">
                                        @if(Session::get('role') != 4) {{-- If user is not a customer--}}
                                        <a href="{{url('packages/create')}}" class="btn btn-primary"><i class="icon-plus"></i>&nbsp; Add Package</a>
                                        @endif
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
                                            <table id="package_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Vehicle Name</th>
                                                        <th class="text-center">Package Price</th>
                                                        <th class="text-center">Package Validity</th>
                                                        <th class="text-center">Package ID</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($packages as $key=>$package)
                                                        <tr id="package_{{$package->id}}">
                                                            <td class="text-center">{{$package->name}}</td>
                                                            <td class="text-center">{{$package->vehicle_name}}</td>
                                                            <td class="text-center">{{$package->package_price}}</td>
                                                            <td class="text-center">{{date('d/m/Y',strtotime($package->package_validity))}}</td>
                                                            <td class="text-center">{{$package->package_id}}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-info btn-sm" href="javascript:void(0)" title="View Details" onclick="view_package_details({{$package->id}})"><i class="icon-eye"></i></a>
                                                                @if(Session::get('role') != 4) {{-- If user is not a customer--}}
                                                                <a class="btn btn-success btn-sm" href="{{url('packages',$package->id)}}" title="Edit"><i class="icon-pencil"></i></a>
                                                                <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Delete" onclick="delete_package({{$package->id}})"><i class="icon-trash"></i></a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            {{-- Pagination --}}
                                            <div class="">
                                                {{ $packages->appends($_GET)->links() }}
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

        <div class="modal fade" id="package_detail_model" tabindex="-1" role="dialog" aria-labelledby="prescriptionDetailsModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Package Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                Package ID: <span id="package_id"></span>
                            </div>
                            <div class="col-md-12" id="package_detail_list">

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
        function view_package_details(id){
            var url = "{{ url('packages/get_details') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {package_id:id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var package_details = data.package.details;
                        var package_benefits = data.package.benefits;
                        $('#package_id').text(data.package.package_id);

                        var html = '<table id="" class="table table-striped table-bordered table-hover data-table focus-table">';
                        html +='<tbody>';

                            $.each(package_details , function(index, detail) {
                                var sub_details = detail.sub_details;
                                html +='<tr>';
                                html +='<td>'+detail.description+'</td>';
                                html +='<td>';
                                $.each(sub_details , function(index2, sub_detail) {
                                    html += (index2+1)+". "+sub_detail.description + '<br>';
                                });
                                html +='</td>';
                                html +='</tr>';
                            });

                        html +='</tbody>';
                        html +='</table>';

                        //Generating benefit table
                        html += '<table id="" class="table table-striped table-bordered table-hover data-table">';
                        html +='<tbody>';
                            html +='<tr>';
                                html +='<th>Package Benefits and Features</th>';
                            html +='</tr>';
                            $.each(package_benefits , function(index3, package_benefit) {
                                html +='<tr>';
                                    html += '<td>' + (index3+1)+". "+package_benefit.description + '</td>';
                                html +='</tr>';
                            });
                        html +='</tbody>';
                        html +='</table>';

                        $('#package_detail_list').html(html);

                        $('#package_detail_model').modal('show');
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

        function delete_package(id){
            $(".warning_message").text('Are you sure you delete this package detail? This can not be undone.');
            $("#warning_modal").modal('show');
            $( "#warning_ok" ).on('click',function() {
                show_loader();
                var url = "{{ url('packages/delete') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {package_id:id,'_token':'{{csrf_token()}}'},
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#package_'+id).remove();
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

