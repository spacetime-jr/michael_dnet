<?php $page = "approval"; ?>
@extends('layouts.app')

@section('content')
    <!-- Page header -->
    
<style>
     select[name="DataTables_Table_0_length"] {     margin-top: 8px;}
</style>
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Technician</span> </h4>
            </div>
        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">Technician </li>
            </ul>
        </div>
    </div>
    <!-- /page header -->

    @php
    /*
    <div id="modal_saldo" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title">Assign Technician Dealer</h5>
                    <p id="balanceHolder"></p>
                </div>
                {{Form::open(array('method' => 'post' ,'route' => 'technician.approve', 'id' => 'formApproveTechnician')) }}
                <div class="modal-body">
                    <input type="hidden" id="technician_id" name="technician_id">
                    <div class="form-group">
                        <?php
                            $arr = array(
                                'Pilih dealer' => $array_dealers
                            );
                        ?>

                        <div class="col-lg-6">
                            <input type="text" id="dealer" class="form-control" name="dealer" readonly>
                        </div>
                        <div class="col-lg-6">
                            {{ Form::select('dealer_id', $arr,  0, array('class' => 'form-control')) }}
                        </div>


                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                    <input type="submit" class="btn btn-success" value="Approve">
                </div>

                {{Form::close()}}
            </div>
        </div>
    </div>*/
    @endphp
    <script>
        $(document).ready(function () {
            $('.datatable-ajax').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('technician.listApprovalTechnician')}}",
                "columns": [
                    {"data": 'username'},
                    {"data": 'email'},
                    {"data": 'fullname'},
                    {"data": 'status'},
                    {"data": 'created_at'},
//                    {"data": 'updated_at'},
                    {"data": 'actions'},
                ]
            });
        });
    
        // Change the id and description in edit saldo popup
//        function setDealer(me) {
//            var id = $(me).data('id');
//            var dealer = $(me).data('dealer');
//            $('#formApproveTechnician #technician_id').val(id);
//            $('#formApproveTechnician #dealer').val(dealer);
//        }
</script>    
    <!-- Content area -->
    <div class="content">

        <div class="panel panel-flat">
            @include('partials.notif')

            <table class="table datatable-ajax">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Fullname</th>
                    <th>Status</th>
                    <th>Created At</th>
                    @php
//                    <th>Updated At</th>
                    @endphp
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /content area -->
@endsection
