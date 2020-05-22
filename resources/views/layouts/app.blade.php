<!DOCTYPE html>
<html lang="en">
 
<head>
    @include('common.meta')
    @include('common.css')
</head>

<body class="page-header-fixed page-quick-sidebar-over-content ">

	@include('layouts.header')
	
	<div class="page-container">
        @include('layouts.slider')

		@yield('content')
	</div>

	@include('common.js')
	@yield('script')
	<script>
		$('#changebtn').click(function(){
			var userid = $('#userid').val();
			var newpwd = $('#newpwd').val();
			var rnewpwd = $('#rnewpwd').val();
			if(newpwd == rnewpwd && newpwd != ''){

				let order = {
					"user_password": newpwd,
					"keys": {"user_id":parseInt(userid)}
				}
				console.log(order);
				$.ajax({
				    type: 'POST',
					url: baseurl+'user/update',
					crossDomain: true,
					data: order,
					dataType: 'json',
				    success: function(responseData, textStatus, jqXHR) {
				        toastr.success("Password Changed");
						window.location.href='/logout';
					},
				    error: function (responseData, textStatus, errorThrown) {
				        alert('POST failed.');
				    }
				});
			}else{
				toastr.warning("Please re-enter password");
			}
			
		});
		$('#reset').click(function(){
			$('#currentpwd').val(null);
			$('#newpwd').val(null);
			$('#rnewpwd').val(null);
		});
		@if(Session::has('message'))
			var type = "{{ Session::get('alert-type', 'info') }}";
			switch(type){
				case 'info':
					toastr.info("{{ Session::get('message') }}");
					break;
				
				case 'warning':
					toastr.warning("{{ Session::get('message') }}");
					break;

				case 'success':
					toastr.success("{{ Session::get('message') }}");
					break;

				case 'error':
					toastr.error("{{ Session::get('message') }}");
					break;
			}
		@endif
	</script>
</body>
</html>