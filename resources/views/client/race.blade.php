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
                <div class="guide-desc-header text-center">
                    <h2>{{$ballots->data[0]->board}}</h2>
                    <h4>You have <strong id="maxvotes">{{$races[0]->max_num_of_votes ?? 0}}</strong> choice remaining.</h4>
                </div>
                <div class="guide-desc-body">
                    @if($races[0]->race_type != "R")
                    <h4>To vote, touch a name. A check mark will appear to confirm your selection. To unselect the name, touch it again. When you are done, touch the "Next" button to continue to next screen. Touch the "Skip" button to skip. Touch the "Write-In Candidate" button to add other candidates.</h4>
                    @else
                    <h4>To vote, touch a plus or minus button. A changing value will appear to confirm your selection. Please input other value for each candidate. When you are done, touch the "Next" button to continue to next screen. Touch the "Skip" button to skip. Touch the "Write-In Candidate" button to add other candidates.</h4>
                    @endif
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="guide-desc-header text-center">
                    <h2>Candidates for : {{$races[0]->race_title}}</h2>
                    @if($races[0]->min_num_of_votes == null || $races[0]->min_num_of_votes == 0)
                        <h4>Vote for No less than 0, Vote for No more than {{$races[0]->max_num_of_votes ?? 0}}</h4>
                    @else 
                        @if($races[0]->max_num_of_votes == null || $races[0]->max_num_of_votes == 0)
                            <h4>Vote for No less than {{$races[0]->min_num_of_votes ?? 0}}, Vote for No more than 0</h4>
                        @else
                        <h4>Vote for No less than {{$races[0]->min_num_of_votes}}, Vote for No more than {{$races[0]->max_num_of_votes}}</h4>
                        @endif
                    @endif
                </div>                
                <form class="guide-desc-body race-voter" method="post" action="{{ url('client/racecount') }}" style="height: 60%;">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="ballot_id" value="{{$ballots->data[0]->ballot_id}}" />
                        <input type="hidden" name="race_id" value="{{$races[0]->race_id}}" />
                        @if(count(get_object_vars($candidates)) != 0)
                            @if($races[0]->race_type != "R")
                                @foreach($candidates->data as $key=>$candidate)
                                <div class="form-group row" style="margin-left: 25px;">
                                    <div class="md-checkbox col-md-4 col-xs-6">
                                        <?php
                                            $vraceresult = session('raceresult');
                                        ?>
                                        @if(array_key_exists($races[0]->race_id,$vraceresult))
                                            @if(array_key_exists($candidate->candidate_id,$vraceresult[$races[0]->race_id]))
                                                <input type="checkbox" id="checkbox{{$key}}" name="{{$candidate->candidate_id}}" value="{{$candidate->candidate_name}}" class="md-check" checked>
                                            @else
                                                <input type="checkbox" id="checkbox{{$key}}" name="{{$candidate->candidate_id}}" value="{{$candidate->candidate_name}}" class="md-check">
                                            @endif
                                        @else
                                            <input type="checkbox" id="checkbox{{$key}}" name="{{$candidate->candidate_id}}" value="{{$candidate->candidate_name}}" class="md-check">
                                        @endif
                                        <label for="checkbox{{$key}}">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            {{$candidate->candidate_name}}
                                        </label>
                                    </div>
                                    <div class="col-md-8 col-xs-6" style="margin-top: 15px;">
                                        @if($candidate->party_logo == null)
                                        <img alt="" class="img-circle" width="30" src="/assets/img/favicon_dark.png">
                                        @else
                                        <img alt="" class="img-circle" width="30" src="{{$candidate->party_logo}}">
                                        @endif
                                        @if($candidate->photo == null)
                                        <img alt="" class="img-circle" width="30" src="/assets/img/favicon_dark.png">
                                        @else
                                        <img alt="" class="img-circle" width="30" src="{{$candidate->photo}}">
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            @else
                                @foreach($candidates->data as $key=>$candidate)
                                <div class="form-group row">
                                    <label class="control-label col-md-3">{{$candidate->candidate_name}}</label>
                                    <div class="spinner col-md-9">
                                        <div class="input-group" style="width:150px;">
                                            <div class="spinner-buttons input-group-btn">
                                                <button type="button" class="btn spinner-up blue">
                                                <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                            <?php
                                                $vraceresult = session('raceresult');
                                                $name = $candidate->candidate_name;
                                                $cand_name = str_replace(' ', '_', $name);
                                            ?>
                                            @if(count($vraceresult) == 0)
                                                <input type="text" class="spinner-input form-control text-center" data-id="1" name="{{$candidate->candidate_id}}-{{$cand_name}}" value="0" maxlength="3" readonly>
                                            @else
                                                @if(array_key_exists($races[0]->race_id, $vraceresult))
                                                <?php if(count($vraceresult[$races[0]->race_id]) != 0) { ?>
                                                    <input type="text" class="spinner-input form-control text-center" data-id="2" name="{{$candidate->candidate_id}}-{{$cand_name}}" value="{{$vraceresult[$races[0]->race_id][$candidate->candidate_id.'-'.$cand_name]}}" maxlength="3" readonly>
                                                <?php } else { ?>
                                                    <input type="text" class="spinner-input form-control text-center" data-id="3" name="{{$candidate->candidate_id}}-{{$cand_name}}" value="0" maxlength="3" readonly>
                                                <?php } ?>    
                                                @else
                                                    <input type="text" class="spinner-input form-control text-center" data-id="3" name="{{$candidate->candidate_id}}-{{$cand_name}}" value="0" maxlength="3" readonly>
                                                @endif
                                            @endif
                                            <div class="spinner-buttons input-group-btn">
                                                <button type="button" class="btn spinner-down red">
                                                <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        @else
                        <h4>
                            No Selected
                        </h4>
                        @endif
                    </div>
                </form>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="form-group form-md-line-input has-info col-md-5">
                    <input type="text" class="form-control" id="form_control_1" placeholder="Other Candidate">
                    <label for="form_control_1"></label>
                </div>
                <div class="col-md-3 text-center">
                    <button type="button" class="btn-voter-else">WRITE - IN CANDIDATE</button>
                </div>
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
        <h4>{{session('current')+1}} of {{session('totalcnt')}}</h4>
    </div>
    <div class="col-md-3 col-xs-3" style="padding: 0px;">
        <button type="button" class="btn-voter">Next</button>
	</div>
</div>
<form class="guide-desc-body race-voter-skip" method="post" action="{{ url('client/racecount') }}" style="height: 60%;display:none;">
    @csrf
    <div class="form-group">
        <input type="hidden" name="ballot_id" value="{{$ballots->data[0]->ballot_id}}" />
        <input type="hidden" name="race_id" value="{{$races[0]->race_id}}" />
    </div>
</form>
@endsection
@section('script')
<script>
    @if(count(get_object_vars($candidates)) != 0)
        var max_num_of_write_ins = 0;
        var max = {{$races[0]->max_num_of_votes ?? 0}};
        var min = {{$races[0]->min_num_of_votes ?? 0}};
        
        @if($races[0]->race_type != "R")    
            jQuery(document).ready(function() {   
                if($('.md-check:checked').length < min){
                    $('.btn-voter').hide();
                }else{
                    $('.btn-voter').show();
                }
            });  
            $('.md-check').change(function(e){
                e.preventDefault();
                
                if($('.md-check:checked').length >= min){
                    $('.btn-voter').show();
                }else{
                    $('.btn-voter').hide();
                }
                if($('.md-check:checked').length > max){
                    $(this).attr('checked',false);
                }else{
                    $.ajax({
                        type: 'post',
                        url: "{{ url('client/updaterace') }}",
                        data: $('form').serialize(),
                        success: function () {
                            console.log('form was submitted');
                        }
                    });
                    $('strong').text(max-$('.md-check:checked').length);
                }
            });
            $('.btn-voter-else').click(function(){
                if(max_num_of_write_ins < {{$races[0]->max_num_of_write_ins}}  && $('#form_control_1').val() != ''){
                    var order = {
                                    "ballot_id": {{$ballots->data[0]->ballot_id}},
                                    "race_id": {{$races[0]->race_id}},
                                    "candidate_name": $('#form_control_1').val(),
                                    "party_id" : {{$races[0]->race_id}}
                                }
                    $.ajax({
                        type: 'POST',
                        url: "{{env('API').'/candidate/create'}}",
                        crossDomain: true,
                        data: JSON.stringify(order),
                        dataType: 'json',
                        success: function(responseData, textStatus, jqXHR) {
                            console.log(responseData.message);
                            $("form.race-voter > div").append('<div class="form-group row" style="margin-left: 25px;">\
                                    <div class="md-checkbox col-md-3">\
                                        <input type="checkbox" id="checkbox" name="'+responseData.message+'" value="'+$('#form_control_1').val()+'" class="md-check">\
                                        <label for="checkbox">\
                                        <span></span>\
                                        <span class="check"></span>\
                                        <span class="box"></span>\
                                        '+$('#form_control_1').val()+'</label>\
                                    </div>\
                                    <div class="x col-md-9" style="margin-top: 15px;">\
                                        <img alt="" class="img-circle" width="30" src="/assets/img/favicon_dark.png">\
                                        <img alt="" class="img-circle" width="30" src="/assets/img/favicon_dark.png">\
                                    </div>\
                                </div>');
                        }
                    });	
                    max_num_of_write_ins++;
                }else{
                    toastr['warning']('Over max write in');
                }
            });
            $('.btn-voter').click(function(){
                var duplicate = true;
                var dspin = 0;
                var candid = [];
                $('.spinner-input').each(function(){
                    if($(this).val() != 0){
                        if(candid.indexOf($(this).val()) != -1){
                            duplicate = false;
                        }
                        candid.push($(this).val());
                        dspin++;
                    }
                });
                if(duplicate){
                    $ ('.race-voter').submit();
                }else{
                    toastr['warning']('Please check duplicate');
                }
            });
        @else
            jQuery(document).ready(function() {   
                var qspin = 0;
                $('.spinner-input').each(function(){
                    if($(this).val() != 0){
                        qspin ++;
                    }
                });
                if(qspin < min){
                    $('.btn-voter').hide();
                }else{
                    $('.btn-voter').show();
                }
            }); 
            $('.spinner').spinner({value:0, min: 0, max: max + {{$races[0]->max_num_of_write_ins}}});
            $('.spinner-buttons').click(function(){
                var spin = 0;
                $('.spinner-input').each(function(){
                    if($(this).val() != 0){
                        spin ++;
                    }
                });
                $('#maxvotes').text(max-spin);
                if(spin<min){
                    $('.btn-voter').hide();
                } else {
                    $.ajax({
                        type: 'post',
                        url: "{{ url('client/updaterace') }}",
                        data: $('form').serialize(),
                        success: function () {
                            console.log('form was submitted');
                        }
                    });
                    $('.btn-voter').show();
                }
            });
            $('.btn-voter-else').click(function(){
                if(max_num_of_write_ins < {{$races[0]->max_num_of_write_ins}} && $('#form_control_1').val() != ''){
                    var order = {
                                "ballot_id": {{$ballots->data[0]->ballot_id}},
                                "race_id": {{$races[0]->race_id}},
                                "candidate_name": $('#form_control_1').val(),
                                "party_id" : {{$races[0]->race_id}}
                            }
                    $.ajax({
                    type: 'POST',
                    url: "{{env('API').'/candidate/create'}}",
                    crossDomain: true,
                    data: JSON.stringify(order),
                    dataType: 'json',
                    success: function(responseData, textStatus, jqXHR) {
                        $("form.race-voter > div").append('<div class="form-group row">\
                            <label class="control-label col-md-3">'+$('#form_control_1').val()+'</label>\
                            <div class="spinner col-md-9">\
                                <div class="input-group" style="width:150px;">\
                                    <div class="spinner-buttons input-group-btn">\
                                        <button type="button" class="btn spinner-up blue">\
                                        <i class="fa fa-plus"></i>\
                                        </button>\
                                    </div>\
                                    <input type="text" class="spinner-input form-control" name="'+responseData.message+'-'+$('#form_control_1').val()+'" value="0" maxlength="3" readonly>\
                                    <div class="spinner-buttons input-group-btn">\
                                        <button type="button" class="btn spinner-down red">\
                                        <i class="fa fa-minus"></i>\
                                        </button>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>');
                    }
                    });	
                    max_num_of_write_ins++;

                }else{
                    toastr['warning']('Over max write in');
                }
            });
            $('.btn-voter').click(function(){
                var duplicate = true;
                var overval = true;
                var dspin = 0;
                var candid = [];
                $('.spinner-input').each(function(){
                    if($(this).val() != 0){
                        if(candid.indexOf($(this).val()) != -1){
                            duplicate = false;
                        }
                        candid.push($(this).val());
                        dspin++;
                    }
                    if($(this).val() > max + {{$races[0]->max_num_of_write_ins}}){
                        overval = false;
                    }
                });
                if(duplicate && dspin>=min && dspin <= max && overval){
                    $ ('.race-voter').submit();
                }else{
                    if(overval){
                        toastr['warning']('Please check duplicate');
                    }else{
                        toastr['warning']('Please check Over values');
                    }
                }
            });
        @endif
    @endif
    
    $('.btn-voter-back').click(function(){
        $ ('.race-voter').attr('action', "{{ url('client/racedecount') }}");
        $ ('.race-voter').submit();
    });
    $('.btn-review').click(function(){
        window.location.href="{{url('client/review')}}";
    });
    $('.btn-skip').click(function(){
        $ ('.race-voter-skip').submit();
    });
    
</script>
@endsection