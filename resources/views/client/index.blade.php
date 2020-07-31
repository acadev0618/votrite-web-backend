<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>VotRite</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<link id="favicon" rel="shortcut icon" href="{{asset('assets/img/favicon_dark.png')}}" />
<link href="{{asset('/assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('/assets/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('/assets/admin/pages/css/login3.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('/assets/admin/layout/css/layout.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('/assets/admin/layout/css/themes/darkblue.css')}}" rel="stylesheet" type="text/css" id="style_color"/>
<link href="{{asset('/assets/admin/layout/css/custom.css')}}" rel="stylesheet" type="text/css"/>
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
<body class="login">
<div class="logo">
	<a >
	<img src="assets/img/favicon_dark.png" alt=""/>
	</a>
</div>
<div class="menu-toggler sidebar-toggler">
</div>
<div class="content">
    <form class="login-form" action="{{url('client/sendpincode')}}" method="post">
        @csrf
		<h3 class="form-title">Login to Vote</h3>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
			@if($errors->any())
			{{$errors->first()}}
			@endif
			Enter PinCode. </span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">PINCODE</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input type="hidden" name="ballot_id" value="{{$ballot}}"/>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Please enter your pincode" name="pincode" required/>
			</div>
		</div>
		<div class="form-actions">
			<button type="button" class="btn-back btn green-haze pull-left">
			Go Back <i class="m-icon-swapright m-icon-white"></i>
			</button>
			<button type="submit" class="btn green-haze pull-right">
			Login <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
	</form>
	
</div>
<div class="copyright">
	 2020 &copy; VotRite.
</div>
<script src="{{asset('/assets/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/jquery-migrate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/jquery.cokie.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('/assets/select2/select2.min.js')}}"></script>
<script src="{{asset('/assets/admin/pages/scripts/login.js')}}" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {     
  Login.init();
});
$('.btn-back').click(function(){
	window.location.href="{{url('/')}}";
});
</script>
</body>
</html>