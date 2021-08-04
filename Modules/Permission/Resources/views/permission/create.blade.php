@extends('layouts.app')

@section('content')
        <!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Reference Baru</span>
            </h4>
        </div>
    </div>

    <div class="breadcrumb-line">
        <ul class="breadcrumb">
            <li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i>Home</a></li>
            <li><a href="{{route('reference.index')}}">Reference</a></li>
            <li class="active">Reference Baru</li>
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

            @include('references::references._form', ['action' => '\Modules\References\Http\Controllers\ReferencesController@store'])
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
