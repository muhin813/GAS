@extends('layouts.master')
@section('title', 'Item UOMs')
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
                        <span>Item UOMs</span>
                    </li>
                </ul>
                <div class="page-toolbar">

                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title">
                item_uoms
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
                                    <h3 class="page-title">All Item UOMs</h3>

                                    <div class="portlet-body patients-info">
                                        <a href="{{url('item_uoms/create')}}" class="btn btn-primary"><i class="icon-plus"></i>&nbsp; Add Item UOM</a>
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
                                            <table id="item_uom_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($item_uoms as $key=>$item_uom)
                                                        <tr id="item_uom_{{$item_uom->id}}">
                                                            <td class="text-center">{{$item_uom->name}}</td>
                                                            <td class="text-center">
                                                                <a class="btn btn-success btn-sm" href="{{url('item_uoms',$item_uom->id)}}" title="Edit"><i class="icon-pencil"></i></a>
                                                                <a class="btn btn-danger btn-sm" href="javascript:void(0)" title="Delete" onclick="delete_item_uom({{$item_uom->id}})"><i class="icon-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            {{-- Pagination --}}
                                            <div class="">
                                                {{ $item_uoms->appends($_GET)->links() }}
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
        function delete_item_uom(id){
            $(".warning_message").text('Are you sure you delete this item UOM? This can not be undone.');
            $("#warning_modal").modal('show');
            $( "#warning_ok" ).on('click',function() {
                show_loader();
                var url = "{{ url('item_uoms/delete') }}";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {item_uom_id:id,'_token':'{{csrf_token()}}'},
                    success: function(data) {
                        hide_loader();
                        if (data.status == 200) {
                            $('#item_uom_'+id).remove();
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

