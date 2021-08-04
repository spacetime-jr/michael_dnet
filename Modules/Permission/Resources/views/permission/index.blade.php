@extends('layouts.app')

@section('content')
        <!-- Page header -->
<style>
     select[name="container_length"] {     margin-top: 8px;}
</style>
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            {{-- <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Permission</span></h4> --}}
            <h4><a href="{{ route('permission.index') }}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Permission</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Permission</li>
        </ul>
    </div>
</div>
<!-- /page header -->
<script>
    $(document).ready(function () {
        $('.datatable-ajax').DataTable({
            "processing": true,
            "columns": [
                {"data": 'id'},
                {"data": 'name'},
                {"data": 'last_update'},
                {"data": 'actions', "orderable": false},
            ]
        });
    });
</script>

<!-- Content area -->
<div class="content">
    <div class="panel" style="background-color: transparent; border:0; box-shadow: none;">
        
    </div>
    <div class="panel panel-flat">
        @include('partials.notif')
        <table class="table datatable-ajax" id="container">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Last Update</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $counter = 0; ?>
            <?php foreach($roles as $role){ ?>
            <tr>
                <td><?php echo $role->id; ?></td>
                <td><?php echo $role->name; ?></td>
                <td><?php echo $role->updated_at; ?></td>
                <td style="width: 150px;" class="text-center">
                    @if (\Sentinel::getUser()->hasAccess('permission.edit'))
                    &emsp;<a href='{{ route('permission.edit', $role->id)}}' title='Edit'><span
                                class='icon-pencil'></span></a>
                    @endif
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- /content area -->
@endsection
