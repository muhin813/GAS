@extends('layouts.customer_master')
@section('title', 'Customer Dashboard')
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
            <h3 class="page-title"> Our Services
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
                                        <div class="service-list">
                                            <div class="service-list__item">
                                                <a href="#">
                                                    <img src="{{asset('assets/global/img/icons/Painting_and_Denting.png')}}" alt="Painting and Denting" />
                                                    <p>Painting and Denting</p>
                                                </a>
                                            </div>   
                                            <div class="service-list__item">
                                                <a href="#">
                                                    <img src="{{asset('assets/global/img/icons/Wash_Polish_&_Detailing.png')}}" alt="Wash Polish & Detailing" />
                                                    <p>Wash Polish & Detailing</p>
                                                </a>
                                            </div>  
                                            <div class="service-list__item">
                                                <a href="#">
                                                    <img src="{{asset('assets/global/img/icons/Mechanical_Works.png')}}" alt="Mechanical Works" />
                                                    <p>Mechanical Works</p>
                                                </a>
                                            </div>  
                                            <div class="service-list__item">
                                                <a href="#">
                                                    <img src="{{asset('assets/global/img/icons/Electrical_&_AC_Services.png')}}" alt="Electrical & AC Services" />
                                                    <p>Electrical & AC Services</p>
                                                </a>
                                            </div>  
                                            <div class="service-list__item">
                                                <a href="#">
                                                    <img src="{{asset('assets/global/img/icons/Restoration_&_Project_Works.png')}}" alt="Restoration & Project Works" />
                                                    <p>Restoration & Project Works</p>
                                                </a>
                                            </div>  
                                            <div class="service-list__item">
                                                <a href="#">
                                                    <img src="{{asset('assets/global/img/icons/Wheel_Alignment_and_Balancing.png')}}" alt="Wheel Alignment and Balancing" />
                                                    <p>Wheel Alignment and Balancing</p>
                                                </a>
                                            </div>  
                                            <div class="service-list__item">
                                                <a href="#">
                                                    <img src="{{asset('assets/global/img/icons/SOS_Services.png')}}" alt="SOS Services" />
                                                    <p>SOS Services</p>
                                                </a>
                                            </div>  
                                            <div class="service-list__item">
                                                <a href="#">
                                                    <img src="{{asset('assets/global/img/icons/Car_Diagnosis_&_Hybrid_Works.png')}}" alt="Car Diagnosis & Hybrid Works" />
                                                    <p>Car Diagnosis & Hybrid Works</p>
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

