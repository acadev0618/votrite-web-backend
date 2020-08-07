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
<div class="page-container" style="margin-top: 0px;">
	<div class="page-content-wrapper" style="background-color: #e0e5ec;">
		<div class="page-content-fullwidth" style="margin-top: 128px;">
            <div class="col-md-4 col-xs-12">
                <div class="guide-desc-header">
                    <h2>{{$ballots->data[0]->board}}</h2>
                </div>
                <div class="guide-desc-body">
                <h4>To vote, touch a "YES" or "NO" or "FOR" or "AGAINST" button. A check mark will appear to confirm your selection. To unselect the answer, touch it again. When you are done, touch the "Next" button to continue to the next screen. Touch the "Skip" button to skip.</h4>
                </div>
            </div>
            <div class="col-md-8 col-xs-12">
                <form class="guide-desc-body race-voter" method="post" action="{{ url('client/masscount') }}" style="height: 60%;">
                    @csrf
                    <div class="form-group ">
                        <input type="hidden" name="ballot_id" value="{{$ballots->data[0]->ballot_id}}" />
                        @if(count(session('mass')) != 0)
                        @foreach(session('mass') as $key=>$prop)
                        <h2> {{$prop->prop_title}}</h2>
                        <h4>{{$prop->prop_text}}</h4>
                        @if($prop->prop_answer_type == 1)
                        <div class="form-group row" style="margin-left: 20px;">
                            <div class="md-checkbox col-md-3">
                                @if(array_key_exists($prop->proposition_id,session('massresult')))
                                @if(session('massresult')[$prop->proposition_id]=='yes')
                                <input type="checkbox" id="checkboxyes{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="yes" class="md-check" checked>
                                @else
                                <input type="checkbox" id="checkboxyes{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="yes" class="md-check">
                                @endif
                                @else
                                <input type="checkbox" id="checkboxyes{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="yes" class="md-check">
                                @endif
                                <label for="checkboxyes{{$prop->proposition_id}}">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>
                                YES</label>
                            </div>
                            <div class="md-checkbox col-md-3">
                                @if(array_key_exists($prop->proposition_id,session('massresult')))
                                @if(session('massresult')[$prop->proposition_id]=='no')
                                <input type="checkbox" id="checkboxno{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="no" class="md-check" checked>
                                @else
                                <input type="checkbox" id="checkboxno{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="no" class="md-check">
                                @endif
                                @else
                                <input type="checkbox" id="checkboxno{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="no" class="md-check">
                                @endif
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
                                @if(array_key_exists($prop->proposition_id,session('massresult')))
                                @if(session('massresult')[$prop->proposition_id]=='for')
                                <input type="checkbox" id="checkboxfor{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="for" class="md-check" checked>
                                @else
                                <input type="checkbox" id="checkboxfor{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="for" class="md-check">
                                @endif
                                @else
                                <input type="checkbox" id="checkboxfor{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="for" class="md-check">
                                @endif
                                <label for="checkboxfor{{$prop->proposition_id}}">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>
                                FOR</label>
                            </div>
                            <div class="md-checkbox col-md-3">
                                @if(array_key_exists($prop->proposition_id,session('massresult')))
                                @if(session('massresult')[$prop->proposition_id]=='against')
                                <input type="checkbox" id="checkboxagainst{{$prop->proposition_id}}" name="{$prop->proposition_id}}" value="against" class="md-check" checked>
                                @else
                                <input type="checkbox" id="checkboxagainst{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="against" class="md-check">
                                @endif
                                @else
                                <input type="checkbox" id="checkboxagainst{{$prop->proposition_id}}" name="{{$prop->proposition_id}}" value="against" class="md-check">
                                @endif
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
            </div>
		</div>
	</div>
</div>
<div class="page-footer-voter" style="text-align:center; padding-top: 35px; color:white; position: absolute; width: 100%;">
    <div class="col-md-3 col-xs-3" style="padding: 0px;">
        <button type="button" class="btn-voter-back">Go Back</button>
	</div>
	<div class="col-md-3 col-xs-3" style="padding: 0px;">
    @if(session('showreview'))
        <button type="button" class="btn-review">Return to review</button>
    @else
        <button type="button" class="btn-skip">Skip</button>
    @endif
    </div>
    <div class="col-md-3 col-xs-3" style="padding: 0px;">
        <h4>{{session('totalcnt')}} of {{session('totalcnt')}}</h4>
    </div>
    <div class="col-md-3 col-xs-3" style="padding: 0px;">
        <button type="button" class="btn-voter">Next</button>
	</div>
</div>
<form class="guide-desc-body race-voter-skip" method="post" action="{{ url('client/masscount') }}" style="height: 60%;display:none;">
    @csrf
    <div class="form-group ">
        <input type="hidden" name="ballot_id" value="{{$ballots->data[0]->ballot_id}}" />
        
    </div>
</form>
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
        $.ajax({
            type: 'post',
            url: "{{ url('client/updatemass') }}",
            data: $('form').serialize(),
            success: function () {
                console.log('form was submitted');
            }
        });
    });

    $('.btn-voter').click(function(){
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
    });

    $('.btn-voter-back').click(function(){
        goprop();
    });

    $('.btn-review').click(function(){
        window.location.href="{{url('client/review')}}";
    });

    $('.btn-skip').click(function(){
        $ ('.race-voter-skip').submit();
    });

    function goprop() {
        window.location.href="{{url('/client/prop')}}";
    }
</script>
@endsection