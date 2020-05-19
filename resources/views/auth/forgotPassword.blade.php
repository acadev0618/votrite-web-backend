@extends('auth.layouts')

@section('content')
	<div class="limiter">
		<div class="container-register">
			<div class="wrap-register">
                <span class="login-form-title p-b-48">
					<img src="{{ asset('assets/img/favicon_dark.png') }}" alt="logo" class="logo-default" style="width: 180px;"/>
				</span>
				<span class="p-b-26">
					<p>In order to retrieve the forgotten password, please enter the email address associated with</p>
				</span>

				<form class="register-form validate-form" method="POST" action="{{ asset('/register') }}">
					@csrf

					@if ($message = Session::get('warning'))
					<div class="alert alert-warning alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button>	
						<strong>{{ $message }}</strong>
					</div>
					@endif

					<div class="wrap-input100 validate-input" data-validate = "Valid email is: admin@gmail.com">
						<input class="input100" type="email" name="email">
						<span class="focus-input100" data-placeholder="Email"></span>
					</div>

					<div class="container-register-form-btn">
						<div class="wrap-register-form-btn">
							<div class="register-form-bgbtn"></div>
							<button class="register-form-btn">
								Submit
							</button>
						</div>
					</div>
				</form>

				<div class="text-center linkLogin">
					<span class="txt1">
						Do you want to back?
					</span>

					<a class="txt2" href="{{ asset('/') }}">
						Log in
					</a>
				</div>
			</div>
		</div>
	</div>
@endsection