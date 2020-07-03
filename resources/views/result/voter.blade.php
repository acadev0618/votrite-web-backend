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
							</div>
						</div>
                        <h2 id="ballot_board">{{$ballots->data[0]->board}}</h2>
                        <form class="guide-desc-body race-voter scroller" method="post" action="{{ url('client/cast') }}" style="height: 500px;">
                            @csrf
                            <div class="form-group" style="margin-left:25px;">
                            @if(count(get_object_vars($candidate)) != 0 && property_exists($candidate, "data"))
                            @if(count($candidate->data) != 0)
                            @foreach($candidate->data as $cand)
                                {{$cand->race_title}}
                                {{$cand->candidate_name}}
                                {{$cand->cast_counter}}
                                {{$cand->cast_value}}
                            @endforeach
                            @else
                            No Candidate
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
	@if(empty($ballots->data))
	var ballot_id = '';
	var pincode = '';
	@else
	var ballot_id = '{{ $ballots->data[0]->ballot_id }}';
	var pincode = '{{ $response->data[0]->pin }}';
	@endif

	$.ajax({
		type: 'GET',
		url: baseurl+'ballot',
		crossDomain: true,
		dataType: 'json',
		success: function(responseData, textStatus, jqXHR) {
			var text = "";
			var x;
			for (x in responseData.data) {
				text += "<option value="+responseData.data[x]['ballot_id']+">"+responseData.data[x]['election']+"</opiton>";
			}
			$('#result_cand_ballot_name').html(text);
		},
		error: function (responseData, textStatus, errorThrown) {
			console.log('POST failed.');
		}
    });
    
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
				for (x in responseData.data) {
					text += "<option value="+responseData.data[x]['pin']+">"+responseData.data[x]['pin']+"</opiton>";
				}
				$('#result_pincode').html(text);
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
                    var x;
                    for (x in responseData.candidate) {
                        text += responseData.candidate[x]['candidate_name']+' '+responseData.candidate[x]['pincode']+' '+responseData.candidate[x]['cast_counter']+' '+responseData.candidate[x]['cast_value'];
                    }
                    $('#ballot_board form div').html(text);
                },
                error: function (responseData, textStatus, errorThrown) {
                    console.log('POST failed.');
                }
            });
		}
	});
</script>
@endsection
