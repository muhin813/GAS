<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-fixed page-container-bg-solid ">
<!-- BEGIN HEADER -->
<?php
$current_url = $_SERVER['REQUEST_URI'];
$current_url = explode('?',$current_url);
$uri = explode('/',$current_url[0]);
$page = $uri[1];
?>
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{url('dashboard')}}" class="nav-item item-1  @if($page=='dashboard') active @endif" data-name="dashboard" data-item="1">
                <!--<img style="width: 114%;" src="{{asset('assets/layouts/layout/img/logo.png')}}" alt="logo" class="logo-default" />-->
                <p style="color: white; font-size: 19px; font-weight: 700;     margin: 11px auto;">GAS</p>
            </a>
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-left">
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle">
                        @if(Session::get('user_photo') !='')
                            <img alt="" class="img-circle profile_image" src="{{asset(Session::get('user_photo'))}}">
                        @else
                            <img alt="" class="img-circle profile_image" src="{{asset('assets/layouts/layout/img/emptyuserphoto.jpg')}}">
                        @endif
                        <span class="username username-hide-on-mobile"> {{Session::get('username')}}</span>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav pull-right">

            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">

    <div class="page-sidebar-wrapper">
        <!-- BEGIN SIDEBAR -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
            <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
            <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
            <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                <li class="sidebar-toggler-wrapper hide">
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler">
                        <span></span>
                    </div>
                    <!-- END SIDEBAR TOGGLER BUTTON -->
                </li>

                <li class="nav-item item-1  @if($page=='dashboard') active @endif" data-name="dashboard" data-item="1">
                    <a href="{{url('dashboard')}}" class="nav-link">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                        <span class="selected"></span>
                    </a>
                </li>

                <li class="nav-item @if($page=='purchases') active @endif">
                    <a href="{{url('purchases')}}" class="nav-link">
                        <i class="icon-layers"></i>
                        <span class="title">Purchases</span>
                        <span class="selected"></span>
                    </a>
                </li>

                <!--            <li class="nav-item @if($page=='productions_issue' || $page=='productions_report' || $page=='wastage_report' || $page=='productions_issue_return' || $page=='productions_report_return') open @endif">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-product"></i>
                    <span class="title">Productions</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu" @if($page=='productions_issue' || $page=='productions_report' || $page=='wastage_report' || $page=='productions_issue_return' || $page=='productions_report_return') style="display: block;" @endif>
                    <li class="nav-item @if($page=='productions_issue') active @endif">
                        <a href="{{url('productions_issue')}}" class="nav-link">
                            <span class="title">Issue</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item @if($page=='productions_report') active @endif">
                        <a href="{{url('productions_report')}}" class="nav-link">
                            <span class="title">Daily Report</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item @if($page=='wastage_report') active @endif">
                        <a href="{{url('wastage_report')}}" class="nav-link">
                            <span class="title">Input Vs Output</span>
                            <span class="selected"></span>
                        </a>
                    </li>

                    <li class="nav-item  @if($page=='productions_issue_return' || $page=='productions_report_return') open @endif">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <span class="title">Return</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu" @if($page=='productions_issue_return' || $page=='productions_report_return') style="display: block;" @endif>
                            <li class="nav-item @if($page=='productions_issue_return') active @endif">
                                <a href="{{url('productions_issue_return')}}" class="nav-link">
                                    <span class="title">Raw Material Return</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                            <li class="nav-item @if($page=='productions_report_return') active @endif">
                                <a href="{{url('productions_report_return')}}" class="nav-link">
                                    <span class="title">Finish Goods Return</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>-->

                <li class="nav-item @if($page=='stock_record' || $page=='stock_issues' || $page=='stock_returns') open @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-list"></i>
                        <span class="title">Inventory</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" @if($page=='stock_record' || $page=='stock_issues' || $page=='stock_returns') style="display: block;" @endif>
                        <li class="nav-item @if($page=='stock_record') active @endif">
                            <a href="{{url('stock_record')}}" class="nav-link">
                                <!--                            <i class="icon-product"></i>-->
                                <span class="title">Stock Record</span>
                                <span class="selected"></span>
                            </a>
                        </li>

                        <li class="nav-item @if($page=='stock_issues') active @endif">
                            <a href="{{url('stock_issues')}}" class="nav-link">
                                <!--                            <i class="icon-product"></i>-->
                                <span class="title">Stock Issues</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='stock_returns') active @endif">
                            <a href="{{url('stock_returns')}}" class="nav-link">
                                <!--                            <i class="icon-product"></i>-->
                                <span class="title">Stock Returns</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item @if($page=='sales') active @endif">
                    <a href="{{url('sales')}}" class="nav-link">
                        <i class="icon-basket-loaded"></i>
                        <span class="title">Sales</span>
                        <span class="selected"></span>
                    </a>
                </li>

                <li class="nav-item @if($page=='cash_books' || $page=='bank_books' || $page=='bank_reconciliations' || $page=='supplier_payments' || $page=='other_payments' || $page=='income_taxes' || $page=='monthly_profit_losses' || $page=='job_wise_profitabilities') open @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-pie-chart"></i>
                        <span class="title">Accounts</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" @if($page=='cash_books' || $page=='bank_books' || $page=='bank_reconciliations' || $page=='supplier_payments' || $page=='other_payments' || $page=='income_taxes' || $page=='monthly_profit_losses' || $page=='job_wise_profitabilities') style="display: block;" @endif>
                        <li class="nav-item @if($page=='cash_books') active @endif">
                            <a href="{{url('cash_books')}}" class="nav-link">
                                <span class="title">Cash Books</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='bank_books') active @endif">
                            <a href="{{url('bank_books')}}" class="nav-link">
                                <span class="title">Bank Books</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='bank_reconciliations') active @endif">
                            <a href="{{url('bank_reconciliations')}}" class="nav-link">
                                <span class="title">Bank Reconciliation</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='supplier_payments') active @endif">
                            <a href="{{url('supplier_payments')}}" class="nav-link">
                                <span class="title">Supplier Payments</span>
                                <span class="selected"></span>
                            </a>
                        </li>

                        <li class="nav-item @if($page=='other_payments') active @endif">
                            <a href="{{url('other_payments')}}" class="nav-link">
                                <span class="title">Other Payments</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='income_taxes') active @endif">
                            <a href="{{url('income_taxes')}}" class="nav-link">
                                <span class="title">Income Taxes</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='monthly_profit_losses') active @endif">
                            <a href="{{url('monthly_profit_losses')}}" class="nav-link">
                                <span class="title">Monthly Profit Loss</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='job_wise_profitabilities') active @endif">
                            <a href="{{url('job_wise_profitabilities')}}" class="nav-link">
                                <span class="title">Job Wise Profitabilities</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item @if($page=='bookings' || $page=='jobs' || $page=='job_duration_trackings') open @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-pie-chart"></i>
                        <span class="title">Operations</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" @if($page=='bookings' || $page=='jobs' || $page=='job_duration_trackings') style="display: block;" @endif>
                        <li class="nav-item @if($page=='bookings') active @endif">
                            <a href="{{url('bookings')}}" class="nav-link">
                                <span class="title">Bookings</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='jobs') active @endif">
                            <a href="{{url('jobs')}}" class="nav-link">
                                <span class="title">Jobs</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='job_duration_trackings') active @endif">
                            <a href="{{url('job_duration_trackings')}}" class="nav-link">
                                <span class="title">Job Wise Time Duration Tracking</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item @if($page=='general_settings' || $page=='items' || $page=='suppliers' || $page=='service_categories' || $page=='service_types' || $page=='package_uoms' || $page=='packages' || $page=='cheque_books' || $page=='parties' || $page=='party_categories' || $page=='banks' || $page=='bank_branches' || $page=='bank_accounts') open @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">Settings</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" @if($page=='general_settings' || $page=='items' || $page=='suppliers' || $page=='service_categories' || $page=='service_types' || $page=='package_uoms' || $page=='packages' || $page=='cheque_books' || $page=='parties' || $page=='party_categories' || $page=='banks' || $page=='bank_branches' || $page=='bank_accounts') style="display: block;" @endif>

                        <li class="nav-item @if($page=='general_settings') active @endif">
                            <a href="{{url('general_settings')}}" class="nav-link">
                                <!--<i class="icon-users"></i>-->
                                <span class="title">General</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='customers') active @endif">
                            <a href="{{url('customers')}}" class="nav-link">
                                <!--<i class="icon-users"></i>-->
                                <span class="title">Customers</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='items' || $page=='item_categories' || $page=='item_uoms') open @endif">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <!--<i class="icon-product"></i>-->
                                <span class="title">Items</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu" @if($page=='items' || $page=='item_categories' || $page=='item_uoms') style="display: block;" @endif>
                                <li class="nav-item @if($page=='items') active @endif">
                                    <a href="{{url('items')}}" class="nav-link">
                                        <!--                            <i class="icon-users"></i>-->
                                        <span class="title">Item List</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="nav-item @if($page=='item_categories') active @endif">
                                    <a href="{{url('item_categories')}}" class="nav-link">
                                        <!--                            <i class="icon-users"></i>-->
                                        <span class="title">Item Categories</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="nav-item @if($page=='item_uoms') active @endif">
                                    <a href="{{url('item_uoms')}}" class="nav-link">
                                        <!--                            <i class="icon-users"></i>-->
                                        <span class="title">Item UOM</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item @if($page=='suppliers') active @endif">
                            <a href="{{url('suppliers')}}" class="nav-link">
                                <span class="title">Suppliers</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='service_categories') active @endif">
                            <a href="{{url('service_categories')}}" class="nav-link">
                                <span class="title">Service Categories</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='service_types') active @endif">
                            <a href="{{url('service_types')}}" class="nav-link">
                                <span class="title">Service Types</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='package_uoms') active @endif">
                            <a href="{{url('package_uoms')}}" class="nav-link">
                                <span class="title">Package UOM</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='packages') active @endif">
                            <a href="{{url('packages')}}" class="nav-link">
                                <span class="title">Packages</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='banks') active @endif">
                            <a href="{{url('banks')}}" class="nav-link">
                                <span class="title">Banks</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='bank_branches') active @endif">
                            <a href="{{url('bank_branches')}}" class="nav-link">
                                <span class="title">Bank Branches</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='bank_accounts') active @endif">
                            <a href="{{url('bank_accounts')}}" class="nav-link">
                                <span class="title">Bank Accounts</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='cheque_books') active @endif">
                            <a href="{{url('cheque_books')}}" class="nav-link">
                                <span class="title">Cheque Books</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='party_categories') active @endif">
                            <a href="{{url('party_categories')}}" class="nav-link">
                                <span class="title">Party Categories</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='parties') active @endif">
                            <a href="{{url('parties')}}" class="nav-link">
                                <span class="title">Parties</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='mechanics') active @endif">
                            <a href="{{url('mechanics')}}" class="nav-link">
                                <span class="title">Mechanics</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item @if($page=='users') active @endif" data-name="users">
                    <a href="{{url('users')}}" class="nav-link">
                        <i class="icon-users"></i>
                        <span class="title">Users</span>
                        <span class="selected"></span>
                    </a>
                </li>

                <li class="nav-item  @if($page=='profile') active @endif" data-name="profile" data-item="1">
                    <a href="{{url('profile')}}" class="nav-link">
                        <i class="icon-user"></i>
                        <span class="title">Profile</span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a  href="{{ url('logout') }}" class="nav-link">
                        <i class="icon-logout"></i>
                        <span class="title">Log Out</span>
                        <span class="selected"></span>
                    </a>
                </li>
            </ul>
            <!-- END SIDEBAR MENU -->
            <!-- END SIDEBAR MENU -->
        </div>
        <!-- END SIDEBAR -->
    </div>
