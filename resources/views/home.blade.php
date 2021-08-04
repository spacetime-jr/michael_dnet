<?php $page = "home"; ?>
@extends('layouts.app')

@section('content')
<!-- Page header -->
<div class="page-header">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Your</span> Dashboard</h4>
		</div>
	</div>

	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li><a href="#"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">Dashboard</li>
		</ul>
	</div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
	@include('partials.notif')
</div>
<!-- /content area -->
@endsection
