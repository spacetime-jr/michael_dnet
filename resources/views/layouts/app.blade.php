<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CAHAYA BARU</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo asset('assets/css/icons/icomoon/styles.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo asset('assets/css/minified/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo asset('assets/css/minified/core.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo asset('assets/css/minified/components.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo asset('assets/css/minified/colors.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo asset('assets/css/extras/animate.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo asset('css/buttons.dataTables.min.css') ?>" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/loaders/pace.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/core/libraries/jquery.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/core/libraries/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/loaders/blockui.min.js') ?>"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/media/fancybox.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>

	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/tables/datatables/datatables.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/tables/datatables/extensions/tools.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('js/dataTables.buttons.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('js/buttons.print.min.js') ?>"></script>

	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/forms/selects/select2.min.js') ?>"></script>

	<script type="text/javascript" src="<?php echo asset('assets/js/core/app.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/core/libraries/jquery_ui/interactions.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/pages/form_select2.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/pages/datatables_basic.js') ?>"></script>



	<script type="text/javascript" src="<?php echo asset('assets/js/core/libraries/jquery-ui.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('js/alert.js') ?>"></script>


	<script type="text/javascript" src="<?php echo asset('assets/js/core/libraries/jquery_ui/datepicker.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/core/libraries/jquery_ui/effects.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/notifications/jgrowl.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/ui/moment/moment.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/pickers/daterangepicker.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/pickers/anytime.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/pickers/pickadate/picker.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/pickers/pickadate/picker.date.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/pickers/pickadate/picker.time.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/pickers/pickadate/legacy.js') ?>"></script>
	<!--<script type="text/javascript" src="<?php echo asset('assets/js/pages/picker_date.js') ?>"></script> -->
	<!-- /theme JS files -->
	@section('header')

	@show
	<style>
		.numberCircle {
		    border-radius: 50%;

		    width: 20px;
		    height: 20px;
		    padding-top: 2px;
		    
		    background: #FF4500;
		    color: #ffffff;
		    text-align: center;
		    
		    font: 12px Arial, sans-serif;
		}
	</style>
</head>

<body>

	{{-- Auto logout function --}}
	@php
	/*
	@if(\Sentinel::check())
		<script type="text/javascript">
			$(document).ready(function () {
			    var t;
			    window.onload = resetTimer;
			    // DOM Events
			    document.onmousemove = resetTimer;
			    document.onkeypress = resetTimer;

			    function logout() {
			        // alert("You are now logged out.")
			        location.href = '{{ route('logout') }}'
			    }

			    function resetTimer() {
			        clearTimeout(t);
			        t = setTimeout(logout, {{ env('LOGIN_TIMEOUT', 900000) }})
			        // 1000 milisec = 1 sec
			    }
			});
		</script>
	@endif
	*/
	@endphp
	{{-- End auto logout function --}}

	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="{{ route('dashboard') }}" style="padding: 15px 20px; text-align:center; font-size:20px">CAHAYA BARU</a>

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li>
					<a class="sidebar-control sidebar-main-toggle hidden-xs">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>

				<li class="dropdown">
					<?php /*
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-git-compare"></i>
						<span class="visible-xs-inline-block position-right">Git updates</span>
						<span class="badge bg-warning-400">9</span>
					</a> */ ?>

					<div class="dropdown-menu dropdown-content">
						<div class="dropdown-content-heading">
							Git updates
							<ul class="icons-list">
								<li><a href="#"><i class="icon-sync"></i></a></li>
							</ul>
						</div>

						<ul class="media-list dropdown-content-body width-350">
							<li class="media">
								<div class="media-left">
									<a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
								</div>

								<div class="media-body">
									Drop the IE <a href="#">specific hacks</a> for temporal inputs
									<div class="media-annotation">4 minutes ago</div>
								</div>
							</li>
						</ul>

						<div class="dropdown-content-footer">
							<a href="#" data-popup="tooltip" title="All activity"><i class="icon-menu display-block"></i></a>
						</div>
					</div>
				</li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="{{ asset('assets/images/placeholder.jpg') }}" alt="">
						<span>{{ Sentinel::getUser()->fullname }}</span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						@php
						/*
						<li><a href="{{route('users.edit', \Auth::user()->id)}}"><i class="icon-cog5"></i> Account settings</a></li>
						*/
						@endphp
						<li><a href="<?php echo route('logout') ?>"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<a href="#" class="media-left"><img src="{{ asset('assets/images/placeholder.jpg') }}" class="img-circle img-sm" alt=""></a>
								<div class="media-body">
									<span class="media-heading text-semibold">{{ \Sentinel::getUser()->fullname }}</span>
								</div>
							</div>
						</div>
					</div>
					<!-- /user menu -->


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

								<!-- Main -->
								<li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i></li>
								<li class="<?php echo (isset($page) ? ($page == "home" ? "active" : "") : "")?>"><a href="{{ route('dashboard') }}"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
								@php
								/*
								@if(\Sentinel::getUser()->hasAccess('activity.log'))
								<li><a href="<?php echo route('activity.index') ?>"><i class="icon-calendar2"></i> <span>Activity Logs</span></a></li>
								@endif
								*/
								@endphp
								
								<li class="{{(isset($_SESSION['menu']) ? ($_SESSION['menu'] == "absensi" ? "active" : "") : "")}}">
									<a href="{{route('absensi.index')}}"><i class="icon-alarm"></i> <span>Absensi</span></a>
								</li>

								<li class="navigation-header"><span>Modules</span> <i class="icon-menu" title="Modules"></i></li>
								@if(\Sentinel::getUser()->hasAccess('user.list'))
									<li class="{{(isset($_SESSION['menu']) ? ($_SESSION['menu'] == "user" ? "active" : "") : "")}}">
										<a href="{{route('users.index')}}"><i class="icon-user-tie"></i> <span>User</span></a>
									</li>
								@endif
								@if(\Sentinel::getUser()->hasAccess('hr.user.list'))
									<li class="{{(isset($_SESSION['menu']) ? ($_SESSION['menu'] == "hr" ? "active" : "") : "")}}">
										<a href="{{route('hr.index')}}"><i class="icon-people"></i> <span>Human Resources</span></a>
									</li>
								@endif
								@if(\Sentinel::getUser()->hasAccess('employee.list'))
									<li class="{{(isset($_SESSION['menu']) ? ($_SESSION['menu'] == "employee" ? "active" : "") : "")}}">
										<a href="{{route('employee.index')}}"><i class="icon-users"></i> <span>Employee</span></a>
									</li>
								@endif
								@if(\Sentinel::getUser()->hasAccess('ijin.approval'))
									<li class="{{(isset($_SESSION['menu']) ? ($_SESSION['menu'] == "ijin" ? "active" : "") : "")}}">
										<a href="{{route('ijin.index')}}"><i class="icon-calendar3"></i> <span>Pengajuan Ijin</span></a>
									</li>
								@endif
					
								@if(\Sentinel::getUser()->hasAccess('report.absensi'))
									<li class="{{(isset($_SESSION['menu']) ? ($_SESSION['menu'] == "report.absen" ? "active" : "") : "")}}">
										<a href="{{route('report.absensi')}}"><i class="icon-calendar2"></i> <span>Report Absensi</span></a>
									</li>
								@endif
								@if(\Sentinel::getUser()->hasAccess('permission.list'))
									<li class="{{(isset($_SESSION['menu']) ? ($_SESSION['menu'] == "permission" ? "active" : "") : "")}}">
										<a href="{{route('permission.index')}}"><i class="icon-lock5"></i> <span>Permission</span></a>
									</li>
								@endif
								@if(\Sentinel::getUser()->hasAccess('setting.list'))
								<li class="{{(isset($_SESSION['menu']) ? ($_SESSION['menu'] == "setting" ? "active" : "") : "")}}">
									<a href="{{route('setting.index')}}"><i class="icon-cog52"></i> <span>Setting</span></a>
								</li>
								@endif

							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">
				@yield('content')
			</div>
			<!-- /main content -->
		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>