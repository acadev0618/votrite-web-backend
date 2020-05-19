@extends('auth.layouts')

@section('content')
	<div class="limiter">
		<div class="container-login">
			<div class="wrap-login">
				<span class="login-form-title p-b-48">
					<img src="{{ asset('assets/img/favicon_dark.png') }}" alt="logo" class="logo-default" style="width: 200px;"/>
				</span>
				<span class="login-form-title p-b-26">
					Login
				</span>

				<form class="login-form validate-form" method="POST" action="{{ asset('/login') }}">
					@csrf
					
					@if ($message = Session::get('success'))
					<div class="alert alert-success alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button>	
							<strong>{{ $message }}</strong>
					</div>
					@endif

					@if ($message = Session::get('warning'))
					<div class="alert alert-warning alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button>	
						<strong>{{ $message }}</strong>
					</div>
					@endif

					<div class="wrap-input100 validate-input" data-validate = "Valid email is: admin@gmail.com">
						<input class="input100" type="text" name="user_email">
						<span class="focus-input100" data-placeholder="Email"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="user_password">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>

					<div class="container-login-form-btn">
						<div class="wrap-login-form-btn">
							<div class="login-form-bgbtn"></div>
							<button class="login-form-btn">
								Login
							</button>
						</div>
					</div>
				</form>

				<div class="text-center linkLogin">
					<span class="txt1">
						Did you forget the password?
					</span>
					<a class="txt2" href="{{ asset('/forgotPassword') }}">
						Forgot Password
					</a>
				</div>
			</div>
		</div>
	</div>
@endsection
