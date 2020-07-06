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
                <h4>To vote, touch a YES/NO or FOR/AGAINST button. To unselect the answer, touch it again. When you are done, touch the "Next" button to continue to next screen.</h4>
                </div>
            </div>
            <div class="col-md-8">
                <div class="guide-desc-header">
                    
                </div>
                <form class="guide-desc-body race-voter" method="post" action="{{ url('client/masscount') }}">
                    @csrf
                    <div class="form-group scroller" style="height: 300px;">
                        <input type="hidden" name="ballot_id" value="{{$ballots->data[0]->ballot_id}}" />
                        @if(count(session('mass')) != 0)
                        @foreach(session('mass') as $key=>$prop)
                        <h2> {{$prop->prop_title}}</h2>
                        <h4>{{$prop->prop_text}}</h4>
                        @if($prop->prop_answer_type == 1)
                        <div class="form-group row" style="margin-left: 20px;">
                            <div class="md-checkbox col-md-3">
                                <input type="checkbox" id="checkboxyes{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="yes" class="md-check">
                                <label for="checkboxyes{{$prop->proposition_id}}">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>
                                YES</label>
                            </div>
                            <div class="md-checkbox col-md-3">
                                <input type="checkbox" id="checkboxno{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="no" class="md-check">
                                <label for="checkboxno{{$prop->proposition_id}}">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>
                                NO</label>
                            </div>
                        </div>
                        @else
                        <div class="form-group row" style="margin-left: 20px;">
                            <div class="md-checkbox col-md-3">
                                <input type="checkbox" id="checkboxfor{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="for" class="md-check">
                                <label for="checkboxfor{{$prop->proposition_id}}">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>
                                FOR</label>
                            </div>
                            <div class="md-checkbox col-md-3">
                                <input type="checkbox" id="checkboxagainst{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="against" class="md-check">
                                <label for="checkboxagainst{{$prop->proposition_id}}">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>
                                AGAINST</label>
                            </div>
                        </div>
                        @endif
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
        <button href="{{url('client/review')}}" type="button" class="btn-review">Review your choice</button>
    </div>
    <div class="col-md-3 col-xs-3">
        <button type="button" class="btn-voter-back">Back</button>
	</div>
    <div class="col-md-3 col-xs-3">
        <h4>{{session('current')+1}} of {{session('totalcnt')}}</h4>
    </div>
    <div class="col-md-3 col-xs-3">
        <button type="button" class="btn-voter">Next</button>
	</div>
</div>
<!-- END FOOTER -->
@endsection
@section('script')
<script>
    var precheck = null;
    $('input.md-check').change(function(e){
        e.preventDefault();
        $(e.target).parent().parent().find('.md-check').attr('checked', false);
        if($(this).attr('id') == precheck){
            $(this).attr('checked',false);
            precheck = null;
        }else{
            $(this).attr('checked',true);
            precheck = $(this).attr('id');
        }
    });
    $('.btn-voter').click(function(){
        // if($('input[name=radio]:checked').length == 0){
        //     toastr['warning']('Please select one');
        // }else{
            var duplicate = true;
            var candid = [];
            $('.spinner-input').each(function(){
                if(candid.indexOf($(this).val()) != -1){
                    duplicate = false;
                }
                candid.push($(this).val());
            });
            if(duplicate){
                $ ('.race-voter').submit();
            }
        // }
    });
    $('.btn-voter-back').click(function(){
        window.location.href="{{url('client/prop')}}";
    });
    $('.btn-review').click(function(){
        window.location.href="{{url('client/review')}}";
    });
</script>
@endsection