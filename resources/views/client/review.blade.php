@extends('client.layout.client')

@section('content')
<!-- BEGIN HEADER -->
<div class="page-header-voter -i navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner row">
		<!-- BEGIN LOGO -->
		<div class="page-logo col-md-3">
			<a href="{{url('/')}}">
			    <img width="100" src="{{asset('assets/img/favicon_dark.png')}}" alt="logo" class="logo-default"/>
            </a>            
        </div>
        <div class="voter-title col-md-6 col-xs-12 text-center">
            <h2>{{$ballots->data[0]->board}}</h2>
            <h4>{{$ballots->data[0]->election}}</h4>
        </div>
		<!-- END LOGO -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <!-- <h2>N. Y. S. Board of Elections</h2>
        <h4>Statewide Races</h4> -->
        
        <div class="top-menu col-md-3">
            <h2 style="margin-right:20px;">{{$ballots->data[0]->address}}</h2>
            <h4>{{date("l F j Y")}}</h4>
		</div>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END HEADER INNER -->
</div>
<div class="page-container">
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper" style="background-color: #e0e5ec;">
		<div class="page-content-fullwidth">
            <div class="col-md-4 col-xs-0">
                <div class="guide-desc-header">
                    <h2>{{$ballots->data[0]->board}}</h2>
                    <h4>You have  choice remaining.</h4>
                </div>
                <div class="guide-desc-body">
                    <h4>This shows your voting records. When you are done, touch the "Next" button to continue to next screen.</h4>
                </div>
            </div>
            <div class="col-md-8">
                <div class="guide-desc-header">
                    <h2>Review your choices.</h2>
                    <h2>{{$ballots->data[0]->board}}</h2>
                </div>
                
                <form class="guide-desc-body race-voter scroller" method="post" action="{{ url('client/cast') }}" style="height: auto; max-height: 600px;">
                    @csrf
                    <div class="form-group" style="margin-left:25px;">
                    @if(count($totalrace) != 0)
                    @foreach($totalrace as $race)
                        @if($race['race_type'] != "R")
                            <h4>Candidates For: {{$race['race_title']}}.</h4>
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
                            <h4>Candidates For: {{$race['race_title']}}.</h4>
                            @foreach($race['candidates'] as $key=>$candidate)
                            <div class="form-group row">
                                <div class="col-md-3">{{explode('-', $key)[1]}}</div>
                                <div class="col-md-3">{{$candidate}}</div>
                            </div>
                            @endforeach
                        @endif
                    @endforeach
                    @else
                    No Candidate
                    @endif
                    @if(count(session('propresult')) != 0)
                    @foreach(session('props') as $key=>$prop)
                    <h2> {{$prop->prop_title}}</h2>
                    <h4>{{$prop->prop_text}}</h4>
                    @foreach(session('propresult') as $resultkey=>$resultprop)
                    @if($prop->proposition_id == $resultkey)
                    {{$resultprop}}
                    @endif
                    @endforeach
                    @endforeach
                    @endif
                    @if(count(session('massresult')) != 0)
                    @foreach(session('mass') as $key=>$prop)
                    <h2> {{$prop->prop_title}}</h2>
                    <h4>{{$prop->prop_text}}</h4>
                    @foreach(session('massresult') as $resultkey=>$resultprop)
                    @if($prop->proposition_id == $resultkey)
                    {{$resultprop}}
                    @endif
                    @endforeach
                    @endforeach
                    @endif
                    </div>
                </form>
                <!-- <div class="dd" id="nestable_list_1">
                    <ol class="dd-list">
                        <li class="dd-item" data-id="13">
                            <div class="dd-handle">
                                Item 13
                            </div>
                        </li>
                        <li class="dd-item" data-id="14">
                            <div class="dd-handle">
                                Item 14
                            </div>
                        </li>
                        <li class="dd-item" data-id="15">
                            <div class="dd-handle">
                                Item 15
                            </div>
                        </li>
                    </ol>
                </div> -->
                <!-- <textarea id="nestable_list_1_output" class="form-control col-md-12 margin-bottom-10"></textarea> -->
            </div>
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- BEGIN FOOTER -->
<div class="page-footer-voter" style="text-align:center;padding-top: 35px;color:white;">
	<div class="col-md-3 col-xs-3">
        <button href="{{url('/')}}" type="button" class="btn-review">Return to Voting</button>
    </div>
    <div class="col-md-3 col-xs-3">
        <button type="button" class="btn-voter-back">Cancel Ballot</button>
	</div>
    <div class="col-md-3 col-xs-3">
    </div>
    <div class="col-md-3 col-xs-3">
        <button type="button" class="btn-voter">Accept and Print</button>
	</div>
</div>
<!-- END FOOTER -->
@endsection
@section('script')
<script>
   
    $('.btn-voter').click(function(){
        // if($('input[name=radio]:checked').length == 0){
        //     toastr['warning']('Please select one');
        // }else{
            // var duplicate = true;
            // var candid = [];
            // $('.spinner-input').each(function(){
            //     if(candid.indexOf($(this).val()) != -1){
            //         duplicate = false;
            //     }
            //     candid.push($(this).val());
            // });
            // if(duplicate){
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
            // }
        // }
    });
    $('.btn-voter-back').click(function(){
        window.location.href="{{url('/')}}";
    });
    $('.btn-review').click(function(){
        window.location.href="{{url('/')}}";
    });
</script>
@endsection