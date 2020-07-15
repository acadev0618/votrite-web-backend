@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Voter Result
		</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
                        Voter Result
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-4 form-group">
											<label class="col-sm-3 control-label select_name">Ballot:</label>
											<div class="col-sm-9">
											<select class="form-control" name="cand_ballot_name" id="result_cand_ballot_name">
											@if(empty($ballots->data))
												<option value="-1">No Ballot</opiton>
											@else
												@foreach($ballots->data as $ballot)
												<option value="{{ $ballot->ballot_id }}">{{ $ballot->election }}</opiton>
												@endforeach
											@endif
											</select>
											</div>
										</div>
										<div class="col-md-6 form-group ">
											<label class="col-sm-4 control-label select_name">Pin Code:</label>
											<div class="col-sm-8 race_option">
												<select class="form-control" name="cand_race_name" id="result_pincode">
												
												</select>
											</div>
										</div>
										<div class="col-md-2"><button id="print" class="btn yellow" style=""><i class="fa fa-print"></i> <span>  Print</span></button></div>
									</div>
								</div>
								<div class="col-md-2"></div>
								
							</div>
						</div>

                        <form class="guide-desc-body race-voter scroller" method="post" action="{{ url('client/cast') }}" style="height: 400px;width: 400px;">
						<div id="totalresult" style="padding:10px; width:400px;">
                        	<h4 style="font-weight: bold;" id="ballot_board">{{$ballots->data[0]->board}}</h4>
                        	<h4 style="font-weight: bold;" >{{$ballots->data[0]->client}}</h4>
                        	<h4 style="font-weight: bold;" >{{$ballots->data[0]->election}}</h4>
                        	<h4 style="font-weight: bold;" >{{date("l F j Y")}}</h4>
							<br>
                            @csrf
							<h3 style="font-weight: bold;">Candidate</h3>
                            <div id="countresult" class="form-group" style="margin-left:25px;">
                            @if(count($candidate) != 0)
							
                            @foreach($candidate as $race)
                                <h4 style="font-weight: bold;">Candidates For: {{$race[0]['race_title']}}</h4>
								@foreach($race as $key=>$cval)
								@if($cval['race_type'] != 'R' )
                                <h4>{{$key+1}}. {{$cval['candidate_name']}}</h4>
                            	@else
                                <h4>{{$cval['candidate_name']}} : {{$cval['cast_value']}}</h4>
								@endif
								@endforeach
                            @endforeach
                            @else
                            No Candidate
                            @endif                            
                            </div>
							<hr style="border: 1px solid;width: 400px;">
							<h3 style="font-weight: bold;">Proposition</h3>
							<div id="propresult" class="form-group" style="margin-left:25px;">
                            @if(count(get_object_vars($prop)) != 0 && property_exists($prop, "data"))
                            @if(count($prop->data) != 0)
                            @foreach($prop->data as $pro)
                                <h4 style="font-weight: bold;">{{$pro->prop_title}}</h4>
								@if($pro->prop_answer_type == 1)
                                <h4>{{$pro->prop_name}} : {{$pro->cast_yes ? 'Yes' : ''}} {{$pro->cast_no ? 'No' : ''}}</h4>
								@else
								<h4>{{$pro->prop_name}} : {{$pro->cast_yes ? 'For' : ''}} {{$pro->cast_no ? 'Against' : ''}}</h4>
								@endif
                            @endforeach
                            @else
                            No Proposition
                            @endif                            
                            @endif                            
                            </div>
						</div>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
	$(function(){
        $('.slimScrollDiv').css({ height: $(window).innerHeight()-310 });
        $('.scroller').css({ height: $(window).innerHeight()-320 });
        $(window).resize(function(){
            $('.slimScrollDiv').css({ height: $(window).innerHeight()-310 });
            $('.scroller').css({ height: $(window).innerHeight()-320 });
        });
    });
	@if(empty($ballots->data))
	var ballot_id = '';
	var pincode = '';
	@else
	if(localStorage.getItem('old_rvb') != null) {
		var ballot_id = localStorage.getItem('old_rvb');
		var pincode = localStorage.getItem('old_rvp');
		$('#result_cand_ballot_name option').each(function(){
			$(this).attr('selected', false);
			if(localStorage.getItem('old_rvb') == $(this).val()){
				$(this).attr('selected', true);
			}
		});
	} else {
		var ballot_id = '{{ $ballots->data[0]->ballot_id }}';
		var pincode = '{{ $response->data[0]->pin }}';
	}
	@endif
    
    $.ajax({
			type: 'GET',
			url: baseurl+'pincode?ballot_id='+ballot_id+'&is_used=true',
			crossDomain: true,
			dataType: 'json',
			success: function(responseData, textStatus, jqXHR) {
				var text = "";
				var x;
				if(responseData.data != undefined){
					if(responseData.data.length != 0){
						if(localStorage.getItem('old_rvp') == null){
							localStorage.setItem('old_rvp',responseData.data[0]['pin']);
						}
						for (x in responseData.data) {
							text += "<option value='"+responseData.data[x]['pin']+"' "+(localStorage.getItem('old_rvp') == responseData.data[x]['pin'] ? 'selected': '')+">"+responseData.data[x]['pin']+"</opiton>";
						}
						$('#result_pincode').html(text);
						$('#countresult').text('');
						$('#propresult').text('');
						if(localStorage.getItem('old_rvp') != null){
							pincode = localStorage.getItem('old_rvp');
						}else{
							pincode = responseData.data[0]['pin'];
						}
						if(ballot_id != '' || ballot_id != -1){
							$.ajax({
								type: 'GET',
								url: apiurl+'votercal?ballot_id='+ballot_id+'&pincode='+pincode,
								crossDomain: true,
								dataType: 'json',
								success: function(responseData, textStatus, jqXHR) {
									var text = "";
									var text1 = "";
									var x;
									var x1;
									var race = [];
									for (x in responseData.candidate) {
										text += '<h4 class="'+responseData.candidate[x][0]['race_id']+'">Candidates For: '+responseData.candidate[x][0]['race_title']+'</h4>'
										for (y in responseData.candidate[x]) {
											text += '<h4>'+(responseData.candidate[x][y]['race_type'] != 'R' ? (parseInt(y)+1)+'. ' : '')+responseData.candidate[x][y]['candidate_name']+(responseData.candidate[x][y]['race_type'] == 'R' ? ' : '+responseData.candidate[x][y]['cast_value'] : '')+'</h4>';
										}
										console.log(responseData.candidate);
										// text = "";
										// console.log(race);
										// for (y in race) {
										// }
									}
									$('#countresult').html(text);
									for (x1 in responseData.prop) {
										console.log(responseData.prop);
										text1 += '<h4 >'+responseData.prop[x1]['prop_title']+'</h4><h4>'+responseData.prop[x1]['prop_name']+' : '+(responseData.prop[x1]['prop_answer_type'] == 1 ? responseData.prop[x1]['cast_yes'] ? 'Yes' : '' :  responseData.prop[x1]['cast_yes'] ? 'For' : '' )+' '+(responseData.prop[x1]['prop_answer_type'] == 1 ? responseData.prop[x1]['cast_no'] ? 'No' : '' : responseData.prop[x1]['cast_no'] ? 'Against' : '')+'</h4>';
									}
									$('#propresult').html(text1);
								},
								error: function (responseData, textStatus, errorThrown) {
									$('#countresult').text('None');
									$('#propresult').text('None');
									console.log('POST failed.');
								}
							});
						}
					}
				}else{
					$('#countresult').text('None');
					$('#propresult').text('None');
					$('#result_pincode').html("<option >none</opiton>");
				}
			},
			error: function (responseData, textStatus, errorThrown) {
				console.log('POST failed.');
			}
		});

	$('#result_cand_ballot_name').change(function(){
		ballot_id = $(this).val();
		localStorage.setItem("old_rvb", ballot_id);
		$('#ballot_board').text($(this).find('option:selected').text());
		$.ajax({
			type: 'GET',
			url: baseurl+'pincode?ballot_id='+ballot_id+'&is_used=true',
			crossDomain: true,
			dataType: 'json',
			success: function(responseData, textStatus, jqXHR) {
				var text = "";
				var x;
				if(responseData.data != undefined){
					if(responseData.data.length != 0){
						for (x in responseData.data) {
							text += "<option value="+responseData.data[x]['pin']+">"+responseData.data[x]['pin']+"</opiton>";
						}
						$('#result_pincode').html(text);
						$('#countresult').text('');
						$('#propresult').text('');
						pincode = responseData.data[0]['pin'];
						localStorage.setItem('old_rvp',pincode);
						if(ballot_id != '' || ballot_id != -1){
							$.ajax({
								type: 'GET',
								url: apiurl+'votercal?ballot_id='+ballot_id+'&pincode='+pincode,
								crossDomain: true,
								dataType: 'json',
								success: function(responseData, textStatus, jqXHR) {
									var text = "";
									var text1 = "";
									var x;
									var x1;
									var race = [];
									for (x in responseData.candidate) {
										text += '<h4 class="'+responseData.candidate[x][0]['race_id']+'">Candidates For: '+responseData.candidate[x][0]['race_title']+'</h4>'
										for (y in responseData.candidate[x]) {
											text += '<h4>'+(responseData.candidate[x][y]['race_type'] != 'R' ? (parseInt(y)+1)+'. ' : '')+responseData.candidate[x][y]['candidate_name']+(responseData.candidate[x][y]['race_type'] == 'R' ? ' : '+responseData.candidate[x][y]['cast_value'] : '')+'</h4>';
										}
										console.log(responseData.candidate);
										// text = "";
										// console.log(race);
										// for (y in race) {
										// }
									}
									$('#countresult').html(text);
									for (x1 in responseData.prop) {
										console.log(responseData.prop);
										text1 += '<h4 >'+responseData.prop[x1]['prop_title']+'</h4><h4>'+responseData.prop[x1]['prop_name']+' : '+(responseData.prop[x1]['prop_answer_type'] == 1 ? responseData.prop[x1]['cast_yes'] ? 'Yes' : '' :  responseData.prop[x1]['cast_yes'] ? 'For' : '' )+' '+(responseData.prop[x1]['prop_answer_type'] == 1 ? responseData.prop[x1]['cast_no'] ? 'No' : '' : responseData.prop[x1]['cast_no'] ? 'Against' : '')+'</h4>';
									}
									$('#propresult').html(text1);
								},
								error: function (responseData, textStatus, errorThrown) {
									$('#countresult').text('None');
									$('#propresult').text('None');
									console.log('POST failed.');
								}
							});
						}
					}
				}else{
					localStorage.setItem('old_rvp',null);
					$('#countresult').text('None');
					$('#propresult').text('None');
					$('#result_pincode').html("<option >none</opiton>");
				}
			},
			error: function (responseData, textStatus, errorThrown) {
				console.log('POST failed.');
			}
		});
	});

	$('#result_pincode').change(function(){
		pincode = $(this).val();
		localStorage.setItem('old_rvp',pincode);
		if(ballot_id != '' || ballot_id != -1){
            $.ajax({
                type: 'GET',
                url: apiurl+'votercal?ballot_id='+ballot_id+'&pincode='+pincode,
                crossDomain: true,
                dataType: 'json',
                success: function(responseData, textStatus, jqXHR) {
                    var text = "";
                    var text1 = "";
                    var x;
                    var x1;
					var race = [];
                    for (x in responseData.candidate) {
						text += '<h4 style="font-weight: bold;" class="'+responseData.candidate[x][0]['race_id']+'">Candidates For: '+responseData.candidate[x][0]['race_title']+'</h4>'
                    	for (y in responseData.candidate[x]) {
							text += '<h4>'+(responseData.candidate[x][y]['race_type'] != 'R' ? (parseInt(y)+1)+'. ' : '')+responseData.candidate[x][y]['candidate_name']+(responseData.candidate[x][y]['race_type'] == 'R' ? ' : '+responseData.candidate[x][y]['cast_value'] : '')+'</h4>';
						}
						console.log(responseData.candidate);
						// text = "";
						// console.log(race);
						// for (y in race) {
						// }
                    }
					$('#countresult').html(text);
					for (x1 in responseData.prop) {
						console.log(responseData.prop);
                        text1 += '<h4 >'+responseData.prop[x1]['prop_title']+'</h4><h4>'+responseData.prop[x1]['prop_name']+' : '+(responseData.prop[x1]['prop_answer_type'] == 1 ? responseData.prop[x1]['cast_yes'] ? 'Yes' : '' :  responseData.prop[x1]['cast_yes'] ? 'For' : '' )+' '+(responseData.prop[x1]['prop_answer_type'] == 1 ? responseData.prop[x1]['cast_no'] ? 'No' : '' : responseData.prop[x1]['cast_no'] ? 'Against' : '')+'</h4>';
                    }
                    $('#propresult').html(text1);
                },
                error: function (responseData, textStatus, errorThrown) {
					$('#countresult').text('None');
					$('#propresult').text('None');
                    console.log('POST failed.');
                }
            });
		}
	});
	$('#print').click(function(){
		html2canvas(document.querySelector("#totalresult")).then(canvas => {
			var img = canvas.toDataURL("image/png");
			var download = document.createElement('a');
			download.href = img;
			download.download = ''+new Date().getTime()+'.png';
			download.click();
			// console.log(img);
		});
    });
</script>
@endsection
