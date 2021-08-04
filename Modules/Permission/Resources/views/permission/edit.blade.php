@extends('layouts.app')

@section('header')
<style>
    
.checkbox-inline, .radio-inline {
    position: relative;
    padding-left: 18px;
}
tr {
    height: 50px;
}
.form-horizontal .radio, .form-horizontal .checkbox, .form-horizontal .radio-inline, .form-horizontal .checkbox-inline {
    margin-top: 0;
    margin-bottom: 0;
    padding-top: 0px;
}
</style>
@endsection
@section('content')
        <!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            {{-- <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Permission</span></h4> --}}
            <h4><a href="{{ route('permission.index') }}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Permission</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i>Home</a></li>
            <li><a href="{{route('permission.index')}}">Permission</a></li>
            <li class="active">Edit</li>
        </ul>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <div class="panel panel-flat">
        @include('partials.notif')

        <div class="panel-body">
            <p class="content-group-lg"></p>

            @include('permission::permission._form', ['action' => array('\Modules\Permission\Http\Controllers\PermissionController@update', $role->id), 'method' => 'put'])
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
