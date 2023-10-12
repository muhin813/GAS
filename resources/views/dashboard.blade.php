@extends('layouts.master')
@section('title', 'Dashboard')
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
                        <span>Home</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title"> Dashboard
            </h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE BAR -->
            <!-- END PAGE HEADER-->

            <div class="row mt-3">
                <div class="col-md-12">
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
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <a class="dashboard-stat dashboard-stat-v2 blue" href="javascript:void(0)">
                                                    <div class="visual">
                                                        <i class="icon-basket-loaded icons"></i>
                                                    </div>
                                                    <div class="details">
                                                        <div class="number">
                                                            <span data-counter="counterup" data-value="{{$product_sale}}">{{$product_sale}}</span>
                                                        </div>
                                                        <div class="desc"> Daily Product Sales </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <a class="dashboard-stat dashboard-stat-v2 red" href="javascript:void(0)">
                                                    <div class="visual">
                                                        <i class="icon-hourglass icons"></i>
                                                    </div>
                                                    <div class="details">
                                                        <div class="number">
                                                            <span data-counter="counterup" data-value="{{$service_sale}}">{{$service_sale}}</span> </div>
                                                        <div class="desc"> Daily Service Sales </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <a class="dashboard-stat dashboard-stat-v2 green" href="javascript:void(0)">
                                                    <div class="visual">
                                                        <i class="icon-calendar icons"></i>
                                                    </div>
                                                    <div class="details">
                                                        <div class="number">
                                                            <span data-counter="counterup" data-value="{{$ongoing_jobs}}">{{$ongoing_jobs}}</span>
                                                        </div>
                                                        <div class="desc"> Current Ongoing Job </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <a class="dashboard-stat dashboard-stat-v2 purple" href="javascript:void(0)">
                                                    <div class="visual">
                                                        <i class="icon-briefcase icons"></i>
                                                    </div>
                                                    <div class="details">
                                                        <div class="number">
                                                            <span data-counter="counterup" data-value="{{$new_job_received}}">{{$new_job_received}}</span></div>
                                                        <div class="desc"> Daily New Job Received </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="margin-top: 30px;">
                                                <a class="dashboard-stat dashboard-stat-v2 green" href="javascript:void(0)">
                                                    <div class="visual">
                                                        <i class="icon-flag icons"></i>
                                                    </div>
                                                    <div class="details">
                                                        <div class="number">
                                                            <span data-counter="counterup" data-value="{{$new_job_completed}}">{{$new_job_completed}}</span>
                                                        </div>
                                                        <div class="desc">Daily New Job Completed</div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="margin-top: 30px;">
                                                <a class="dashboard-stat dashboard-stat-v2 purple" href="javascript:void(0)">
                                                    <div class="visual">
                                                        <i class="icon-wallet icons"></i>
                                                    </div>
                                                    <div class="details">
                                                        <div class="number">
                                                            <span data-counter="counterup" data-value="{{number_format($settings->cash_in_hand_opening_balance, 2, '.', ',')}}">{{number_format($settings->cash_in_hand_opening_balance, 2, '.', ',')}}</span></div>
                                                        <div class="desc"> Cash at Hand </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="margin-top: 30px;">
                                                <a class="dashboard-stat dashboard-stat-v2 blue" href="javascript:void(0)">
                                                    <div class="visual">
                                                        <i class="icon-home icons"></i>
                                                    </div>
                                                    <div class="details">
                                                        <div class="number">
                                                            <span data-counter="counterup" data-value="{{number_format($bank_account->cash_at_bank, 2, '.', ',')}}">{{number_format($bank_account->cash_at_bank, 2, '.', ',')}}</span>
                                                        </div>
                                                        <div class="desc"> Cash at Bank </div>
                                                    </div>
                                                </a>
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

    </script>
@endsection

