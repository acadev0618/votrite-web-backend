@extends('client.layout.client')

@section('content')
<div class="page-header-voter -i navbar navbar-fixed-top">
	<div class="page-header-inner row">
		<div class="page-logo col-md-3">
			<a href="{{url('/client/ballot')}}">
			    <img width="100" src="{{asset('assets/img/favicon_dark.png')}}" alt="logo" class="logo-default"/>
            </a>            
        </div>
        <div class="voter-title col-md-6 col-xs-12 text-center">
            <h2>Choose Active Ballot</h2>
        </div>
        <div class="top-menu col-md-3">
		</div>
	</div>
</div>
<div class="page-container">
	<div class="page-content-wrapper" style="background-color: #e0e5ec;">
		<div class="page-content-fullwidth">
            <div class="col-md-4">

            </div>
            <form class="col-md-4 scroller ballot-voter" role="form" method="get" action="{{ url('/client') }}" style="height: 60%;">
                @if($ballots != null)
                @foreach($ballots->data as $key=>$value)
                <div class="md-radio">
                    <input type="radio" id="radio{{$value->ballot_id}}" name="radio" class="md-radiobtn" value="{{$value->ballot_id}}">
                    <label for="radio{{$value->ballot_id}}">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>
                    {{$key+1}}. {{$value->election}}</label>
                </div>
                @endforeach
                @endif
            </form>
            <div class="col-md-4">
                
            </div>
        </div>
	</div>
</div>
<div class="page-footer-voter" style="text-align:center; padding-top: 35px; color:white; position: absolute; bottom: 0; width: 100%;">
	<div class="col-md-4">
    </div>
    <div class="col-md-4">
        <button type="button" class="btn-voter">Next</button>
    </div>
    <div class="col-md-4">
	</div>
</div>
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