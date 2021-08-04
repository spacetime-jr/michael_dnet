@extends('layouts.app')

@section('content')
<!-- Page header -->
<div class="page-header">
	<div class="page-header-content">
		<div class="page-title">
			{{-- <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">User</span> </h4> --}}
			<h4><a href="{{ route('employee.index') }}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">Employee</span> </h4>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
			<li><a href="{{route('employee.index')}}"> Employee </a></li>
			<li class="active">Create</li>
		</ul>
	</div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
	<div class="panel panel-flat">
		@include('partials.notif')
	

		<div class="panel-body">

			@include('users::employee._form', ['action' => '\Modules\Users\Http\Controllers\EmployeeController@store'])
		</div>
	</div>
</div>
<!-- /content area -->
@endsection
