@extends('client.layout.client')

@section('content')
<div class="page-header-voter -i navbar navbar-fixed-top">
	<div class="page-header-inner row">
		<div class="page-logo col-md-3">
			<a href="{{url('/')}}">
			    <img width="100" src="{{asset('assets/img/favicon_dark.png')}}" alt="logo" class="logo-default"/>
            </a>            
        </div>
        <div class="voter-title col-md-6 col-xs-12 text-center">
            <h2>{{$ballots->data[0]->board}}</h2>
            <h4>{{$ballots->data[0]->election}}</h4>
        </div>
        
        <div class="top-menu col-md-3">
            <h2 style="margin-right:20px;">{{$ballots->data[0]->address}}</h2>
            <h4>{{date("l F j Y")}}</h4>
		</div>
	</div>
</div>
<div class="page-container">
	<div class="page-content-wrapper" style="background-color: #e0e5ec;">
		<div class="page-content-fullwidth row">
            <div class="col-md-4">
                <div class="guide-desc-header">
                    <h2>{{$ballots->data[0]->board}}</h2>
                    <h4>You can see result that you have done by now.</h4>
                </div>
                <div class="guide-desc-body">
                    <h4>Read each name and review each selection carefully. When you are done, press the "Cast my vote" button. If you wish you can edit the voting result by clicking race names.</h4>
                </div>
            </div>
            <div class="col-md-8">
                <div class="guide-desc-header">
                    <h2>Review your choices.</h2>
                    <h2>{{$ballots->data[0]->board}}</h2>
                </div>
                
                <form class="guide-desc-body race-voter scroller" method="post" action="{{ url('client/cast') }}" style="height: auto; max-height: 600px;">
                    @csrf
                    <div class="form-group row" style="margin-left:25px;">
                        <div class="col-md-6" style="margin-top: 16px;">
                        @if(count($totalrace) != 0)
                            @foreach($totalrace as $rkey=>$race)
                                @if($race['race_type'] != "R")
                                    <h4 style="cursor:pointer" onclick="govote({{$rkey}})">Candidates For: {{$race['race_title']}}.</h4>
                                    @if(count($race['candidates']) != 0)
                                    @foreach($race['candidates'] as $key=>$candidate)
                                    <div class="form-group row">
                                        <div class="md-checkbox col-md-3">
                                            <input type="checkbox" id="checkbox{{$key}}" name="{{$key}}" value="{{$candidate}}" class="md-check" checked disabled>
                                            <label for="checkbox{{$key}}">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            {{$candidate}}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                            No Candidate
                                    @endif
                                @else
                                    <h4 style="cursor:pointer" onclick="govote({{$rkey}})">Candidates For: {{$race['race_title']}}.</h4>
                                    <?php 
                                        $zcnt=0;
                                    ?>
                                    @foreach($race['candidates'] as $key=>$candidate)
                                    @if($candidate != 0)
                                    <div class="form-group row">
                                        <div class="col-md-3">{{explode('-', $key)[1]}}</div>
                                        <div class="col-md-3">{{$candidate}}</div>
                                    </div>
                                    @else
                                    <?php 
                                        $zcnt++;
                                    ?>                            
                                    @endif
                                    @endforeach
                                    {{ $zcnt==count($race['candidates']) ? 'No Candidate' : ''}}
                                @endif
                            @endforeach
                        @else
                            No Candidate
                        @endif
                        </div>

                        <div class="col-md-6" style="float: left;">
                        @foreach(session('props') as $key=>$prop)
                            <h2> {{$prop->prop_title}}</h2>
                            <h4 style="cursor:pointer" onclick="goprop()">{{$prop->prop_text}}</h4>
                            @if(count(session('propresult')) != 0)
                                @foreach(session('propresult') as $resultkey=>$resultprop)
                                    @if($prop->proposition_id == $resultkey)
                                        {{$resultprop}}
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        @foreach(session('mass') as $key=>$prop)
                            <h2> {{$prop->prop_title}}</h2>
                            <h4 style="cursor:pointer" onclick="gomass()">{{$prop->prop_text}}</h4>
                            @if(count(session('massresult')) != 0)
                                @foreach(session('massresult') as $resultkey=>$resultprop)
                                    @if($prop->proposition_id == $resultkey)
                                        {{$resultprop}}
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        </div>
                    </div>
                </form>
            </div>
		</div>
	</div>
</div>
<div class="page-footer-voter row" style="text-align:center; padding-top: 35px; color:white;">
	<div class="col-sm-12 col-md-3 col-xs-3" style="padding: 0px;">
        <button type="button" class="btn-review" onclick="gomass()">Go Back</button>
    </div>
    <div class="col-sm-12 col-md-3 col-xs-3" style="padding: 0px;">
        <button type="button" class="btn-voter-back">Cancel Ballot</button>
	</div>
    <div class="col-sm-12 col-md-3 col-xs-3" style="padding: 0px;">
    </div>
    <div class="col-sm-12 col-md-3 col-xs-3" style="padding: 0px;">
        <button type="button" class="btn-voter">Cast my bote</button>
	</div>
</div>
@endsection
@section('script')
<script>
    function govote(key) {
        window.location.href="{{url('/client/back')}}"+'/'+key;
    }
    function goprop() {
        window.location.href="{{url('/client/prop')}}";
    }
    function gomass() {
        window.location.href="{{url('/client/mass')}}";
    }
    $('.btn-voter').click(function(){
            var divContents = $(".race-voter").html();
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>Vote Result</title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
            $ ('.race-voter').submit();
    });
    $('.btn-voter-back').click(function(){
        window.location.href="{{url('/')}}";
    });
    function returnvote(){
        window.location.href="{{url('client/returnvote')}}";
    };
</script>
@endsection