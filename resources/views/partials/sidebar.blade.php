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
                        <i class="icon-notebook"></i>
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

                <li class="nav-item @if($page=='cash_books' || $page=='bank_books' || $page=='bank_reconciliations' || $page=='supplier_payments' || $page=='other_payments' || $page=='income_taxes' || $page=='monthly_profit_losses') open @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <!--i class="icon-pie-chart"></i-->
                        <img height="24px" src="data:image/png;base64,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">
                        <span class="title">Accounts</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" @if($page=='cash_books' || $page=='bank_books' || $page=='bank_reconciliations' || $page=='supplier_payments' || $page=='other_payments' || $page=='income_taxes' || $page=='monthly_profit_losses') style="display: block;" @endif>
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
                    </ul>
                </li>

                <li class="nav-item @if($page=='bookings' || $page=='jobs') open @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <!--i class="icon-hourglass"></i-->
                        <img height="24px" src="data:image/png;base64,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" />
                        <span class="title">Operations</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" @if($page=='bookings' || $page=='jobs') style="display: block;" @endif>
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
                    </ul>
                </li>

                <li class="nav-item @if($page=='service_sales_report' || $page=='product_sales_report' || $page=='job_wise_profitabilities' || $page=='job_duration_trackings') open @endif">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-book-open"></i>
                        <span class="title">Reports</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" @if($page=='service_sales_report' || $page=='product_sales_report' || $page=='job_wise_profitabilities' || $page=='job_duration_trackings') style="display: block;" @endif>
                        <li class="nav-item @if($page=='service_sales_report') active @endif">
                            <a href="{{url('service_sales_report')}}" class="nav-link">
                                <span class="title">Service Sales Report</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='product_sales_report') active @endif">
                            <a href="{{url('product_sales_report')}}" class="nav-link">
                                <span class="title">Product Sales Report</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        <li class="nav-item @if($page=='job_wise_profitabilities') active @endif">
                            <a href="{{url('job_wise_profitabilities')}}" class="nav-link">
                                <span class="title">Job Wise Profitabilities</span>
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

                                <li class="nav-item @if($page=='item_categories') active @endif">
                                    <a href="{{url('item_categories')}}" class="nav-link">
                                        <!--                            <i class="icon-users"></i>-->
                                        <span class="title">Item Categories</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                <li class="nav-item @if($page=='items') active @endif">
                                    <a href="{{url('items')}}" class="nav-link">
                                        <!--                            <i class="icon-users"></i>-->
                                        <span class="title">Item List</span>
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
