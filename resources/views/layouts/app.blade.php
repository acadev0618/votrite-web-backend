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

	<script>
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