@extends('layouts.master')
@section('title', 'Job wise time duration tracking')
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
                        <span>Job wise time duration tracking</span>
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
                                    <h3 class="page-title">All Job wise time duration tracking</h3>
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
                                            <select name="job_category" id="job_category" class="form-control">
                                                <option value="">Select Job Category</option>
                                                @foreach($service_categories as $s_category)
                                                    <option value="{{$s_category->id}}" @if($s_category->id==request('job_category')) selected @endif>{{$s_category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="job_type" id="job_type" class="form-control">
                                                <option value="">Select Job Type</option>
                                                @foreach($service_types as $s_type)
                                                    <option value="{{$s_type->id}}" @if($s_type->id==request('job_type')) selected @endif>{{$s_type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="tracking_number" id="tracking_number" placeholder="Tracking Number" value="{{request('tracking_number')}}">
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
                                <a href="{{url('job_duration_trackings')}}" class="btn btn-success">Clear Filter</a>
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
                                                        <th class="text-center">Job Opening Date</th>
                                                        <th class="text-center">Job Opening Time</th>
                                                        <th class="text-center">Job Category</th>
                                                        <th class="text-center">Job Type</th>
                                                        <th class="text-center">Customer Name</th>
                                                        <th class="text-center">Job Assigned Person</th>
                                                        <th class="text-center">Job Closing Time</th>
                                                        <th class="text-center">Time Taken</th>
                                                        <th class="text-center">Job Tracking Number</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach($jobs as $key=>$job){
                                                        if($job->job_closing_date != '' && $job->job_closing_date != '0000-00-00 00:00:00'){
                                                            $datediff = strtotime($job->job_closing_date) - strtotime($job->opening_time);
                                                            $time_taken = round($datediff / (60 * 60 * 24)).' Days';
                                                        }
                                                        else{
                                                            $time_taken = '';
                                                        }

                                                    ?>
                                                        <tr id="job_{{$job->id}}">
                                                            <td class="text-center">{{date('d/m/Y',strtotime($job->opening_time))}}</td>
                                                            <td class="text-center">{{date('h:i a',strtotime($job->opening_time))}}</td>
                                                            <td class="text-center">{{$job->job_category_name}}</td>
                                                            <td class="text-center">{{$job->job_type_name}}</td>
                                                            <td class="text-center">{{$job->first_name.' '.$job->last_name}}</td>
                                                            <td class="text-center">{{$job->assigned_person}}</td>
                                                            <td class="text-center">
                                                                @if($job->job_closing_date != '' && $job->job_closing_date != '0000-00-00 00:00:00')
                                                                {{date('d/m/Y h:i a',strtotime($job->job_closing_date))}}
                                                                @endif
                                                            </td>
                                                            <td class="text-center">{{$time_taken}}</td>
                                                            <td class="text-center">{{$job->tracking_number}}</td>
                                                        </tr>
                                                    <?php } ?>
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

