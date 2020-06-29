@extends('client.layout.client')

@section('content')
<!-- BEGIN HEADER -->
<div class="page-header-voter -i navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="index.html">
			    <img width="100" src="{{asset('assets/img/favicon_dark.png')}}" alt="logo" class="logo-default"/>
            </a>            
        </div>
        <div class="voter-title">
            <h2>Choose Language</h2>
            <!-- <h4>Statewide Races</h4> -->
        </div>
		<!-- END LOGO -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <!-- <h2>N. Y. S. Board of Elections</h2>
        <h4>Statewide Races</h4> -->
        
        <div class="top-menu">
            <!-- <h2>N. Y. S. Board of Elections</h2>
            <h4>Statewide Races</h4> -->
		</div>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END HEADER INNER -->
</div>
<div class="page-container">
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper" style="background-color: #e0e5ec;">
		<div class="page-content-fullwidth">
            <div class="col-md-4">

            </div>
            <form class="col-md-4 scroller ballot-voter" role="form" method="get" action="{{ url('client/viewcand') }}" style="height: 700px;">
                <!-- @csrf -->
                <input type="hidden" name="ballot_id" value="{{$ballot_id}}">
                <div class="md-radio">
                    <input type="radio" id="radioen" name="radio" class="md-radiobtn" value="">
                    <label for="radioen">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>
                    1. English</label>
                </div>
                @if($languages != null)
                @foreach($languages->data as $key=>$value)
                <div class="md-radio">
                    <input type="radio" id="radio{{$value->language_code}}" name="radio" class="md-radiobtn" value="{{$value->lang_id}}">
                    <label for="radio{{$value->language_code}}">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>
                    {{$key+2}}. {{$value->language_name}}</label>
                </div>
                @endforeach
                @endif
            </form>
            <div class="col-md-4">
                
            </div>
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- BEGIN FOOTER -->
<div class="page-footer-voter" style="text-align:center;padding-top: 35px;color:white;">
	<div class="col-md-4">
    </div>
    <div class="col-md-4">
        <button type="button" class="btn-voter">Next</button>
    </div>
    <div class="col-md-4">
	</div>
</div>
<!-- END FOOTER -->
@endsection
@section('script')
<script>
    $('.btn-voter').click(function(){
        if($('input[name=radio]:checked').length == 0){
            toastr['warning']('Please select one');
        }else{
            $ ('.ballot-voter').submit();
        }
    });
</script>
@endsection