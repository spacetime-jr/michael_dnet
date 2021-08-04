<?php $page = "customer"; ?>
@extends('layouts.app')

@section('content')

<style>
     select[name="DataTables_Table_0_length"] {     margin-top: 8px;}
</style>
    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title">
                {{-- <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">User</span></h4> --}}
                <h4><a href="{{ route('ijin.index') }}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Pengajuan Ijin</span></h4>
            </div>
        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">Pengajuan Ijin</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <script>
        $(document).ready(function () {
            $('.datatable-ajax').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('ijin.listIjin')}}",
                //'columnDefs': [ {
                //   'targets': [7], 
                //    'orderable': false, 
                //}],
                "columns": [
                    {"data": 'ufullname'},
                    {"data": 'start_date'},
                    {"data": 'end_date'},
                    {"data": 'type'},
                    {"data": 'cuti_terpakai'},
                    {"data": 'jumlah_hari_potong_gaji'},
                    {"data": 'jumlah_hari_kerja'},
                    {"data": 'status'},
                    {"data": 'afullname'},
                    {"data": 'created_at'},
                    //{"data": 'actions'},
                ]
            });
        });
    </script>
    <!-- Content area -->
    <div class="content">
        <div class="panel" style="background-color: transparent; border:0; box-shadow: none;">
            @if(\Sentinel::getUser()->hasAccess('ijin.approval'))
                <a href="{{route('ijin.create')}}">
                    <button type="button" class="btn btn-success btn-labeled"><b><i class="icon-plus3"></i></b> Buat Pengajuan Ijin Baru
                    </button>
                </a>
            @endif
        </div>

        <div class="panel panel-flat">
            @include('partials.notif')

            <table class="table datatable-ajax">
                <thead>
                <tr>
                    <th>Fullname</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Akhir</th>
                    <th>Jenis Ijin</th>
                    <th>Cuti Terpakai</th>
                    <th>Jumlah Hari Potong Gaji</th>
                    <th>Jumlah Hari Ijin</th>
                    <th>Status</th>
                    <th>Disetujui Oleh</th>
                    <th>Created At</th>
                    <!--<th class="text-center">Actions</th>-->
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /content area -->
@endsection
