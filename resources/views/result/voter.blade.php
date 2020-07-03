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
									</div>
								</div>
								<div class="col-md-2"></div>
								<div class="col-md-2"><button id="print" class="btn btn-primary pull-right" style=""><i class="fa fa-print"></i> <span>  Print</span></button></div>
								
							</div>
						</div>

                        <form class="guide-desc-body race-voter scroller" method="post" action="{{ url('client/cast') }}" style="height: 500px;">
                        	<h3 id="ballot_board">{{$ballots->data[0]->board}}</h3>
							<br>
                        	<h3 >{{$ballots->data[0]->client}}</h3>
                        	<h3 >{{$ballots->data[0]->election}}</h3>
                        	<h3 >{{date("l F j Y")}}</h3>
							<br>
                            @csrf
							<h2>Candidate</h2>
                            <div id="countresult" class="form-group" style="margin-left:25px;">
                            @if(count($candidate) != 0)
							
                            @foreach($candidate as $race)
                                <h3>Candidates For: {{$race[0]['race_title']}}</h3>
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
							<hr style="border: 1px solid;width: 500px;">
							<h2>Proposition</h2>
							<div id="propresult" class="form-group" style="margin-left:25px;">
                            @if(count(get_object_vars($prop)) != 0 && property_exists($prop, "data"))
                            @if(count($prop->data) != 0)
                            @foreach($prop->data as $pro)
                                <h3>{{$pro->prop_title}}</h3>
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
	var ballot_id = '{{ $ballots->data[0]->ballot_id }}';
	var pincode = '{{ $response->data[0]->pin }}';
	@endif

	// $.ajax({
	// 	type: 'GET',
	// 	url: baseurl+'ballot',
	// 	crossDomain: true,
	// 	dataType: 'json',
	// 	success: function(responseData, textStatus, jqXHR) {
	// 		var text = "";
	// 		var x;
	// 		for (x in responseData.data) {
	// 			text += "<option value="+responseData.data[x]['ballot_id']+">"+responseData.data[x]['election']+"</opiton>";
	// 		}
	// 		$('#result_cand_ballot_name').html(text);
	// 	},
	// 	error: function (responseData, textStatus, errorThrown) {
	// 		console.log('POST failed.');
	// 	}
    // });
    
    $.ajax({
		type: 'GET',
		url: baseurl+'pincode?ballot_id='+ballot_id+'&is_used=true',
		crossDomain: true,
		dataType: 'json',
		success: function(responseData, textStatus, jqXHR) {
			var text = "";
			var x;
			for (x in responseData.data) {
				text += "<option value="+responseData.data[x]['pin']+">"+responseData.data[x]['pin']+"</opiton>";
			}
			$('#result_pincode').html(text);
		},
		error: function (responseData, textStatus, errorThrown) {
			console.log('POST failed.');
		}
	});

	$('#result_cand_ballot_name').change(function(){
		ballot_id = $(this).val();
		$('#ballot_board').text($(this).find('option:selected').text());
		$.ajax({
			type: 'GET',
			url: baseurl+'pincode?ballot_id='+ballot_id+'&is_used=true',
			crossDomain: true,
			dataType: 'json',
			success: function(responseData, textStatus, jqXHR) {
				var text = "";
				var x;
				if(responseData.data.length != 0){
					for (x in responseData.data) {
						text += "<option value="+responseData.data[x]['pin']+">"+responseData.data[x]['pin']+"</opiton>";
					}
					$('#result_pincode').html(text);
					$('#countresult').text('');
					$('#propresult').text('');
					pincode = responseData.data[0]['pin'];
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
									text += '<h3 class="'+responseData.candidate[x][0]['race_id']+'">Candidates For: '+responseData.candidate[x][0]['race_title']+'</h3>'
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
									text1 += '<h3 >'+responseData.prop[x1]['prop_title']+'</h3><h4>'+responseData.prop[x1]['prop_name']+' : '+(responseData.prop[x1]['prop_answer_type'] == 1 ? responseData.prop[x1]['cast_yes'] ? 'Yes' : '' :  responseData.prop[x1]['cast_yes'] ? 'For' : '' )+' '+(responseData.prop[x1]['prop_answer_type'] == 1 ? responseData.prop[x1]['cast_no'] ? 'No' : '' : responseData.prop[x1]['cast_no'] ? 'Against' : '')+'</h4>';
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
			},
			error: function (responseData, textStatus, errorThrown) {
				console.log('POST failed.');
			}
		});
	});

	$('#result_pincode').change(function(){
		pincode = $(this).val();
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
						text += '<h3 class="'+responseData.candidate[x][0]['race_id']+'">Candidates For: '+responseData.candidate[x][0]['race_title']+'</h3>'
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
                        text1 += '<h3 >'+responseData.prop[x1]['prop_title']+'</h3><h4>'+responseData.prop[x1]['prop_name']+' : '+(responseData.prop[x1]['prop_answer_type'] == 1 ? responseData.prop[x1]['cast_yes'] ? 'Yes' : '' :  responseData.prop[x1]['cast_yes'] ? 'For' : '' )+' '+(responseData.prop[x1]['prop_answer_type'] == 1 ? responseData.prop[x1]['cast_no'] ? 'No' : '' : responseData.prop[x1]['cast_no'] ? 'Against' : '')+'</h4>';
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
		var divContents = $("#countresult").parent().html();
		var printWindow = window.open('', '', 'height=400,width=800');
		printWindow.document.write('<html><head><title>Vote Result</title>');
		printWindow.document.write('</head><body >');
		printWindow.document.write(divContents);
		printWindow.document.write('</body></html>');
		printWindow.document.close();
		printWindow.print();
		printWindow.close();
    });
</script>
@endsection
