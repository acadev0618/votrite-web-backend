@extends('client.layout.client')

@section('content')
<div class="page-header-voter -i navbar navbar-fixed-top">
	<div class="page-header-inner">
		<div class="page-logo col-md-3">
			<a href="{{url('/client/ballot')}}">
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
		<div class="page-content-fullwidth" style="margin-top: 120px;">
            <div class="col-md-4 col-xs-12">
                <div class="guide-desc-header">
                    <h2>{{$ballots->data[0]->board}}</h2>
                </div>
                <div class="guide-desc-body">
                    <h4>You can see result that you have done by now. Read each name and review each selection carefully. When you are done, press the "Cast my vote" button. If you wish you can edit the voting result by clicking race names.</h4>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="guide-desc-header">
                    <h2>Review your choices.</h2>
                </div>
                <form class="guide-desc-body race-voter scroller" method="post" action="{{ url('client/cast') }}" style="height: auto; width: 100px;">
                    @csrf
                    <div class="guide-desc-header">
                        <h2>{{$ballots->data[0]->board}}</h2>
                    </div>
                    <div class="form-group row" style="margin-left:25px;">
                        <h3>Candidates</h3>
                        @if(count($totalrace) != 0)
                            @foreach($totalrace as $rkey=>$race)
                                @if($race['race_type'] != "R")
                                    <div  style="margin-left: 10px;"><h4 style="cursor:pointer" onclick="gorace({{$rkey}})">Candidates For: {{$race['race_title']}}.</h4></div>
                                    @if(count($race['candidates']) != 0)
                                        @foreach($race['candidates'] as $key=>$candidate)
                                        <div class="form-group row" style="margin-left: 25px;">
                                            <div class="md-checkbox col-md-3">
                                                <input type="checkbox" id="checkbox{{$key}}" name="{{$key}}" value="{{$candidate}}" class="md-check" checked disabled>
                                                <label for="checkbox{{$key}}">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                    {{$candidate}}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                    <div class="form-group row" style="margin-left: 25px;">
                                        <h4>
                                            No selected
                                        </h4>
                                    </div>
                                    @endif
                                @else
                                    <div  style="margin-left: 10px;"><h4 style="cursor:pointer" onclick="gorace({{$rkey}})">Candidates For: {{$race['race_title']}}.</h4></div>
                                    <?php 
                                        $zcnt=0;
                                    ?>
                                    @foreach($race['candidates'] as $key=>$candidate)
                                        @if($candidate != 0)
                                        <div class="form-group row" style="margin-left: 10px;">
                                            <div class="col-md-3"><h4>{{str_replace('_', ' ', explode('-', $key)[1])}}</h4></div>
                                            <div class="col-md-3"><h4>{{$candidate}}</h4></div>
                                        </div>
                                        @else
                                        <?php 
                                            $zcnt++;
                                        ?>                            
                                        @endif
                                    @endforeach
                                    <div class="form-group row" style="margin-left: 25px;">
                                        <h4>
                                        {{ $zcnt==count($race['candidates']) ? 'No selected' : ''}}
                                        </h4>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="form-group row" style="margin-left: 25px;">
                                <h4>
                                    No selected
                                </h4>
                            <div>
                        @endif
                        <br>

                        @if(count(session('props')) != 0)
                        <h3>Propositions</h3>
                        @endif
                        @foreach(session('props') as $key=>$prop)
                            <div  style="margin-left: 10px;"><h4 style="cursor:pointer;" onclick="goprop()"> {{$prop->prop_title}}</h4></div>
                            <div class="form-group row" style="margin-left: 10px;">
                                <div class="col-md-3 col-xs-6">
                                    <h4>
                                    {{$prop->prop_text}}
                                    </h4>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                @if(count(session('propresult')) != 0)
                                        <?php 
                                            $prorecnt = 0;
                                        ?>
                                    @foreach(session('propresult') as $resultkey=>$resultprop)
                                        @if($prop->proposition_id == $resultkey)
                                        <?php 
                                            $prorecnt++;
                                        ?>
                                        <h4>
                                            {{$resultprop}}
                                        </h4>
                                        @endif
                                    @endforeach
                                    @if($prorecnt == 0)
                                    <h4>
                                        No selected
                                    </h4>
                                    @endif
                                @else
                                <h4>
                                    No selected
                                </h4>
                                @endif
                                </div>
                            </div>
                        @endforeach

                        @if(count(session('mass')) != 0)
                        <h3>Mass Propositions</h3>
                        @endif
                        @foreach(session('mass') as $key=>$prop)
                            <div  style="margin-left: 10px;"><h4 style="cursor:pointer;" onclick="gomass()"> {{$prop->prop_title}}</h4></div>
                            <div class="form-group row" style="margin-left: 10px;">
                                <div class="col-md-3 col-xs-6">
                                    <h4>
                                    {{$prop->prop_text}}
                                    </h4>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                @if(count(session('massresult')) != 0)
                                    <?php 
                                        $massrecnt = 0;
                                    ?>
                                    @foreach(session('massresult') as $resultkey=>$resultprop)
                                        @if($prop->proposition_id == $resultkey)
                                        <?php 
                                            $massrecnt++;
                                        ?>
                                        <h4>
                                            {{$resultprop}}
                                        </h4>
                                        @endif
                                    @endforeach
                                    @if($massrecnt == 0)
                                    <h4>
                                        No selected
                                    </h4>
                                    @endif
                                @else
                                <h4>
                                    No selected
                                </h4>
                                @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
		</div>
	</div>
</div>
<div class="page-footer-voter" style="text-align:center; padding-top: 35px; color:white; position: absolute; width: 100%;">
	<div class="col-md-3 col-xs-3" style="padding: 0px;">
        <button type="button" class="btn-review" onclick="govote(<?php echo session('current')-1?>)">Go Back</button>
    </div>
    <div class="col-md-3 col-xs-3" style="padding: 0px;">
        <button type="button" class="btn-voter-back">Cancel Ballot</button>
	</div>
    <div class="col-md-3 col-xs-3" style="padding: 0px;"></div>
    <div class="col-md-3 col-xs-3" style="padding: 0px;">
        <button type="button" class="btn-voter">Cast my bote</button>
	</div>
</div>
@endsection
@section('script')
<script>
    function gorace(key) {
        window.location.href="{{url('/client/backrace')}}"+'/'+key;
    }
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
        var r = confirm("Are you sure you want to cast your vote?");
        if (r == true) {
            $ ('.race-voter').submit();
        }
    });
    $('.btn-voter-back').click(function(){
        window.location.href="{{url('/client/ballot')}}";
    });
</script>
@endsection