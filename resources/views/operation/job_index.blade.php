@extends('layouts.master')
@section('title', 'Jobs')
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
                        <span>Jobs</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title">
                jobs
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
                                    <h3 class="page-title">All Jobs</h3>

                                    <div class="portlet-body patients-info">
                                        <a href="{{url('jobs/create')}}" class="btn btn-primary"><i class="icon-job"></i>&nbsp; Add Jobs</a>
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
                                            <table id="job_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Job Tracking Number</th>
                                                        <th class="text-center">Job Opening Date</th>
                                                        <th class="text-center">Job Opening Time</th>
                                                        <th class="text-center">Job Category</th>
                                                        <th class="text-center">Job Type</th>
                                                        <th class="text-center">Customer Name</th>
                                                        <th class="text-center">Customer Registration Number</th>
                                                        <th class="text-center">Vehicle Name</th>
                                                        <th class="text-center">Vehicle Model</th>
                                                        <th class="text-center">Vehicle Number</th>
                                                        <th class="text-center">Job Assigned Person</th>
                                                        <th class="text-center">Job Closing Date</th>
                                                        <th class="text-center">Job Closing Time</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($jobs as $key=>$job)
                                                        <tr id="job_{{$job->id}}">
                                                            <td class="text-center">{{$job->tracking_number}}</td>
                                                            <td class="text-center">{{date('d/m/Y',strtotime($job->opening_date))}}</td>
                                                            <td class="text-center">{{$job->opening_time}}</td>
                                                            <td class="text-center">{{$job->job_category_name}}</td>
                                                            <td class="text-center">{{$job->job_type_name}}</td>
                                                            <td class="text-center">{{$job->first_name.' '.$job->last_name}}</td>
                                                            <td class="text-center">{{$job->customer_registration_number}}</td>
                                                            <td class="text-center">{{$job->vehicle_name}}</td>
                                                            <td class="text-center">{{$job->vehicle_model}}</td>
                                                            <td class="text-center">{{$job->vehicle_registration_number}}</td>
                                                            <td class="text-center">{{$job->assigned_person}}</td>
                                                            <td class="text-center">
                                                                @if($job->job_closing_date != '' && $job->job_closing_date != '0000-00-00')
                                                                {{date('d/m/Y',strtotime($job->job_closing_date))}}
                                                                @endif
                                                            </td>
                                                            <td class="text-center">{{$job->job_closing_time}}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-success btn-sm" href="{{url('jobs',$job->id)}}" title="Edit"><i class="icon-pencil"></i></a>
                                                                <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Delete" onclick="delete_job({{$job->id}})"><i class="icon-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            {{-- Pagination --}}
                                            <div class="">
                                                {{ $jobs->appends($_GET)->links() }}
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
        function delete_job(id){
            $(".warning_message").text('Are you sure you delete this job? This can not be undone.');
            $("#warning_modal").modal('show');
            $( "#warning_ok" ).on('click',function() {
                show_loader();
                var url = "{{ url('jobs/delete') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {job_id:id,'_token':'{{csrf_token()}}'},
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#job_'+id).remove();
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

