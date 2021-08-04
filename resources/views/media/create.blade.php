@extends('layouts.app')

@section('content')
<!-- Page header -->
<div class="page-header">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Create</span> New User</h4>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">Create New User</li>
		</ul>
	</div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
	<div class="panel panel-flat">
		@include('partials.notif')
	
		<div class="panel-heading">
			<h5 class="panel-title">User Info</h5>
		</div>

		<div class="panel-body">
			<p class="content-group-lg"></p>

			@include('user._form', ['action' => 'UserController@store'])
		</div>
	</div>
</div>
<!-- /content area -->
@endsection
