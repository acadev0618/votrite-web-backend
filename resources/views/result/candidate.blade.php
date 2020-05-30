@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Result
		</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							Ballot Result Table
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-6 select_options">
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
									<div class="col-md-4 form-group ">
										<label class="col-sm-3 control-label select_name">Race:</label>
										<div class="col-sm-9 race_option">
											<select class="form-control" name="cand_race_name" id="result_cand_race_name">
											@if(empty($races->data))
												<option value="-1">No Race</opiton>
											@else
												@foreach($races->data as $race)
												<option value="{{ $race->race_id }}">{{ $race->race_name }}</opiton>
												@endforeach
											@endif
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div id='change_table'>
							<table class="table table-striped table-bordered table-hover" id="result_candidate_table">
								<thead>
									<tr>
										<th>
											Candidate Name
										</th>
										<th style="width: 6%;">
											Total Votes
										</th>
										<!-- <th>
											Candidate Value
										</th>
										<th style="width: 6%;">
											Candidate Photo
										</th> -->
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
	function getImg(data, type, full, meta) {
		return '<img src='+data+' />';
	}
	@if(empty($ballots->data))
	var ballot_id = '';
	var race_id = '';
	@else
	var ballot_id = '{{ $ballots->data[0]->ballot_id }}';
	var race_id = '{{ $races->data[0]->race_id }}';
	@endif

	jQuery(document).ready(function() {
		handleRecords(ballot_id, race_id);
	});


	var handleRecords = function (ballot_id, race_id) {

		// if(race_id == '' || race_id == -1){
		// 	propurl = baseurl+'result/candidate?ballot_id='+ballot_id;
		// }else{
			propurl = baseurl+'result/candidate?ballot_id='+ballot_id+'&race_id='+race_id;
		// }

		var table = $('#result_candidate_table');

		table.dataTable({

			"language": {
				"aria": {
					"sortAscending": ": activate to sort column ascending",
					"sortDescending": ": activate to sort column descending"
				},
				"emptyTable": "No data available in table",
				"info": "Showing _START_ to _END_ of _TOTAL_ entries",
				"infoEmpty": "No entries found",
				"infoFiltered": "(filtered1 from _MAX_ total entries)",
				"lengthMenu": "Show _MENU_ entries",
				"search": "Search:",
				"zeroRecords": "No matching records found",
                "processing": "No Result"
			},
			destroy: true,
			"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
			// "ajax":{
			//     type: 'GET',
			//     url: baseurl+'result/all',
			//     crossDomain: true,
			//     dataType: 'json',
			// },
			ajax: function (data, callback, settings) {
				$.ajax({
				url: propurl,
				type: 'GET',
				dataType: 'json',
				success:function(data){
					console.log(data);
					if(data.data != undefined){
						callback(data);
					}else{
						callback({data:[]});
					}
				}
				});
			},
			"columns": [
				{ "data": "candidate_name" },
				{ "data": "cast_counter" },
				// { "data": "cast_value" },
				// { "data": "photo", render: getImg },
			],
			"lengthMenu": [
				[5, 15, 20, -1],
				[5, 15, 20, "All"] // change per page values here
			],
			// set the initial value
			"pageLength": 5,
			"language": {
				"lengthMenu": " _MENU_ records"
			},
			"columnDefs": [{  // set default column settings
				'orderable': false,
				'targets': [0]
			},{  // set default column settings
				'orderable': 'desc',
				'targets': [1]
			}]
		});

	}	

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
			alert('POST failed.');
		}
	});

	$('#result_cand_ballot_name').change(function(){
		ballot_id = $(this).val();
		race_id = -1;
		$.ajax({
			type: 'GET',
			url: baseurl+'race?ballot_id='+ballot_id,
			crossDomain: true,
			dataType: 'json',
			success: function(responseData, textStatus, jqXHR) {
				var text = "";
				var x;
				console.log(responseData.data);
				if(responseData.data != undefined){
					race_id = responseData.data[0]['race_id']
				}
				for (x in responseData.data) {
					text += "<option value="+responseData.data[x]['race_id']+">"+responseData.data[x]['race_name']+"</opiton>";
				}
				$('#result_cand_race_name').html(text);
				handleRecords(ballot_id, race_id);
			},
			error: function (responseData, textStatus, errorThrown) {
				alert('POST failed.');
			}
		});			
		
	});

	$('#result_cand_race_name').change(function(){
		race_id = $(this).val();
		if(ballot_id != '' || ballot_id != -1){
			handleRecords(ballot_id, race_id);
		}
	});
</script>
@endsection
