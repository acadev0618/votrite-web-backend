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
							</div>
						</div>
						<button id="print" class="btn btn-primary pull-right" style=""><i class="fa fa-print"></i> <span>  Print</span></button>

                        <form class="guide-desc-body race-voter scroller" method="post" action="{{ url('client/cast') }}" style="height: 500px;">
                        	<h2 id="ballot_board">{{$ballots->data[0]->board}}</h2>
                            @csrf
							<h1>Candidate</h1>
                            <div id="countresult" class="form-group" style="margin-left:25px;">
                            @if(count(get_object_vars($candidate)) != 0 && property_exists($candidate, "data"))
                            @if(count($candidate->data) != 0)
                            @foreach($candidate->data as $cand)
                                <h2>{{$cand->race_title}}</h2>
                                <h4>{{$cand->candidate_name}} {{$cand->cast_counter}} {{$cand->cast_value}}</h4>
                            @endforeach
                            @else
                            No Candidate
                            @endif                            
                            @endif                            
                            </div>
							<h1>Proposition</h1>
							<div id="propresult" class="form-group" style="margin-left:25px;">
                            @if(count(get_object_vars($prop)) != 0 && property_exists($prop, "data"))
                            @if(count($prop->data) != 0)
                            @foreach($prop->data as $cand)
                                <h2>{{$prop->prop_title}}</h2>
                                <h4>{{$prop->prop_name}} {{$prop->cast_yes}} {{$prop->cast_no}}</h4>
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
				for (x in responseData.data) {
					text += "<option value="+responseData.data[x]['pin']+">"+responseData.data[x]['pin']+"</opiton>";
				}
				$('#result_pincode').html(text);
				$('#countresult').text('');
				$('#propresult').text('');
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
                    for (x in responseData.candidate) {
						if($('.'+responseData.candidate[x]['race_id']).length != 0){
							console.log($('.'+responseData.candidate[x]['race_id']));
						}
                        text += '<h2 class="'+responseData.candidate[x]['race_id']+'">'+responseData.candidate[x]['race_title']+'</h2><h4>'+responseData.candidate[x]['candidate_name']+' '+responseData.candidate[x]['cast_counter']+' '+responseData.candidate[x]['cast_value']+'</h4>';
                    }
					$('#countresult').html(text);
					for (x1 in responseData.prop) {
						if($('.'+responseData.prop[x1]['race_id']).length != 0){
							console.log($('.'+responseData.prop[x]['race_id']));
						}
                        text1 += '<h2 >'+responseData.prop[x1]['prop_title']+'</h2><h4>'+responseData.prop[x1]['prop_name']+' '+responseData.prop[x1]['cast_yes']+' '+responseData.prop[x1]['cast_no']+'</h4>';
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