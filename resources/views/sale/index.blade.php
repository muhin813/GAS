@extends('layouts.master')
@section('title', 'Sales')
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
                        <span>Sales</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title">
                sales
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
                                    <h3 class="page-title">All Sales</h3>

                                    <div class="portlet-body patients-info">
                                        <a href="{{url('sales/create')}}" class="btn btn-primary"><i class="icon-plus"></i>&nbsp; Add Sale</a>
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
                                            <table id="sale_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Sale Type</th>
                                                        <th class="text-center">Invoice Date</th>
                                                        <th class="text-center">Invoice Month</th>
                                                        <th class="text-center">Customer Name</th>
                                                        <th class="text-center">Customer Registration Number</th>
                                                        <th class="text-center">Job Tracking Number</th>
                                                        <th class="text-center">Invoice Number</th>
                                                        <th class="text-center">Invoice Amount</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($sales as $key=>$sale)
                                                        <tr id="sale_{{$sale->id}}">
                                                            <td class="text-center">{{$sales_types[$sale->sales_type]}}</td>
                                                            <td class="text-center">{{date('d/m/Y',strtotime($sale->created_at))}}</td>
                                                            <td class="text-center">{{date('M/Y',strtotime($sale->created_at))}}</td>
                                                            <td class="text-center">{{$sale->first_name." ".$sale->last_name}}</td>
                                                            <td class="text-center">{{$sale->customer_registration_number}}</td>
                                                            <td class="text-center">{{$sale->job_tracking_number}}</td>
                                                            <td class="text-center">{{$sale->invoice_number}}</td>
                                                            <td class="text-center">{{number_format($sale->total_amount, 2, '.', ',')}}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-primary btn-sm" href="javascript:void(0)" title="View Details" onclick="view_details({{$sale->id}})"><i class="icon-eye"></i></a>
                                                                <a class="btn btn-info btn-sm" href="javascript:void(0)" title="Print" onclick="print_sales_invoice({{$sale->id}})"><i class="icon-printer"></i></a>
                                                                <a class="btn btn-success btn-sm" href="{{url('sales',$sale->id)}}" title="Edit"><i class="icon-pencil"></i></a>
                                                                <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Delete" onclick="delete_sale({{$sale->id}})"><i class="icon-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            {{-- Pagination --}}
                                            <div class="">
                                                {{ $sales->appends($_GET)->links() }}
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

            <div class="modal fade" id="sales_details_modal" tabindex="-1" role="dialog" aria-labelledby="prescriptionDetailsModalTitle" aria-hidden="true">
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
                                <div class="col-md-6">
                                    Invoice Number: <span id="invoice_number_view"></span>
                                </div>
                                <div class="col-md-6">
                                    Date of Sale: <span id="sale_date_view"></span>
                                </div>
                                <div class="col-md-6">
                                    Customer Name: <span id="customer_name_view"></span>
                                </div>
                                <div class="col-md-6 service_information">
                                    Service Amount: <span id="service_amount_view"></span>
                                </div>
                                <div class="col-md-6 service_information">
                                    Discount: <span id="discount_view"></span>
                                </div>
                                <div class="col-md-6">
                                    Vat: <span id="vat_view"></span>
                                </div>
                                <div class="col-md-6 service_information">
                                    Total Amount: <span id="total_amount_view"></span>
                                </div>
                                <br><br>
                                <div class="col-md-12" id="item_details_view">
                                    <table id="" class="table table-striped table-bordered table-hover data-table focus-table">
                                        <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Discount</th>
                                            <th>Total Value</th>
                                        </tr>
                                        </thead>
                                        <tbody id="sale_detail_item_list">
                                        <tr>
                                            <td></td>
                                            <td></td>
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


        </div>
        <!-- END CONTENT BODY -->
    </div>

    <style type="text/css">
      #print_area * {
        margin: 0;
        padding: 0;
        text-indent: 0;
      }
      #print_area h3 {
        color: black;
        font-family: "Trebuchet MS", sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 8pt;
      }

      #print_area h2 {
        color: black;
        font-family: Gadugi, sans-serif;
        font-style: normal;
        font-weight: bold;
        text-decoration: none;
        font-size: 11pt;
      }

      #print_area .a {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 8pt;
      }

      #print_area .p,
      #print_area p {
        color: black;
        font-family: Arial, sans-serif;
        font-style: normal;
        font-weight: normal;
        text-decoration: none;
        font-size: 8pt;
        margin: 0pt;
      }
      #print_area table,
      #print_area tbody {
        vertical-align: top;
        overflow: visible;
        width: 100%;
      }
      @media print {
        #print_area {
              width: 21cm;
              height: 29.7cm;
              size: auto;
              margin: 30mm 45mm 30mm 45mm;
              /* change the margins as you want them to be. */
        }

        .bg-black {
            color: #fff !important;
            background-color: #000 !important;
            -webkit-print-color-adjust: exact;
        }
        .bg-golden{
            color: #000 !important;
            background-color: #C4993A !important;
            -webkit-print-color-adjust: exact;
        }
    }
    </style>

    <div id="print_area" style="background-color: white; margin:0 auto;width: 21cm; height: 29.7cm; display: none">
      <table>
        <tr>
          <td>
            <p style="text-indent: 0pt;text-align: left;">
              <span>
                <table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td>
                      <img src="https://i.ibb.co/PhN7jS7/Service-Invoice-pdf.png" alt="Logo"/>
                    </td>
                  </tr>
                </table>
              </span>
            </p>
          </td>
          <td width="30%">
            <table>
              <tr>
                <td style="padding-bottom: 10px;">
                  <img width="16" height="16" style="padding-top: 0px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAYAAABWdVznAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7EAAAOxAGVKw4bAAABHElEQVQokXWRsUrEQBCG/73sFJEUp+2luRisFjT4EvZCCn0CrfMY2gnaapdCAkfKI2DlFWp1dUCwCEKuVS7HjM3eEUMy8MOw83/DzA6YGWmanoRheAvgaUAPSZJcMjOQpukxgDUAaYmt2m9ijLlGGIY3W4PW+pWIXvrMVhsAeAQgWuvf1Wo1quualFJfAwCPYEMppTzPk/F4vJlOpz/oD6VtIk3T6NlsdprneVWW5aHtqDqAbEdiAOK67mdVVS4RvbcW3+7DbWA342QyuVsul3tRFD3HcXxUFMVBEARvXeBfJ9/3PxaLxb6IQESQZdlZy4P7gb9fE1FGROeO43zv6kmSXPQAXZjt4eZgZhhjrgA0AxdmAGyMmed5rv8ANXCd09Nz1TcAAAAASUVORK5CYIIA" />
                </td>
                <td style="padding-bottom: 10px;"><h2 style="text-indent: 0pt;text-align: left; margin-left: 15px;">01751 77 77 77</h2></td>
              </tr>
              <tr>
                <td style="padding-bottom: 10px;">
                  <img width="16" height="16" style="padding-top: 0px; margin-right: 15px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA0AAAAKCAYAAABv7tTEAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7EAAAOxAGVKw4bAAABYUlEQVQokX2OTyiDcRjHv89vw2z2soOraEg5ucmJQmiZ1Bbe1SJ/UmqxchE5KqXIkXYhuTgtjYOb0i5otCJFa9neYoms93337nHwN5lPPafP83x6EJPlvuOGhuTd+norM6PQqLHpCfWo8d54WG43+TTtlIgcz9Go36KkHLa6+ggkCZ/klHRJYqRlU2q8mRNC2PPpM4fIk0l8eMoeRgJJ2btvZB4rAMDIZCrTnv64taTIT0QEADpDiCnvTvGtw/lVhp7rvu/qSDwuLoylejrvSNNrPtWFbsHgk9NMVUtJBjOGT1aNkdSRySQEAAaB3jcZKKo1sDckcVgtJwYdvL9GhFBzAHF5dh7MOn7A4KerNvdGWK0gfITEtyZYXe6QNBNs4jwUACBNi9sCwSqby737M2TGL+yegUubq7f6ZXtrskz2rYlSaw7KOf49AgBRas1Ko+MrfzkAEMz560LyL9TXrPIGyZiUmIUeGIMAAAAASUVORK5CYIIA" />
                </td>
                <td style="padding-bottom: 10px;">
                  <p style="margin-left: 15px; color: black; text-decoration: none; font-size: 14px;">grandautoservices.gas@gmail.com</p>
                </td>
              </tr>
              <tr>
                <td style="padding-bottom: 10px;">
                  <a href="#">
                    <img width="16" height="16" style=" margin-right: 15px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAsAAAALCAYAAACprHcmAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAyklEQVQYlW2RQWoDMQxFX1woQWnXQ6JT5AY5S88x7QF6kvQGYu7TTpZJJg3ZSNONDGaoQZhvP/l/LNwdVf0ATkBkzVkBjKr67u5UsAXmRdMDCFXtyRdb4Ax85x7AWzaMNFCIyNHMumEY9ma2FZFj4xAtfDazDrikvqauDlGAVdZvKWUHvKZ+SX2vTEkLgE1EnIBbnk0R8QNs8n6uMeZ/Mnci8rXMPC6+rP5GzV7h8UlVZZqmQ5N9nbmfaZaqfpIT7NNhOb06wd7d+QPmNHkKuo2DLgAAAABJRU5ErkJgggAA" />
                  </a>
                </td>
                <td style="padding-bottom: 10px;">
                  <p style="color: black; text-decoration: none; font-size: 14px;margin-left: 15px;">GAS-Grand-Auto-Services</p>
                </td>
              </tr>
              <tr>
                <td style="padding-bottom: 10px;">
                  <a href="#">
                    <img width="20" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAMAAADXqc3KAAAAA3NCSVQICAjb4U/gAAAACXBIWXMAAADQAAAA0AF5Y8+UAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAIpQTFRF////AAD/RliVSVeSSFyQRlmTRleRSFmWR1qSSFmUR1mTR1iUSFqSR1qTR1mUR1mTSFiSR1iTR1iUR1mTR1qTRlmUR1mUR1qSR1qTRlmTR1mTRliTRlmTR1mTR1iTR1mTR1qTR1mTR1mTRlmTR1mTR1mTR1mTR1mTR1mUR1mTRlmTR1mTR1mTR1mTDzUfHgAAAC10Uk5TAAEdIycoLC42OVNdYG9wdnyChZCXmJ2iqLXCx9LV2+Dh4uPk5ebn8PL09vz+lXQN5AAAAJhJREFUKM910scSwjAMRdEbSCAU04LpmN6t//89VsnISfx2mrN5I4nEOC+1eGcSjLTG4NrB4dvBE4y/5bCf9Y4iIgF8cwA2DZgSgQ6QTmavOryBrBw0nIBRDMZN2NsFMLDWfkLoUmYVg20IaQWHEHbFHMiLYt1o9WxvJfKIwT0GtwDUoa4KvD7tRYHTz3BWYFDvUy3RO5P8AZLpTyodVpEmAAAAAElFTkSuQmCC" />
                  </a>
                </td>
                <td style="padding-bottom: 10px;">
                  <p style="color: black; text-decoration: none; font-size: 14px; margin-left: 15px;">Grand Auto Services</p>
                </td>
              </tr>
              <tr>
                <td style="padding-bottom: 10px;">
                  <a href="#">
                    <img width="12" height="16" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAANCAYAAAB7AEQGAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7EAAAOxAGVKw4bAAABIUlEQVQYlW2PsU4CURBFz5MVJFleQUJDsJbELSypbPgFY2UnxW65obHjB6CwdQuk0w+wJCF+gNTGEgqNhSabyEafMxbuGiAWk8nMnLlzB1XFOUcYhhfAG6DAV6vVuh6PxyURARGh2Wze5kPJcxHPSZLsMRwOz9cAAd4BV4CNRmOC7/tXBRQEwelisdidzWaHxpjPfOkb4C4vsvl8XhcRVJVqtfpUqO+02+1HwADl6XR6YoxhNBrVV6vVft53xHF8tmV6w3yn05kgIgAfW18VIf1+/xgRodvtXv6n4nneg4iAqrJcLkuVSuV166REUXSgqr+QqtLr9Y7ydxVQ3/dvnHNsQFmWYa1NALXWvqRpWi5mf5CqkqapV6vV7geDgV3v/wCiYLeei7zoHgAAAABJRU5ErkJgggAA" />
                  </a>
                </td>
                <td style="padding-bottom: 10px;">
                  <p style="color: black; text-decoration: none; font-size: 14px; margin-left: 15px;">Plot-73, Nasirabad Industrial Areo,</br> Textile Gate, Bayezid Bostami,</br> Chattogram</p>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>

      <div class="bg-black" id="invoice_title_view" style="text-align: center;color:#fff;padding:10px; width: 300px; margin: 30px auto 40px auto;font-size: 16px;"> Invoice </div>

      <table style="border-collapse:collapse; margin-bottom: 30px;"cellspacing="0">
        <tr>
          <td class="bg-golden" style="width:121pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;">
            <p style="padding: 2pt 0 2px 5pt;text-indent: 0pt;text-align: left;font-size: 14px;font-weight: 600;">BILL TO</p>
          </td>
          <td style="width:219pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt">
            <p style="text-indent: 0pt;text-align: left;">
              <br />
            </p>
          </td>
        </tr>
        <tr>
          <td style="width:121pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600;">Customer Name:</p>
          </td>
          <td style="width:219pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p id="print_customer_name_view" style="padding: 5px;font-size: 13px;font-weight: 600;text-align: center;">

            </p>
          </td>
        </tr>
        <tr style="height:15pt">
          <td style="width:121pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600">Registration Number:</p>
          </td>
          <td style="width:219pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p id="print_customer_registration_number_view" style="padding: 5px;font-size: 13px;font-weight: 600;text-align: center;">

            </p>
          </td>
        </tr>
        <tr style="height:15pt">
          <td style="width:121pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600">Vehicle Number:</p>
          </td>
          <td style="width:219pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p id="print_vehicle_number_view" style="padding: 5px;font-size: 13px;font-weight: 600;text-align: center;">

            </p>
          </td>
        </tr>
        <tr style="height:15pt">
          <td style="width:121pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600">Job Tracking Number:</p>
          </td>
          <td style="width:219pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p id="print_job_tracking_number_view" style="padding: 5px;font-size: 13px;font-weight: 600;text-align: center;">

            </p>
          </td>
        </tr>
        <tr style="height:15pt">
          <td style="width:121pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600">Phone Number:</p>
          </td>
          <td style="width:219pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p id="print_customer_phone_view" style="padding: 5px;font-size: 13px;font-weight: 600;text-align: center;">

            </p>
          </td>
        </tr>
        <tr style="height:15pt">
          <td style="width:121pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600">Email Address:</p>
          </td>
          <td style="width:219pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p id="print_customer_email_view" style="padding: 5px;font-size: 13px;font-weight: 600;text-align: center;">

            </p>
          </td>
        </tr>
      </table>
      <table id="print_sales_detail_view" style="border-collapse:collapse;margin-bottom: 30px;" cellspacing="0">

      </table>

      <table style="border-collapse:collapse;" cellspacing="0">
        <tr style="height:21pt">
          <td style="width:336pt;border-top-style:solid;border-top-width:1pt;border-top-color:#808080;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#808080;border-right-style:solid;border-right-width:1pt" rowspan="5">
            <p style="text-indent: 0pt;text-align: left;">
              <br />
            </p>
            <p style="padding: 50px 0; text-align: center;font-size: 18px;font-weight: 600;font-style: italic;">Thank you for choosing us as </br>your trusted provider</p>
          </td>
          <td style="width:82pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="font-size: 13px;font-weight: 800;padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">Subtotal</p>
          </td>
          <td style="width:85pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="2">
            <p id="print_subtotal_view" style="font-size: 13px;font-weight: 800;padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;text-align: center;">

            </p>
          </td>
        </tr>
        <tr style="height:21pt">
          <td style="width:82pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="font-size: 13px;font-weight: 800;padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">Discount</p>
          </td>
          <td style="width:85pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="2">
            <p id="print_discount_view" style="font-size: 13px;font-weight: 800;padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;text-align: center;">

            </p>
          </td>
        </tr>
        <tr style="height:21pt">
          <td style="width:82pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="font-size: 13px;font-weight: 800;padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">Vat Rate</p>
          </td>
          <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p id="print_vat_view" style="font-size: 13px;font-weight: 800;padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;text-align: center;">

            </p>
          </td>
          <td style="width:28pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="font-size: 13px;font-weight: 800;padding-top: 3pt;padding-left: 8pt;text-indent: 0pt;text-align: left;">%</p>
          </td>
        </tr>
        <tr style="height:21pt">
          <td style="width:82pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="font-size: 13px;font-weight: 800;padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">Vat Amount</p>
          </td>
          <td style="width:85pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="2">
            <p style="text-indent: 0pt;text-align: left;">
              <p id="print_vat_amount_view" style="font-size: 13px;font-weight: 800;padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;text-align: center;">

              </p>
            </p>
          </td>
        </tr>
        <tr style="height:28pt">
          <td style="width:82pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s10" style="font-size: 20px;font-weight: 600;padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">Total</p>
          </td>
          <td style="width:85pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="2">
            <p style="text-indent: 0pt;text-align: left;">
              <p id="print_total_view" style="font-size: 20px;font-weight: 800;padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;text-align: center;">

              </p>
            </p>
          </td>
        </tr>
      </table>
    </div>

    <!--div id="print_area" style="display: none">
        <div style="text-align: center;">
            <h1>Grand Auto Service</h1>
            <span>All kind of auto service and products</span> <br>
            <span>Address, Dhaka-0000</span> <br>
            <span>Mob: 01xxxxxxxxx, E-mail: admin@gmail.com</span>
        </div>
        <br><br>
        <div class="row">
            <div style="float:left;margin-left:15px">
                Invoice No: <span id="print_invoice_number_view"></span>
            </div>
            <div style="float:left;margin-left:130px; padding:5px; border:1px solid;border-radius: 25px; background:#000000; color:#FFFFFF">
                Cash Memo/Challan
            </div>
            <div style="float:right;">
                Date: <span id="print_sale_date_view"></span>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div style="margin-left:15px">
                Name: <span id="print_customer_name_view"></span>
            </div>
            <div style="float:left;margin-left:15px">
                Address: <span id="print_customer_address_view"></span>
            </div>
            <div style="float:left;margin-left:15px">
                Phone: <span id="print_customer_phone_view"></span>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-12">
                <table id="" class="table table-striped table-bordered table-hover data-table focus-table">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Discount</th>
                        <th>Total Value</th>
                    </tr>
                    </thead>
                    <tbody id="print_sale_detail_item_list">
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
</div-->

    <!-- END CONTENT -->
@endsection

@section('js')
    <script>

        function view_details(id){
            var url = "{{ url('sales/get_details') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {sales_id:id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var sales_details = data.sale.details;

                        $('#invoice_number_view').text(data.sale.invoice_number);
                        $('#sale_date_view').text(getFormattedDate(data.sale.date_of_sale,'d/m/Y'));
                        $('#customer_name_view').text(data.sale.first_name+' '+data.sale.last_name);
                        $('#service_amount_view').text(data.sale.service_amount);
                        $('#discount_view').text(parseFloat(data.sale.discount)+'%');
                        $('#vat_view').text(parseFloat(data.sale.vat)+'%');
                        $('#total_amount_view').text(data.sale.total_amount);

                        var html = '';
                        var grant_total_value = 0;
                        $.each(sales_details , function(index, details) {
                            html +='<tr>';
                            html +='<td>'+details.item_name+'</td>';
                            html +='<td>'+details.quantity+'</td>';
                            html +='<td>'+details.unit_price+'</td>';
                            html +='<td>'+(details.discount !== null ? details.discount :'')+'</td>';
                            html +='<td>'+details.total_value+'</td>';
                            html +='</tr>';

                            grant_total_value = grant_total_value+parseFloat(details.total_value);
                        });
                        var total_vat_amount = grant_total_value*(data.sale.vat/100);
                        var grant_total_value_with_vat = grant_total_value+total_vat_amount;
                        // For total row in footer
                        html +='<tr>';
                        html +='<td colspan="4" style="text-align: right"><b>Subtotal</b></td>';
                        html +='<td><b>'+grant_total_value.toFixed(2)+'</b></td>';
                        html +='</tr>';

                        html +='<tr>';
                        html +='<td colspan="4" style="text-align: right"><b>Vat</b></td>';
                        html +='<td><b>'+total_vat_amount.toFixed(2)+'</b></td>';
                        html +='</tr>';

                        html +='<tr>';
                        html +='<td colspan="4" style="text-align: right"><b>Total</b></td>';
                        html +='<td><b>'+grant_total_value_with_vat.toFixed(2)+'</b></td>';
                        html +='</tr>';

                        $('#sale_detail_item_list').html(html);

                        if(data.sale.sales_type=='product'){
                            $('#item_details_view').show();
                            $('.service_information').hide();
                        }
                        else{
                            $('#item_details_view').hide();
                            $('.service_information').show();
                        }

                        $('#sales_details_modal').modal('show');
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

        function print_sales_invoice(id){
            var url = "{{ url('sales/get_details') }}";
            $.ajax({
                type: "POST",
                url: url,
                data: {sales_id:id,'_token':'{{csrf_token()}}'},
                success: function(data) {
                    hide_loader();
                    if (data.status == 200) {
                        var sales_details = data.sale.details;

                        //$('#print_invoice_number_view').text(data.sale.invoice_number);
                        $('#print_sale_date_view').text(getFormattedDate(data.sale.date_of_sale,'d/m/Y'));
                        $('#print_customer_name_view').text(data.sale.first_name+''+data.sale.last_name);
                        $('#print_customer_registration_number_view').text(data.sale.customer_registration_number);
                        $('#print_vehicle_number_view').text(data.sale.vehicle_number);
                        $('#print_job_tracking_number_view').text(data.sale.job_tracking_number);
                        $('#print_customer_phone_view').text(data.sale.customer_phone);
                        $('#print_customer_email_view').text(data.sale.customer_email);

                        var html = '';
                        var grant_total_value = 0;
                        var total_discount_amount = 0;

                        if(data.sale.sales_type=='service') {//For service sales
                            $('#invoice_title_view').text('Sales Invoice #'+data.sale.invoice_number);

                            html += '<tr style="height:21pt">';
                            html += '<td class="bg-golden" style="width:28pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#808080;border-right-style:solid;border-right-width:1pt;border-right-color:#808080" bgcolor="#C4993A">';
                            html += '<p style="font-size: 14px;font-weight: 600;line-height: 10pt;text-align: center;">SL. No.</p>';
                            html += '</td>';
                            html += '<td class="bg-golden" style="width:195pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#808080;border-right-style:solid;border-right-width:1pt;border-right-color:#808080" bgcolor="#C4993A">';
                            html += '<p style="font-size: 14px;font-weight: 600;padding-top: 5pt;text-align: center;">SERVICE CATEGORY</p>';
                            html += '</td>';
                            html += '<td class="bg-golden" style="width:195pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#808080;border-right-style:solid;border-right-width:1pt;border-right-color:#808080" bgcolor="#C4993A">';
                            html += '<p style="font-size: 14px;font-weight: 600;padding-top: 5pt;text-indent: 0pt;text-align: center;">SERVICE TYPE</p>';
                            html += '</td>';
                            html += '<td class="bg-golden" style="width:85pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#808080;border-right-style:solid;border-right-width:1pt" bgcolor="#C4993A">';
                            html += '<p style="font-size: 14px;font-weight: 600;padding-top: 5pt;text-align: center;">AMOUNT</p>';
                            html += '</td>';
                            html += '</tr>';
                            html += '<tr>';
                            html += '<td style="width:28pt;border-top-style:solid;border-top-width:1pt;border-top-color:#808080;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;border-right-color:#808080">';
                            html += '<p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600; text-align: center;">';
                            html += '01';
                            html += '</p>';
                            html += '</td>';
                            html += '<td style="width:195pt;border-top-style:solid;border-top-width:1pt;border-top-color:#808080;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;border-right-color:#808080">';
                            html += '<p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600; text-align: center;">';
                            html += data.sale.service_category_name;
                            html += '</p>';
                            html += '</td>';
                            html += '<td style="width:195pt;border-top-style:solid;border-top-width:1pt;border-top-color:#808080;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;border-right-color:#808080">';
                            html += '<p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600; text-align: center;">';
                            html += data.sale.service_type_name;
                            html += '</p>';
                            html += '</td>';
                            html += '<td style="width:85pt;border-top-style:solid;border-top-width:1pt;border-top-color:#808080;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">';
                            html += '<p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600; text-align: center;">';
                            html += data.sale.service_amount;
                            html += '</p>';
                            html += '</td>';
                            html += '</tr>';

                            grant_total_value = data.sale.service_amount;
                            total_discount_amount = grant_total_value*(data.sale.discount/100);
                        }
                        else{  //For product sales
                            $('#invoice_title_view').text('Product Invoice #'+data.sale.invoice_number);

                            html += '<tr style="height:21pt">';
                            html += '<td style="width:28pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#808080;border-right-style:solid;border-right-width:1pt;border-right-color:#808080" bgcolor="#C4993A">';
                            html += '<p style="font-size: 14px;font-weight: 600;line-height: 10pt;text-align: center;">SL. No.</p>';
                            html += '</td>';
                            html += '<td style="width:433pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#808080;border-right-style:solid;border-right-width:1pt;border-right-color:#808080" bgcolor="#C4993A">';
                            html += '<p style="font-size: 14px;font-weight: 600;padding-top: 5pt;text-align: center;">ITAME NAME</p>';
                            html += '</td>';
                            html += '<td style="width:107pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#808080;border-right-style:solid;border-right-width:1pt;border-right-color:#808080" bgcolor="#C4993A">';
                            html += '<p style="font-size: 14px;font-weight: 600;padding-top: 5pt;text-indent: 0pt;text-align: center;">QUANTITY</p>';
                            html += '</td>';
                            html += '<td style="width:133pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#808080;border-right-style:solid;border-right-width:1pt;border-right-color:#808080" bgcolor="#C4993A">';
                            html += '<p style="font-size: 14px;font-weight: 600;padding-top: 5pt;text-indent: 0pt;text-align: center;">UNIT PRICE</p>';
                            html += '</td>';
                            html += '<td style="width:85pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#808080;border-right-style:solid;border-right-width:1pt" bgcolor="#C4993A">';
                            html += '<p style="font-size: 14px;font-weight: 600;padding-top: 5pt;text-align: center;">AMOUNT</p>';
                            html += '</td>';
                            html += '</tr>';

                            $.each(sales_details , function(index, details) {
                                var total_value = details.quantity*details.unit_price;

                                html += '<tr>';
                                html += '<td style="width:28pt;border-top-style:solid;border-top-width:1pt;border-top-color:#808080;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;border-right-color:#808080">';
                                html += '<p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600; text-align: center;">';
                                html += (index+1);
                                html += '</p>';
                                html += '</td>';
                                html += '<td style="width:433pt;border-top-style:solid;border-top-width:1pt;border-top-color:#808080;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;border-right-color:#808080">';
                                html += '<p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600; text-align: center;">';
                                html += details.item_name;
                                html += '</p>';
                                html += '</td>';
                                html += '<td style="width:107pt;border-top-style:solid;border-top-width:1pt;border-top-color:#808080;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;border-right-color:#808080">';
                                html += '<p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600; text-align: center;">';
                                html += details.quantity;
                                html += '</p>';
                                html += '</td>';
                                html += '<td style="width:133pt;border-top-style:solid;border-top-width:1pt;border-top-color:#808080;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;border-right-color:#808080">';
                                html += '<p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600; text-align: center;">';
                                html += details.unit_price;
                                html += '</p>';
                                html += '</td>';
                                html += '<td style="width:85pt;border-top-style:solid;border-top-width:1pt;border-top-color:#808080;border-left-style:solid;border-left-width:1pt;border-left-color:#808080;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">';
                                html += '<p style="padding: 5px; text-align: left;font-size: 13px;font-weight: 600; text-align: center;">';
                                html += total_value;
                                html += '</p>';
                                html += '</td>';
                                html += '</tr>';

                                grant_total_value = grant_total_value+parseFloat(total_value);

                                var discount_amount = grant_total_value*(details.discount/100);
                                total_discount_amount = total_discount_amount+discount_amount;
                            });
                        }

                        $('#print_sales_detail_view').html(html);

                        var amount_after_discount = grant_total_value - total_discount_amount;
                        var vat_amount = amount_after_discount*(data.sale.vat/100);

                        $('#print_subtotal_view').text(grant_total_value);
                        $('#print_discount_view').text(total_discount_amount);
                        $('#print_vat_view').text(data.sale.vat);
                        $('#print_vat_amount_view').text(vat_amount);
                        $('#print_total_view').text(data.sale.total_amount);

                        $('.page-content-wrapper').hide();
                        $('#print_area').show();
                        window.print();

                        $('.page-content-wrapper').show();
                        $('#print_area').hide();
                        window.close();
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

        function delete_sale(id){
            $(".warning_message").text('Are you sure you delete this sale detail? This can not be undone.');
            $("#warning_modal").modal('show');
            $( "#warning_ok" ).on('click',function() {
                show_loader();
                var url = "{{ url('sales/delete') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {sale_id:id,'_token':'{{csrf_token()}}'},
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#sale_'+id).remove();
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

