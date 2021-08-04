<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Compassion Multiplies</title>

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

                <!-- Simple reset form -->
                <div class="panel panel-body login-form">
                    <div class="text-center">
                        <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                        <h5 class="content-group">Success!! <small class="display-block">Your Password has been changed<br/>You can use your new password to login</small></h5>
                        @include('partials.notif')
                    </div>
                </div>
                <!-- /simple reset form -->



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
