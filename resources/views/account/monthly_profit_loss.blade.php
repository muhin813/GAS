@extends('layouts.master')
@section('title', 'Monthly Profit Losses')
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
                        <span>Monthly Profit Losses</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title">
                monthly_salary_statements
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
                                    <h3 class="page-title">Monthly Profit Losses</h3>
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
                                            <select name="year" id="year" class="form-control" required>
                                                <option value="">Select Year</option>
                                                @for($year=date('Y'); $year>=2020; $year--)
                                                    <option value="{{$year}}" @if($year==request('year')) selected @endif>{{$year}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="salary" id="salary" placeholder="Salary" value="{{request('salary')}}">
                                        </div>
                                    </div>
<!--                                    <div class="col-md-3">
                                        <div class="form-group mb-0">
                                            <select name="month" id="month" class="form-control">
                                                <option value="">Select Month</option>
                                                @foreach($months as $key=>$month)
                                                    <option value="{{$key+1}}" @if($month==request('month')) selected @endif>{{$month}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>-->
                                    <div class="col-md-2">
                                        <div class="form-group mb-0">
                                            <button type="submit" class="btn btn-primary">Generate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <a href="{{url('monthly_profit_losses')}}" class="btn btn-success">Clear Filter</a>
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
                                            <table id="monthly_salary_statement_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">SL NO</th>
                                                        <th class="text-center">Particulars</th>
                                                        <th class="text-center">January</th>
                                                        <th class="text-center">February</th>
                                                        <th class="text-center">March</th>
                                                        <th class="text-center">April</th>
                                                        <th class="text-center">May</th>
                                                        <th class="text-center">June</th>
                                                        <th class="text-center">July</th>
                                                        <th class="text-center">August</th>
                                                        <th class="text-center">September</th>
                                                        <th class="text-center">October</th>
                                                        <th class="text-center">November</th>
                                                        <th class="text-center">December</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center">A</td>
                                                        <td class="text-center">Sales Revenue</td>
                                                        @foreach($months as $month)
                                                            <td class="text-center">{{($profit_loss[$month]['sales'] != '' ? number_format($profit_loss[$month]['sales'], 2, '.', ',') : '') }}</td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">B</td>
                                                        <td class="text-center">Cost of sales</td>
                                                        @foreach($months as $month)
                                                            <td class="text-center">{{($profit_loss[$month]['cost_of_sales'] != '' ? number_format($profit_loss[$month]['cost_of_sales'], 2, '.', ',') : '') }}</td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">A-B</td>
                                                        <td class="text-center">Gross Profit</td>
                                                        @foreach($months as $month)
                                                            <td class="text-center">{{($profit_loss[$month]['gross_profit'] != '' ? number_format($profit_loss[$month]['gross_profit'], 2, '.', ',') : '') }}</td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">D</td>
                                                        <td class="text-center">Administrative Expense</td>
                                                        @foreach($months as $month)
                                                            <td class="text-center">{{($profit_loss[$month]['other_expense'] != '' ? number_format($profit_loss[$month]['other_expense'], 2, '.', ',') : '') }}</td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">C</td>
                                                        <td class="text-center">Operating Expense</td>
                                                        @foreach($months as $month)
                                                            <td class="text-center">{{($profit_loss[$month]['salary_expense'] != '' ? number_format($profit_loss[$month]['salary_expense'], 2, '.', ',') : '') }}</td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">(A-B) - (C+D)</td>
                                                        <td class="text-center">Net Profit</td>
                                                        @foreach($months as $month)
                                                            <td class="text-center">{{($profit_loss[$month]['net_profit'] != '' ? number_format($profit_loss[$month]['net_profit'], 2, '.', ','): '')}}</td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">F</td>
                                                        <td class="text-center">Income Tax</td>
                                                        @foreach($months as $month)
                                                            <td class="text-center">{{($profit_loss[$month]['income_tax'] != '' ? number_format($profit_loss[$month]['income_tax'], 2, '.', ',') : '') }}</td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">Net Profit-F</td>
                                                        <td class="text-center">Profit/Loss</td>
                                                        @foreach($months as $month)
                                                            <td class="text-center">{{($profit_loss[$month]['profit'] != '' ? number_format($profit_loss[$month]['profit'], 2, '.', ',') : '')}}</td>
                                                        @endforeach
                                                    </tr>
                                                    </tbody>
                                                </table>
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
        //
    </script>
@endsection

