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
		<div class="page-content-fullwidth" style="max-height: 768px;">
            <div class="col-md-4 col-xs-0">
                <div class="guide-desc-header text-center">
                    <h2>{{$ballots->data[0]->board}}</h2>
                    <h4>You have <strong id="maxvotes">{{$races[0]->max_num_of_votes ?? 0}}</strong> choice remaining.</h4>
                </div>
                <div class="guide-desc-body">
                    @if($races[0]->race_type != "R")
                    <h4>To vote, touch a name. A check mark will appear to confirm your selection. To unselect the name, touch it again. When you are done, touch the "Next" button to continue to next screen.</h4>
                    @else
                    <h4>To vote, touch a plus or minus button. A changing value will appear to confirm your selection. Please input other value for each candidate. When you are done, touch the "Next" button to continue to next screen.</h4>
                    @endif
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="guide-desc-header text-center">
                    <h2>Candidates for : {{$races[0]->race_title}}</h2>
                    @if($races[0]->min_num_of_votes == null || $races[0]->min_num_of_votes == 0)
                    <h4>Vote for No more than {{$races[0]->max_num_of_votes ?? 0}}</h4>
                    @else
                    <h4>Vote for No less than {{$races[0]->min_num_of_votes}}, Vote for No more than {{$races[0]->max_num_of_votes ?? 0}}</h4>
                    @endif
                </div>                
                <form class="guide-desc-body race-voter scroller" method="post" action="{{ url('client/racecount') }}"  style="height: auto; max-height: 600px;">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="ballot_id" value="{{$ballots->data[0]->ballot_id}}" />
                        <input type="hidden" name="race_id" value="{{$races[0]->race_id}}" />
                        @if(count(get_object_vars($candidates)) != 0)
                            @if($races[0]->race_type != "R")
                                @foreach($candidates->data as $key=>$candidate)
                                <div class="form-group row" style="margin-left: 25px;">
                                    <div class="md-checkbox col-md-3">
                                        <input type="checkbox" id="checkbox{{$key}}" name="{{$candidate->candidate_id}}" value="{{$candidate->candidate_name}}" class="md-check">
                                        <label for="checkbox{{$key}}">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span>
                                        {{$candidate->candidate_name}}</label>
                                    </div>
                                    <div class="x col-md-9" style="margin-top: 15px;">
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
                                            <input type="text" class="spinner-input form-control" name="{{$candidate->candidate_id}}-{{$candidate->candidate_name}}" value="" maxlength="3" readonly>
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
                        No Candidate
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
            <div class="col-md-4 col-xs-12">
                <div class="form-group form-md-line-input has-info col-md-6">
                    <input type="text" class="form-control" id="form_control_1" placeholder="Other Candidate">
                    <label for="form_control_1"></label>
                </div>
                <div class="col-md-6 text-center">
                    <button type="button" class="btn-voter-else">Someone Else</button>
                </div>
            </div>
            
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- BEGIN FOOTER -->
<div class="page-footer-voter" style="text-align:center;padding-top: 35px;color:white;">
	<div class="col-md-3 col-xs-3">
    @if(count(session('raceresult')) != 0)
        <button href="{{url('client/review')}}" type="button" class="btn-review">Review your choice</button>
    @endif
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
    // var updateOutput = function (e) {
    //     var list = e.length ? e : $(e.target),
    //         output = list.data('output');
    //     if (window.JSON) {
    //         output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
    //     } else {
    //         output.val('JSON browser support required for this demo.');
    //     }
    // };
    // $('#nestable_list_1').nestable({
    //     group: 1
    // }).on('change', updateOutput);
    // updateOutput($('#nestable_list_1').data('output', $('#nestable_list_1_output')));
    
    @if(count(get_object_vars($candidates)) != 0)
        var max_num_of_write_ins = 0;
        var max = {{$races[0]->max_num_of_votes ?? 0}};
        var min = {{$races[0]->min_num_of_votes ?? 0}};
        jQuery(document).ready(function() {   
            if(min){
                $('.btn-voter').hide();
            }else{
                $('.btn-voter').show();
            }
        });

        @if($races[0]->race_type != "R")
            @foreach($candidates->data as $key=>$candidate)            
            $('.md-check').change(function(e){
                e.preventDefault();
                // $('.md-check').attr('checked', false);
                // $(this).attr('checked', true);
                if($('.md-check:checked').length >= min){
                    $('.btn-voter').show();
                }else{
                    $('.btn-voter').hide();
                }
                if($('.md-check:checked').length > max){
                    $(this).attr('checked',false);
                }else{
                    $('strong').text(max-$('.md-check:checked').length);
                }
            });
            @endforeach
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
                        url: 'http://3.90.78.113:9191/api/candidate/create',
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
        @else
            $('.spinner').spinner({value:0, min: 0, max: {{count($candidates->data)}}});
            $('.spinner-buttons').click(function(){
                var spin = 0;
                $('.spinner-input').each(function(){
                    if($(this).val() != 0){
                        spin ++;
                    }
                });
                if(spin<min){
                    $('.btn-voter').hide();
                }else{
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
                    url: 'http://3.90.78.113:9191/api/candidate/create',
                    crossDomain: true,
                    data: JSON.stringify(order),
                    dataType: 'json',
                    success: function(responseData, textStatus, jqXHR) {
                        $("form.race-voter > div").append('<div class="form-group row">\
                            <label class="control-label col-md-3">'+$('#form_control_1')+'</label>\
                            <div class="spinner col-md-9">\
                                <div class="input-group" style="width:150px;">\
                                    <div class="spinner-buttons input-group-btn">\
                                        <button type="button" class="btn spinner-up blue">\
                                        <i class="fa fa-plus"></i>\
                                        </button>\
                                    </div>\
                                    <input type="text" class="spinner-input form-control" name="'+responseData.message+'-'+$('#form_control_1').val()+'" value="" maxlength="3" readonly>\
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
        @endif
    @endif
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
            }else{
                toastr['warning']('Please input other values');
            }
        // }
    });
    $('.btn-voter-back').click(function(){
        $ ('.race-voter').attr('action', "{{ url('client/racedecount') }}");
        $ ('.race-voter').submit();
    });
    $('.btn-review').click(function(){
        window.location.href="{{url('client/review')}}";
    });
    
</script>
@endsection