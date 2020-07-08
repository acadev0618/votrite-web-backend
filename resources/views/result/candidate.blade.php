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
									<!-- <div class="col-md-4 form-group ">
										<label class="col-sm-3 control-label select_name">Race:</label>
										<div class="col-sm-9 race_option">
											<select class="form-control" name="cand_race_name" id="result_cand_race_name">
											@if(empty($races->data))
												<option value="-1">No Race</opiton>
											@else
												@foreach($races->data as $race)
												<option value="{{ $race->race_id }}" data-type="{{ $race->race_type }}" >{{ $race->race_name }}</opiton>
												@endforeach
											@endif
											</select>
										</div>
									</div> -->
									<div class="col-md-4 form-group ">
										<button class="btn yellow showDetail"><i class="fa fa-eye"></i> <span> Print</span></button>
									</div>
								</div>
								<div class="col-md-6">
									
								</div>
							</div>
						</div>
						<form class="guide-desc-body race-voter scroller" method="post" action="{{ url('client/cast') }}" style="height: 600px; width:400px;">
						<div id="balresult" style="padding:10px; width:400px;">
                        	<h4 style="font-weight: bold;" id="ballot_board">{{$ballots->data[0]->board}}</h4>
							<h4 style="font-weight: bold;" >{{$ballots->data[0]->address}}</h4>
                        	<h4 style="font-weight: bold;" >{{$ballots->data[0]->client}}</h4>
                        	<h4 style="font-weight: bold;" >Start : {{date_format(date_create($ballots->data[0]->start_date),"l, F j, Y")}}</h4>
                        	<h4 style="font-weight: bold;" >End : {{date_format(date_create($ballots->data[0]->start_date),"l, F j, Y")}}</h4>
							<br>
                            @csrf
							<h3 class="text-center" style="width: 400px;border-bottom:1px solid;font-weight: bold;">END OF DAY - REPORT</h3>
							<h4 style="font-weight: bold;" >TOTAL VOTES ON MACHINE........{{$blt_cnt}}</h4>
							<hr style="border: 1px solid;width: 400px;">
                            <div id="countresult" class="form-group" style="margin-left:25px;">
                            @if(count($candidates) != 0)
                            @foreach($candidates as $race)
                                <h4 style="font-weight: bold;">{{$race[0]->race_title}}</h4>
								<h4 style="font-weight: bold;">{{$race[0]->race_name}}</h4>
								@foreach($race as $cand)
								<h4>{{$cand->candidate_name}} - {{$cand->cast_counter}}</h4>
                            	@endforeach
                            @endforeach
                            @else
                            No Candidate
                            @endif
							</div>
							<hr style="border: 1px solid;width: 400px;">
							<h2>Proposition</h2>
							<div id="propresult" class="form-group" style="margin-left:25px;">
                            @if(count(get_object_vars($props)) != 0 && property_exists($props, "data"))
                            @if(count($props->data) != 0)
                            @foreach($props->data as $pro)
                                <h4>{{$pro->prop_name}}</h4>
								@if($pro->prop_answer_type == 1)
                                <h4>Yes - {{$pro->cast_yes}}</h4>
                                <h4>No - {{$pro->cast_no}}</h4>
								@else
								<h4>For - {{$pro->cast_yes}}</h4>
                                <h4>Against - {{$pro->cast_no}}</h4>
								@endif
                            @endforeach
                            @else
                            No Proposition
                            @endif                            
                            @endif                            
                            </div>
						</div>
                        </form>
                        <!-- <div id='change_table_candidate_r'>
							<h4 class="modal-title text-center">Candidate</h4>
							<table class="table table-striped table-bordered table-hover" id="result_candidate_table_r">
								<thead>
									<tr>
										<th style="width: 30%;">
											Candidate Name
										</th>
										<th style="width: 30%;">
											Rank
										</th>
										<th style="width: 30%;">
											Total Votes
										</th>
										<th class="hidden">
											Candidate id
										</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
                        <div id='change_table_candidate'>
							<h4 class="modal-title text-center">Candidate</h4>
							<table class="table table-striped table-bordered table-hover" id="result_candidate_table">
								<thead>
									<tr>
										<th style="width: 50%;">
											Candidate Name
										</th>
										<th class="hidden">
											Rank
										</th>
										<th style="width: 50%;">
											Total Votes
										</th>
										<th class="hidden">
											Candidate id
										</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
						<div id='change_table_party'>
							<h4 class="modal-title text-center">Party</h4>
							<table class="table table-striped table-bordered table-hover" id="result_party_table">
								<thead>
									<tr>
										<th style="width: 50%;">
											Party Name
										</th>
										<th style="width: 50%;">
											Total Votes
										</th>
										<th class="hidden">
											Party id
										</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- <div id="detailModal" class="modal fade" tabindex="-1" data-width="1020">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
    </div>
    <div class="modal-body">
		<div class="scroller" style="height:600px" data-always-visible="1" data-rail-visible1="1">
			<div class="row">
				<div class="col-md-6" style="border-right: 1px dashed;">
					<h4 class="modal-title text-center">Ballot</h4>
					<div class="form-group form-md-line-input">
						<label class="col-md-3 control-label" for="form_control_1">Election : </label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="form_election" disabled >
							<div class="form-control-focus">
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input">
						<label class="col-md-3 control-label" for="form_control_1">Address : </label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="form_address" disabled >
							<div class="form-control-focus">
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input">
						<label class="col-md-3 control-label" for="form_control_1">Client : </label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="form_client" disabled >
							<div class="form-control-focus">
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input">
						<label class="col-md-3 control-label" for="form_control_1">Board : </label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="form_board" disabled >
							<div class="form-control-focus">
							</div>
						</div>
					</div>

					<h4 class="modal-title text-center">Race</h4>
					<div class="form-group form-md-line-input">
						<label class="col-md-3 control-label" for="form_control_1">Title : </label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="form_title" disabled >
							<div class="form-control-focus">
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input">
						<label class="col-md-3 control-label" for="form_control_1">Name : </label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="form_name" disabled >
							<div class="form-control-focus">
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input">
						<label class="col-md-3 control-label" for="form_control_1">Position : </label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="form_position" disabled >
							<div class="form-control-focus">
							</div>
						</div>
					</div>
					<div class="form-group form-md-line-input">
						<label class="col-md-3 control-label" for="form_control_1">Type : </label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="form_type" disabled >
							<div class="form-control-focus">
							</div>
						</div>
					</div>
					
				</div>
				<div class="col-md-6" style="border-left: 1px dashed;">
					<h4 class="modal-title text-center">Proposition</h4>
					<ul id="form_prop" class="props">
						<li >
							Prob1
							<ul>
								<li>
									Yes
								</li>
								<li>
									No
								</li>
							</ul>
						</li>
					</ul>
					<h4 class="modal-title text-center">Mass Proposition</h4>
					<ul id="form_massprop" class="props">
						<li >
							Prob1
							<ul>
								<li>
									Yes
								</li>
								<li>
									No
								</li>
							</ul>
						</li>
					</ul>
					<h4 class="modal-title text-center" id="cand_title"></h4>
					<div class="row" id='cand_detail' style="margin-top: 25px; margin-bottom: 25px;"></div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-warning" data-dismiss="modal">
				<span class='glyphicon glyphicon-remove'></span> Close
			</button>
		</div>
    </div>
</div> -->

@endsection
@section('script')
<script>
	// function getImg(data, type, full, meta) {
	// 	return '<img src='+data+' />';
	// }
	@if(empty($ballots->data))
	var ballot_id = '';
	// var race_id = '';
	// var race_type = '';
	@else
	var ballot_id = '{{ $ballots->data[0]->ballot_id }}';
	@endif

	var typerpc = 'candidate';	

	// var handleRecords = function (ballot_id, race_id, typerpc) {

	// 	propurl = baseurl+'result/'+typerpc+'?ballot_id='+ballot_id+'&race_id='+race_id;
		
	// 	if(race_type == 'R') {
	// 		var tablename = '#result_'+typerpc+'_table_r';
	// 	} else {
	// 		var tablename = '#result_'+typerpc+'_table';
	// 	}

	// 	var table = $(tablename);
	// 	if(typerpc == 'candidate'){
	// 		table.dataTable({
	// 			"language": {
	// 				"aria": {
	// 					"sortAscending": ": activate to sort column ascending",
	// 					"sortDescending": ": activate to sort column descending"
	// 				},
	// 				"emptyTable": "No data available in table",
	// 				"info": "Showing _START_ to _END_ of _TOTAL_ entries",
	// 				"infoEmpty": "No entries found",
	// 				"infoFiltered": "(filtered1 from _MAX_ total entries)",
	// 				"lengthMenu": "Show _MENU_ entries",
	// 				"search": "Search:",
	// 				"zeroRecords": "No matching records found",
	// 				"processing": "No Result"
	// 			},
	// 			destroy: true,
	// 			"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
	// 			ajax: function (data, callback, settings) {
	// 				$.ajax({
	// 					url: propurl,
	// 					type: 'GET',
	// 					dataType: 'json',
	// 					success:function(data){
	// 						if(data.data != undefined){
	// 							callback(data);
	// 						}else{
	// 							callback({data:[]});
	// 						}
	// 					}
	// 				});
	// 			},
	// 			"columns": [
	// 				{ "data": "candidate_name" },
	// 				{ "data": "cast_value" },
	// 				{ "data": "cast_counter" },
	// 				{ "data": "candidate_id" },
	// 			],
	// 			"lengthMenu": [
	// 				[5, 15, 20, -1],
	// 				[5, 15, 20, "All"] // change per page values here
	// 			],
	// 			// set the initial value
	// 			"pageLength": 5,
	// 			"language": {
	// 				"lengthMenu": " _MENU_ records"
	// 			},
	// 			"columnDefs": [{  // set default column settings
	// 				'orderable': false,
	// 				'targets': [-1]
	// 			},{  // set default column settings
	// 				'orderable': 'desc',
	// 				'targets': [0]
	// 			}]
	// 		});
	// 	} else {
	// 		table.dataTable({
				
	// 			"language": {
	// 				"aria": {
	// 					"sortAscending": ": activate to sort column ascending",
	// 					"sortDescending": ": activate to sort column descending"
	// 				},
	// 				"emptyTable": "No data available in table",
	// 				"info": "Showing _START_ to _END_ of _TOTAL_ entries",
	// 				"infoEmpty": "No entries found",
	// 				"infoFiltered": "(filtered1 from _MAX_ total entries)",
	// 				"lengthMenu": "Show _MENU_ entries",
	// 				"search": "Search:",
	// 				"zeroRecords": "No matching records found",
	// 				"processing": "No Result"
	// 			},
	// 			destroy: true,
	// 			"bStateSave": true,
	// 			ajax: function (data, callback, settings) {
	// 				$.ajax({
	// 					url: propurl,
	// 					type: 'GET',
	// 					dataType: 'json',
	// 					success:function(data){
	// 						if(data.data != undefined){
	// 							callback(data);
	// 						}else{
	// 							callback({data:[]});
	// 						}
	// 					}
	// 				});
	// 			},
	// 			"columns": [
	// 				{ "data": "party_name" },
	// 				{ "data": "cast_counter" },
	// 				{ "data": "party_id" },
	// 			],
	// 			"lengthMenu": [
	// 				[5, 15, 20, -1],
	// 				[5, 15, 20, "All"] // change per page values here
	// 			],
	// 			// set the initial value
	// 			"pageLength": 5,
	// 			"language": {
	// 				"lengthMenu": " _MENU_ records"
	// 			},
	// 			"columnDefs": [{  // set default column settings
	// 				'orderable': false,
	// 				'targets': [-1]
	// 			},{  // set default column settings
	// 				'orderable': 'desc',
	// 				'targets': [0]
	// 			}]
	// 		});
	// 	}

	// }

	jQuery(document).ready(function() {		
		// handleRecords(ballot_id, race_id, typerpc);
		// handleRecords(ballot_id, race_id, 'party');
		var order = {
			"election" : "%%"
		};
		$.ajax({
			type: 'POST',
			url: baseurl+'ballot/active',
			crossDomain: true,
			dataType: 'json',
			data: JSON.stringify(order),
			success: function(responseData, textStatus, jqXHR) {
				var text = "";
				var x;
				for (x in responseData.data) {
					var selected = responseData.data[x]['ballot_id'] == ballot_id ? " selected" : " ";
					text += "<option value="+responseData.data[x]['ballot_id']+selected+">"+responseData.data[x]['election']+"</opiton>";
				}
				$('#result_cand_ballot_name').html(text);
				
			},
			error: function (responseData, textStatus, errorThrown) {
			}
		});
		// if(ballot_id != '' || ballot_id != -1){
		// 	switch(race_type) {
		// 		case 'R':
		// 			typerpc = 'candidate';
		// 			handleRecords(ballot_id, race_id, typerpc);
		// 			$('#change_table_candidate_r').show();
		// 			$('#change_table_candidate').hide();
		// 			$('#change_table_party').hide();
		// 			break;
		// 		case 'S':
		// 			// typerpc = 'party';
		// 			typerpc = 'candidate';
		// 			handleRecords(ballot_id, race_id, typerpc);
		// 			$('#change_table_candidate').show();
		// 			$('#change_table_candidate_r').hide();
		// 			$('#change_table_party').hide();
		// 			break;
		// 		case 'P':
		// 			typerpc = 'candidate';
		// 			handleRecords(ballot_id, race_id, typerpc);
		// 			typerpc = 'party';
		// 			handleRecords(ballot_id, race_id, typerpc);
		// 			$('#change_table_candidate').show();
		// 			$('#change_table_party').show();
		// 			$('#change_table_candidate_r').hide();
		// 			break;
		// 	}
	});

	// $(document).on('click', '.showDetail', function(e){
	// 	if($('#result_'+typerpc+'_table tbody tr').text() != 'No data available in table' && race_type != 'P'){
	// 		$.ajax({
	// 			type: 'GET',
	// 			url: baseurl+'ballot?ballot_id='+ballot_id,
	// 			crossDomain: true,
	// 			dataType: 'json',
	// 			success: function(responseData, textStatus, jqXHR) {
	// 				$('#form_election').val(responseData.data[0]['election']);
	// 				$('#form_address').val(responseData.data[0]['address']);
	// 				$('#form_client').val(responseData.data[0]['client']);
	// 				$('#form_board').val(responseData.data[0]['board']);
	// 			},
	// 			error: function (responseData, textStatus, errorThrown) {
	// 			}
	// 		});
	// 		$.ajax({
	// 			type: 'GET',
	// 			url: baseurl+'race?race_id='+race_id,
	// 			crossDomain: true,
	// 			dataType: 'json',
	// 			success: function(responseData, textStatus, jqXHR) {
	// 				$('#form_title').val(responseData.data[0]['race_title']);
	// 				$('#form_name').val(responseData.data[0]['race_name']);
	// 				$('#form_position').val(responseData.data[0]['race_voted_position']);
	// 				switch(responseData.data[0]['race_type']) {
	// 					case 'R':
	// 						$('#form_type').val('Rank');
	// 						break;
	// 					case 'P':
	// 						$('#form_type').val('Primary');
	// 						break;
	// 					case 'S':
	// 						$('#form_type').val('Standard');
	// 						break;
	// 				}
	// 			},
	// 			error: function (responseData, textStatus, errorThrown) {
	// 			}
	// 		});
	// 		$.ajax({
	// 			type: 'GET',
	// 			url: baseurl+'result/proposition?ballot_id='+ballot_id+'&prop_type=P'+'&race_id='+race_id,
	// 			crossDomain: true,
	// 			dataType: 'json',
	// 			success: function(responseData, textStatus, jqXHR) {
	// 				var text = "";
	// 				var x;
	// 				for (x in responseData.data) {
	// 					if(responseData.data[x]['prop_answer_type'] == "1"){
	// 						text += "<li >"+responseData.data[x]['prop_name']+"<ul ><li > Yes : "+responseData.data[x]['cast_yes']+"</li><li > No : "+responseData.data[x]['cast_no']+"</li></ul></li>";
	// 					}else{
	// 						text += "<li >"+responseData.data[x]['prop_name']+"<ul ><li > For : "+responseData.data[x]['cast_yes']+"</li><li > Against : "+responseData.data[x]['cast_no']+"</li></ul></li>";
	// 					}
	// 				}
	// 				$('#form_prop').html(text);
	// 			},
	// 			error: function (responseData, textStatus, errorThrown) {
	// 			}
	// 		});
	// 		$.ajax({
	// 			type: 'GET',
	// 			url: baseurl+'result/proposition?ballot_id='+ballot_id+'&prop_type=M'+'&race_id='+race_id,
	// 			crossDomain: true,
	// 			dataType: 'json',
	// 			success: function(responseData, textStatus, jqXHR) {
	// 				var text = "";
	// 				var x;
	// 				for (x in responseData.data) {
	// 					if(responseData.data[x]['prop_answer_type'] == "1"){
	// 						text += "<li >"+responseData.data[x]['prop_name']+"<ul ><li > Yes : "+responseData.data[x]['cast_yes']+"</li><li > No : "+responseData.data[x]['cast_no']+"</li></ul></li>";
	// 					}else{
	// 						text += "<li >"+responseData.data[x]['prop_name']+"<ul ><li > For : "+responseData.data[x]['cast_yes']+"</li><li > Against : "+responseData.data[x]['cast_no']+"</li></ul></li>";
	// 					}
	// 				}
	// 				$('#form_massprop').html(text);
	// 			},
	// 			error: function (responseData, textStatus, errorThrown) {
	// 			}
	// 		});
	// 		$.ajax({
	// 			url: baseurl+'result/'+typerpc+'?ballot_id='+ballot_id+'&race_id='+race_id,
	// 			type: 'GET',
	// 			dataType: 'json',
	// 			success:function(responseData, textStatus, jqXHR){
	// 				var text = "";
	// 				var x;
	// 				var oldname = '';

	// 				for (x in responseData.data) {
	// 					if(typerpc == 'candidate'){
	// 						if(race_type == 'R') {
	// 							if(oldname != responseData.data[x]['candidate_name']){
	// 								if(responseData.data[x]['candidate_name'].length > 20) {
	// 									name = responseData.data[x]['candidate_name'].slice(0, 20);
	// 									name += ' ...';
	// 									text += "<div class='col-md-offset-1 col-md-5'>"+name;
	// 								} else {
	// 									text += "<div class='col-md-offset-1 col-md-5'>"+responseData.data[x]['candidate_name'];
	// 								}
	// 							}else{
	// 								text += "<div class='col-md-offset-1 col-md-5'>";
	// 							}
	// 							text +="</div><div class='col-md-2'> Rank: "+responseData.data[x]['cast_value']+"</div><div class='col-md-3'>Total Votes: "+responseData.data[x]['cast_counter']+"</div>";
	// 							oldname = responseData.data[x]['candidate_name'];
	// 						} else if(race_type == 'S') {
	// 							text += "<div class='col-md-offset-1 col-md-7'>"+responseData.data[x]['candidate_name']+"</div><div class='col-md-offset-1 col-md-3'>Total Votes: "+responseData.data[x]['cast_counter']+"</div>";
	// 						}
	// 					}
	// 				}
	// 				$('#cand_title').text('Candidate');
	// 				$('#cand_detail').html(text);
	// 			}
	// 		});
	// 		var modal = $('#detailModal');
	// 		modal.modal('show');
	// 	} else {
	// 		if($('#result_candidate_table tbody tr').text() != 'No data available in table' || $('#result_party_table tbody tr').text() != 'No data available in table'){
	// 			$.ajax({
	// 				type: 'GET',
	// 				url: baseurl+'ballot?ballot_id='+ballot_id,
	// 				crossDomain: true,
	// 				dataType: 'json',
	// 				success: function(responseData, textStatus, jqXHR) {
	// 					$('#form_election').val(responseData.data[0]['election']);
	// 					$('#form_address').val(responseData.data[0]['address']);
	// 					$('#form_client').val(responseData.data[0]['client']);
	// 					$('#form_board').val(responseData.data[0]['board']);
	// 				},
	// 				error: function (responseData, textStatus, errorThrown) {
	// 				}
	// 			});
	// 			$.ajax({
	// 				type: 'GET',
	// 				url: baseurl+'race?race_id='+race_id,
	// 				crossDomain: true,
	// 				dataType: 'json',
	// 				success: function(responseData, textStatus, jqXHR) {
	// 					$('#form_title').val(responseData.data[0]['race_title']);
	// 					$('#form_name').val(responseData.data[0]['race_name']);
	// 					$('#form_position').val(responseData.data[0]['race_voted_position']);
	// 					switch(responseData.data[0]['race_type']) {
	// 						case 'R':
	// 							$('#form_type').val('Rank');
	// 							break;
	// 						case 'P':
	// 							$('#form_type').val('Primary');
	// 							break;
	// 						case 'S':
	// 							$('#form_type').val('Standard');
	// 							break;
	// 					}
	// 				},
	// 				error: function (responseData, textStatus, errorThrown) {
	// 				}
	// 			});
	// 			$.ajax({
	// 				type: 'GET',
	// 				url: baseurl+'result/proposition?ballot_id='+ballot_id+'&prop_type=P'+'&race_id='+race_id,
	// 				crossDomain: true,
	// 				dataType: 'json',
	// 				success: function(responseData, textStatus, jqXHR) {
	// 					var text = "";
	// 					var x;
	// 					for (x in responseData.data) {
	// 						text += "<li >"+responseData.data[x]['prop_name']+"<ul ><li > Yes : "+responseData.data[x]['cast_yes']+"</li><li > No : "+responseData.data[x]['cast_no']+"</li></ul></li>";
	// 					}
	// 					$('#form_prop').html(text);
	// 				},
	// 				error: function (responseData, textStatus, errorThrown) {
	// 				}
	// 			});
	// 			$.ajax({
	// 				type: 'GET',
	// 				url: baseurl+'result/proposition?ballot_id='+ballot_id+'&prop_type=M'+'&race_id='+race_id,
	// 				crossDomain: true,
	// 				dataType: 'json',
	// 				success: function(responseData, textStatus, jqXHR) {
	// 					var text = "";
	// 					var x;
	// 					for (x in responseData.data) {
	// 						text += "<li >"+responseData.data[x]['prop_name']+"<ul ><li > Yes : "+responseData.data[x]['cast_yes']+"</li><li > No : "+responseData.data[x]['cast_no']+"</li></ul></li>";
	// 					}
	// 					$('#form_massprop').html(text);
	// 				},
	// 				error: function (responseData, textStatus, errorThrown) {
	// 				}
	// 			});
	// 			var text = '';
	// 			$.ajax({
	// 				url: baseurl+'result/candidate?ballot_id='+ballot_id+'&race_id='+race_id,
	// 				type: 'GET',
	// 				dataType: 'json',
	// 				success:function(responseData, textStatus, jqXHR){
	// 					var x;
	// 					for (x in responseData.data) {
	// 						text += "<div class='col-md-12'>";
	// 						text += "<div class='col-md-offset-1 col-md-7'>"+responseData.data[x]['candidate_name']+"</div ><div class='col-md-offset-1 col-md-3'>Total Votes: "+responseData.data[x]['cast_counter']+"</div>";
	// 						text += "</div>";
	// 					}
	// 					$('#cand_title').text('Party / Candidate');
	// 					$('#cand_detail').html(text);
	// 				}
	// 			});
	// 			$.ajax({
	// 				url: baseurl+'result/party?ballot_id='+ballot_id+'&race_id='+race_id,
	// 				type: 'GET',
	// 				dataType: 'json',
	// 				success:function(responseData, textStatus, jqXHR){
	// 					var x;
	// 					for (x in responseData.data) {
	// 						text += "<div class='col-md-12'>";
	// 						text += "<div class='col-md-offset-1 col-md-7'>"+responseData.data[x]['party_name']+"</div ><div class='col-md-offset-1 col-md-3'>Total Votes: "+responseData.data[x]['cast_counter']+"</div>";
	// 						text += "</div>";
	// 					}
	// 					text += "<div class='col-md-12' style='margin-bottom: 10px;'> </div>"
	// 					$('#cand_title').text('Candidate');
	// 					$('#cand_detail').html(text);
	// 				}
	// 			});
	// 			var modal = $('#detailModal');
	// 			modal.modal('show');			
	// 		}
	// 	}
	// }); 

	$('#result_cand_ballot_name').change(function(){
		ballot_id = $(this).val();
		// race_id = -1;
		// $.ajax({
		// 	type: 'GET',
		// 	url: baseurl+'race?ballot_id='+ballot_id,
		// 	crossDomain: true,
		// 	dataType: 'json',
		// 	success: function(responseData, textStatus, jqXHR) {
		// 		var text = "";
		// 		var x;
		// 		if(responseData.data != null){
		// 			race_id = responseData.data[0]['race_id'];
		// 			race_type = responseData.data[0]['race_type'];
		// 		}
				// for (x in responseData.data) {
				// 	text += "<option value="+responseData.data[x]['race_id']+" data-type="+responseData.data[x]['race_type']+">"+responseData.data[x]['race_name']+"</opiton>";
				// }
				// $('#result_cand_race_name').html(text);
				
				// if(ballot_id != '' || ballot_id != -1){
				// 	switch(race_type) {
				// 		case 'R':
				// 			typerpc = 'candidate';
				// 			handleRecords(ballot_id, race_id, typerpc);
				// 			$('#change_table_candidate_r').show();
				// 			$('#change_table_candidate').hide();
				// 			$('#change_table_party').hide();
				// 			break;
				// 		case 'S':
				// 			// typerpc = 'party';
				// 			typerpc = 'candidate';
				// 			handleRecords(ballot_id, race_id, typerpc);
				// 			$('#change_table_candidate').show();
				// 			$('#change_table_candidate_r').hide();
				// 			$('#change_table_party').hide();
				// 			break;
				// 		case 'P':
				// 			typerpc = 'candidate';
				// 			handleRecords(ballot_id, race_id, typerpc);
				// 			typerpc = 'party';
				// 			handleRecords(ballot_id, race_id, typerpc);
				// 			$('#change_table_candidate').show();
				// 			$('#change_table_party').show();
				// 			$('#change_table_candidate_r').hide();
				// 			break;
				// 	}
				// }
		// 	},
		// 	error: function (responseData, textStatus, errorThrown) {
		// 	}
		// });
		$.ajax({
                type: 'GET',
                url: apiurl+'ballotcal?ballot_id='+ballot_id,
                success: function(responseData, textStatus, jqXHR) {
					console.log(responseData);
					$('#balresult').html(responseData);
                },
                error: function (responseData, textStatus, errorThrown) {
					// $('#balresult').text('None');
                    console.log(responseData,'error');
                }
            });
	});

	// $(document).on('change','#result_cand_race_name',function(){
	// 	race_id = $(this).val();
	// 	race_type = $(this[this.selectedIndex]).data('type');

	// 	if(ballot_id != '' || ballot_id != -1){
	// 		switch(race_type) {
	// 			case 'R':
	// 				typerpc = 'candidate';
	// 				handleRecords(ballot_id, race_id, typerpc);
	// 				$('#change_table_candidate_r').show();
	// 				$('#change_table_candidate').hide();
	// 				$('#change_table_party').hide();
	// 				break;
	// 			case 'S':
	// 				// typerpc = 'party';
	// 				typerpc = 'candidate';
	// 				handleRecords(ballot_id, race_id, typerpc);
	// 				$('#change_table_candidate').show();
	// 				$('#change_table_candidate_r').hide();
	// 				$('#change_table_party').hide();
	// 				break;
	// 			case 'P':
	// 				typerpc = 'candidate';
	// 				handleRecords(ballot_id, race_id, typerpc);
	// 				typerpc = 'party';
	// 				handleRecords(ballot_id, race_id, typerpc);
	// 				$('#change_table_candidate').show();
	// 				$('#change_table_party').show();
	// 				$('#change_table_candidate_r').hide();
	// 				break;
	// 		}
	// 	}
	// });
	$('.showDetail').click(function(){
		html2canvas(document.querySelector("#balresult")).then(canvas => {
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
