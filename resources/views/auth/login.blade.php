@php
	use Illuminate\Http\Request;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin | Cahaya Baru</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo asset('assets/css/icons/icomoon/styles.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo asset('assets/css/minified/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo asset('assets/css/minified/core.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo asset('assets/css/minified/components.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo asset('assets/css/minified/colors.min.css') ?>" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/loaders/pace.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/core/libraries/jquery.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/core/libraries/bootstrap.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo asset('assets/js/plugins/loaders/blockui.min.js') ?>"></script>
	<!-- /core JS files -->


	<!-- Theme JS files -->
	<script type="<?php echo asset('text/javascript" src="assets/js/core/app.js') ?>"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Page container -->
	<div class="page-container login-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<!-- Simple login form -->
					@php
						$params = [];
						if(!empty($redirect))
							$params['redirect'] = $redirect;
					@endphp
					<form method="POST" action="{{ route('login_auth', $params) }}">
					    {{ csrf_field() }}
					
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div style="height: auto; margin:auto; font-size:30px; font-weight:bold;">CAHAYA BARU</div>
								<h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5>
								@include('partials.notif')
							</div>

							<div class="form-group has-feedback has-feedback-left {{ $errors->has('email') ? ' has-error' : '' }}">
								<input type="text" class="form-control" placeholder="Username / Email" name="login" value="{{ old('login') }}">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
								
								@if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
							</div>

							<div class="form-group has-feedback has-feedback-left {{ $errors->has('password') ? ' has-error' : '' }}">
								<input type="password" class="form-control" name="password" placeholder="Password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
								
								@if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
							</div>

						</div>
					</form>
					<!-- /simple login form -->


					<!-- Footer -->
					<div class="footer text-muted">
						&copy; {{ date('Y') }}. Cahaya Baru
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>
