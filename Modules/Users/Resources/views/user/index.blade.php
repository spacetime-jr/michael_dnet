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
                <h4><a href="{{ route('users.index') }}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">User</span></h4>
            </div>
        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
                <li class="active">User</li>
            </ul>
        </div>
    </div>
    <!-- /page header -->
    <script>
        $(document).ready(function () {
            $('.datatable-ajax').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{route('users.listUsers')}}",
                'columnDefs': [ {
                    'targets': [5], 
                    'orderable': false, 
                }],
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
    </script>
    <!-- Content area -->
    <div class="content">
        <div class="panel" style="background-color: transparent; border:0; box-shadow: none;">
            @if(\Sentinel::getUser()->hasAccess('user.create'))
                <a href="{{route('users.create')}}">
                    <button type="button" class="btn btn-success btn-labeled"><b><i class="icon-plus3"></i></b> Create
                    </button>
                </a>
            @endif
        </div>

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
