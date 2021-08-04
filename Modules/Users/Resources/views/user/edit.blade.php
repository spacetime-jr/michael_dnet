@extends('layouts.app')

@section('content')
<!-- Page header -->
<div class="page-header">
	<div class="page-header-content">
		<div class="page-title">
			{{-- <h4><a href="{{!empty(\URL::previous())?\URL::previous():route('dashboard')}}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">User</span> </h4> --}}
			<h4><a href="{{ route('users.index') }}"><i class="icon-arrow-left52 position-left" style="color: #000;"></i></a> <span class="text-semibold">User</span> </h4>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="{{route('dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
			<li><a href="{{route('users.index')}}"> User</a></li>
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

			@include('users::user._form', ['action' => array('\Modules\Users\Http\Controllers\UsersController@update', $user->id), 'method' => 'put'])
		</div>
	</div>
</div>
<!-- /content area -->
@endsection
