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

				var order = {
					"user_password": newpwd,
					"keys": {"user_id":parseInt(userid)}
				}
				console.log(order);
				$.ajax({
				    type: 'POST',
					url: baseurl+'user/update',
					crossDomain: true,
					data: JSON.stringify(order),
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
		@if(old('message'))
			var type = "{{ old('alert-type', 'info') }}";
			switch(type){
				case 'info':
					toastr.info("{{ old('message') }}");
					break;
				
				case 'warning':
					toastr.warning("{{ old('message') }}");
					break;

				case 'success':
					toastr.success("{{ old('message') }}");
					break;

				case 'error':
					toastr.error("{{ old('message') }}");
					break;
			}
		@endif
	</script>
</body>
</html>