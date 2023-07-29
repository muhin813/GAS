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
                                                        <i class="icon-feed icons"></i>
                                                    </div>
                                                    <div class="details">
                                                        <div class="number">
                                                            <span data-counter="counterup" data-value="100">100</span>
                                                        </div>
                                                        <div class="desc"> Item1 </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <a class="dashboard-stat dashboard-stat-v2 red" href="javascript:void(0)">
                                                    <div class="visual">
                                                        <i class="icon-pie-chart icons"></i>
                                                    </div>
                                                    <div class="details">
                                                        <div class="number">
                                                            <span data-counter="counterup" data-value="200">200</span> </div>
                                                        <div class="desc"> Item2 </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <a class="dashboard-stat dashboard-stat-v2 green" href="javascript:void(0)">
                                                    <div class="visual">
                                                        <i class="icon-bag icons"></i>
                                                    </div>
                                                    <div class="details">
                                                        <div class="number">
                                                            <span data-counter="counterup" data-value="300">300</span>
                                                        </div>
                                                        <div class="desc"> Item3 </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                <a class="dashboard-stat dashboard-stat-v2 purple" href="javascript:void(0)">
                                                    <div class="visual">
                                                        <i class="icon-globe icons"></i>
                                                    </div>
                                                    <div class="details">
                                                        <div class="number">
                                                            <span data-counter="counterup" data-value="400">400</span></div>
                                                        <div class="desc"> Item4 </div>
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

