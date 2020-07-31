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
<link href="{{asset('/assets/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('/assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('/assets/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('/assets/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<link href="{{asset('/assets/css/components.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('/assets/admin/pages/css/login3.css')}}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="{{asset('/assets/jquery-nestable/jquery.nestable.css')}}"/>
<link href="{{asset('/assets/admin/layout/css/layout.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('/assets/admin/layout/css/themes/darkblue.css')}}" rel="stylesheet" type="text/css" id="style_color"/>
<link href="{{asset('/assets/admin/layout/css/custom.css')}}" rel="stylesheet" type="text/css"/>

</head>
<body class="page-header-fixed">

@yield('content')

<script src="{{asset('/assets/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/jquery-migrate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/jquery.cokie.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{asset('/assets/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('/assets/select2/select2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/fuelux/js/spinner.min.js')}}"></script>
<script src="{{asset('/assets/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/jquery-nestable/jquery.nestable.js')}}"></script>
<script src="{{asset('/assets/admin/layout/scripts/layout.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/layout/scripts/demo.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/layout/scripts/metronic.js')}}" type="text/javascript"></script>
<script src="{{asset('/assets/admin/pages/scripts/login.js')}}" type="text/javascript"></script>
<script>
    $(function(){
        $('.page-content-fullwidth').css({ height: $(window).innerHeight()-$('.page-footer-voter').outerHeight()-$('.page-header-voter').outerHeight()-$('.guide-desc-header').height()});
        $('.slimScrollDiv').css({ height: $(window).innerHeight()-$('.page-footer-voter').outerHeight()-$('.page-header-voter').outerHeight()-$('.guide-desc-header').height()});
        $('.scroller').css({ height: $(window).innerHeight()-$('.page-footer-voter').outerHeight()-$('.page-header-voter').outerHeight()-$('.guide-desc-header').height()});
        $('.cast').css({ height: $(window).innerHeight()});
        $(window).resize(function(){
            $('.page-content-fullwidth').css({ height: $(window).innerHeight()-$('.page-footer-voter').outerHeight()-$('.page-header-voter').outerHeight()-$('.guide-desc-header').height()});
            $('.slimScrollDiv').css({ height: $(window).innerHeight()-$('.page-footer-voter').outerHeight()-$('.page-header-voter').outerHeight()-$('.guide-desc-header').height()});
            $('.scroller').css({ height: $(window).innerHeight()-$('.page-footer-voter').outerHeight()-$('.page-header-voter').outerHeight()-$('.guide-desc-header').height()});
            $('.cast').css({ height: $(window).innerHeight()});
        });
    });
    jQuery(document).ready(function() {   
        Metronic.init();
    });
</script>
@yield('script')
</body>
</html>