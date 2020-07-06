<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.2
Version: 3.7.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>VotRite</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/> -->
<!-- <link href="/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/> -->
<!-- <link href="/assets/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/> -->
<link id="favicon" rel="shortcut icon" href="{{asset('assets/img/favicon_dark.png')}}" />
<link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<!-- <link href="/assets/select2/select2.css" rel="stylesheet" type="text/css"/> -->
<link href="/assets/admin/pages/css/login3.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<!-- <link href="/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/> -->
<link href="/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="/assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<style>
@media only screen and (max-width: 1000px) {
  .logo {
    display : none;
  }
  .content {
	margin-top: 40% !important;
  }
}
</style>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN LOGO -->
<div class="logo">
	<a >
	<img src="assets/img/favicon_dark.png" alt=""/>
	</a>
</div>
<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="{{url('client/sendpincode')}}" method="post">
        @csrf
		<h3 class="form-title">Login to Vote</h3>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
			@if($errors->any())
			Incorrect PinCode.
			@endif
			Enter PinCode. </span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">PinCode</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input type="hidden" name="ballot_id" value="{{$ballot}}"/>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="PinCode" name="pincode" required/>
			</div>
		</div>
		<div class="form-actions">
			<button type="button" class="btn-back btn green-haze pull-left">
			Back <i class="m-icon-swapright m-icon-white"></i>
			</button>
			<button type="submit" class="btn green-haze pull-right">
			Login <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
	</form>
	<!-- END LOGIN FORM -->
	
</div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
<div class="copyright">
	 2020 &copy; VotRite.
</div>
<!-- END COPYRIGHT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/assets/respond.min.js"></script>
<script src="/assets/excanvas.min.js"></script> 
<![endif]-->
<script src="/assets/jquery.min.js" type="text/javascript"></script>
<script src="/assets/jquery-migrate.min.js" type="text/javascript"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/assets/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/assets/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/assets/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/assets/select2/select2.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS
<script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/demo.js" type="text/javascript"></script> -->
<script src="/assets/admin/pages/scripts/login.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {     
//   Metronic.init(); // init metronic core components
//   Layout.init(); // init current layout
  Login.init();
//   Demo.init();
});
$('.btn-back').click(function(){
	window.location.href="{{url('/')}}";
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>