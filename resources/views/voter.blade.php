@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Voters
		</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							Voter Table
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-5">
									<div class="row">
										<div class="col-md-5 form-group">
											<label class="col-sm-2 control-label select_name">Ballot:</label>
											<div class="col-sm-10">
												<select class="form-control select_ballot" name="pin_ballot" id="pin_ballot">
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
									</div>
								</div>
								<div class="col-md-7">
									<div class="btn-group ballot-actions">
										<button class="btn yellow importPinCode" data-toggle="modal"><i class="fa fa-level-down"></i> <span>  Import Excel</span></button>
										<button class="btn yellow expertPinCode" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-print"></i> <span>  Export Excel</span></button>
										<button href="#addPinCode" class="btn btn-primary addPinCode" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-plus-circle"></i> <span>  Create PinCode</span></button>
										<button class="btn btn-danger delPinCode" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-trash-o"></i> <span>  Delete PinCode</span></button>
									</div>
								</div>
							</div>
						</div>
						<div id="change_table">
							<table class="table table-striped table-bordered table-hover" id="voter_table" style='width:100%'>
								<thead>
									<tr>
										<th class="table-checkbox">
											<input type="checkbox" class="group-checkable" data-set="#voter_table .checkboxes"/>
										</th>
										<th class="table-no">
											No
										</th>
										<th>
											PinCode
										</th>
										<th>
											Expiration time
										</th>
										<th >
											Active Status
										</th>
                                        <th >
                                            Actions
                                        </th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="addPinCode" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add Pincodes</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" method="post" action="">
        @csrf
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Length of Code:</label>
                <div class="col-sm-7">
                    <input type="number" class="form-control" name="pin_length" id="add_pin_length" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Expiration Time:</label>
                <div class="col-sm-7">
					<input type="date" class="form-control" name="expire_time" id="add_expire_time" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Count of Code:</label>
                <div class="col-sm-7">
                    <input type="number" class="form-control" name="pin_count" id="add_pin_count" required>
                </div>
            </div>
            <div class="modal-footer">
                <button id="add_pin_btn" type="button" class="btn btn-success addInvoice">
                    <span class='glyphicon glyphicon-check'></span> Create
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editVoterModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edit The Voter</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" method="post" action="">
		@csrf
		
			<div class="form-group">
                <label class="control-label col-sm-5" for="title">Is Active:</label>
                <div class="col-sm-7">
					<input type="checkbox" checked="checked" id="verify_checkbox" name="verify_checkbox" class="verify_checkbox">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Expire Date:</label>
                <div class="col-sm-7">
                    <input type="date" class="form-control" name="voter_phone" id="edit_expire_time"></input>
                </div>
            </div>
            <div class="modal-footer">
			<input type="text" name="voter_id" id="edit_voter_id" value="" hidden>
                <button id="update_pin_btn" type="button" class="btn btn-success addInvoice">
                    <span class='glyphicon glyphicon-check'></span> Save
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Close
                </button>
            </div>
        </form>
    </div>
</div>

<div id="deleteVoterModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete The Voter</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete this Voter?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <form class="form-horizontal" role="form" method="post" action="">
        @csrf 
			<input type="text" class="target_id" name="target_id" hidden />
			<input type="text" class="id" name="id" hidden />
			<input type="text" class="api" name="api" hidden />
			<input type="text" id="del_voter_id"  value="" hidden />

			<button id="delete_pin_btn" type="button" class="btn btn-danger delete">
				<i class="fa fa-trash-o"></i> Delete
			</button>
			<button type="button" class="btn btn-warning" data-dismiss="modal">
				<span class='glyphicon glyphicon-remove'></span> Close
			</button>
		</form>
    </div>
</div>

<div id="deleteGroupModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete The Voters</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete this Voters?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/pinDeleteData') }}">
        @csrf 
			<input type="text" class="ballot_id" name="ballot_id" hidden />
			<input type="text" class="target_id" name="target_id" hidden />
			<input type="text" class="ids" name="ids" hidden />
			<input type="text" class="api" name="api" hidden />

			<button id="delete_group_btn" type="submit" class="btn btn-danger delete">
				<i class="fa fa-trash-o"></i> Delete
			</button>
			<button type="button" class="btn btn-warning" data-dismiss="modal">
				<span class='glyphicon glyphicon-remove'></span> Close
			</button>
		</form>
    </div>
</div>

<div id="confirmModal" class="modal fade" tabindex="-1" data-width="320">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h4 class="modal-title text-center">Confirm</h4>
	</div>
	<div class="modal-body">					
		<p class="modal_content">Please select voters.</p>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-warning" data-dismiss="modal">
			<span class='glyphicon glyphicon-remove'></span> Close
		</button>
	</div>
</div>
@endsection
@section('script')

<script>
	@if(empty($ballots->data))
	var ballot_id = '';
	var ballot_name = '';
	@else
	var ballot_id = '{{ $ballots->data[0]->ballot_id }}';
	var ballot_name = '{{ $ballots->data[0]->election }}';
	@endif
	
	function getInput(data, type, full, meta) {
		return '<div class="checker"><span><input type="checkbox" name="active_ballot_checkbox" class="checkboxes selcheck" data-id='+data+' /></span></div>';
	}
	function getChecked(data, type, full, meta) {
		if(data){
			return '<div class="checker"><span class="checked"><input type="checkbox" class="checkboxes" value="'+data+'" checked="checked" disabled /></span></div><span class="hidden">'+data+'</span>';
		}else{
			return '<div class="checker"><span><input type="checkbox" class="checkboxes" value="'+data+'" disabled/></span></div><span class="hidden">'+data+'</span>';
		}
	}
	function getAction(data, type, full, meta) {
		// console.log(full);
		if(full.is_active){
			return  '<a class="editVoterModal" data-toggle="modal" data-id='+data+' data-checked="checked" ><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a><a class="deleteVoterModal" data-toggle="modal" data-id='+data+' ><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>';
		}else{
			return  '<a class="editVoterModal" data-toggle="modal" data-id='+data+' data-checked="null" ><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a><a class="deleteVoterModal" data-toggle="modal" data-id='+data+' ><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>';
		}
	}
	
	var uploadEditor;
	uploadEditor = new $.fn.dataTable.Editor( {
		fields: [ {
			label: 'CSV file:',
			name: 'csv',
			type: 'upload',
			ajax: function ( files ) {
				// Ajax override of the upload so we can handle the file locally. Here we use Papa
				// to parse the CSV.
				Papa.parse(files[0], {
					header: false,
					skipEmptyLines: true,
					complete: function (results) {							
						uploadEditor.close();
						// console.log(parseInt(results.data.shift()[0].split(':')[1]));
						results.data.shift();
						results.data.shift();
						results.data.map(function(val){
							console.log(window.ballot_id);
							// val.unshift('<div class="checker"><span><input type="checkbox" class="checkboxes" /></span></div>');
							// if(val[4]){
							// 	val[4]='<div class="checker"><span class="checked" ><input type="checkbox" class="checkboxes" checked /></span></div>';
							// }else{
							// 	val[4]='<div class="checker"><span ><input type="checkbox" class="checkboxes" /></span></div>';
							// }
							// val.push('<a class="editVoterModal" data-toggle="modal" data-checked="null" ><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a><a class="deleteVoterModal" data-toggle="modal"  ><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>');
							var order = {
								"ballot_id": window.ballot_id,
								"is_active": val[3],
								"expiration_time": val[2],
								"pin": val[1]
							}
							$.ajax({
								type: 'POST',
								url: baseurl+'pincode/create',
								crossDomain: true,
								data: JSON.stringify(order),
								dataType: 'json',
								error: function(responseData, textStatus, jqXHR) {
									
								}
							});	
						});
						toastr.success("Pin codes added");
						handleRecords(window.ballot_id);
					}
				});
			}
		} ]
	});

	var handleRecords = function (ballot_id) {

		propurl = baseurl+'pincode?ballot_id='+ballot_id;

		var table = $('#voter_table');

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
				"zeroRecords": "No matching records found"
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
					// console.log(data);
					if(data.data != undefined){
						callback(data);
					}else{
						callback({data:[]});
					}
				}
				});
			},
			"columns": [
				{ "data": "pin", render: getInput },
				{ 
					render: function (data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
				{ "data": "pin" },
				{ "data": "expiration_time" },
				{ "data": "is_active" ,render: getChecked },
				{ "data": "pin", render: getAction },
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
				'targets': [-1]
			}, {
				"searchable": false,
				"targets": [0]
			}],
			"order": [
				[0, "asc"]
			], // set first column as a default sort by asc
			dom: 'lBfrtip',
			buttons: [
				{ 	
					"extend": 'csvHtml5', 
					"text":'<i class="fa fa-plus-circle"></i>Export EXCEL',
					"className": 'hidden' ,
					exportOptions: {
						columns: [1,2,3,4]
					},
					customize: function (xlsx) {
						console.log(xlsx);
						return " Ballot Name : "+window.ballot_name+" \n"+xlsx;
					}
				},
				{
					text: '<i class="fa fa-plus-circle"></i>Import EXCEL',
					action: function () {
						uploadEditor.create( {
							title: 'CSV file import'
						} );
					},
					"className": 'hidden importcsv'
				},
			]
		});

		table.find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
					$(this).parent().addClass("checked");
                    $(this).attr("checked", true);
                } else {
					$(this).parent().removeClass("checked");
                    $(this).attr("checked", false);
                }
            });
            jQuery.uniform.update(set);
        });

		$(document).on("change", '.checkboxes', function(event) { 
			var checked = $(this).is(":checked");
            if (checked) {
				$(this).parent().addClass("checked");
                $(this).attr("checked", true);
            } else {
				$(this).parent().removeClass("checked");
                $(this).attr("checked", false);
            }
		});		

		$(".expertPinCode").on("click", function() {
			$('.buttons-csv').trigger('click');
		});
		$(".importPinCode").on("click", function() {
			$('.importcsv').trigger('click');
		});
	}

	jQuery(document).ready(function() {
		handleRecords(ballot_id);
	});

	$(document).on('click', '.editVoterModal', function(e){
		$('#edit_voter_id').val($(this).data('id'));
		$('#verify_checkbox').val($(this).data('checked'));
		$('#verify_checkbox').attr("checked", $(this).data('checked'));
		var modal = $('#editVoterModal');
		modal.modal('show');
	}); 
	
	$(document).on('click', '.deleteVoterModal', function(e){
		$('#del_voter_id').val($(this).data('id'));
		// console.log($('#del_voter_id').val());
		var modal = $('#deleteVoterModal');
		modal.modal('show');
	}); 
		
	$('#pin_ballot').change(function(){
		ballot_id = $(this).val();
		ballot_name = $(this).text();
		if(ballot_id != '' || ballot_id != -1){
			handleRecords(ballot_id);
		}
	});

	$('#update_pin_btn').click(function(){
		var pin = $('#edit_voter_id').val();
		var order = {
			"is_active": $('#verify_checkbox').is(":checked") ? true : false,
			"expiration_time": $("#edit_expire_time").val(),
			"keys": {
				"pin": pin
			}
		}
		// console.log(order);
		$.ajax({
			type: 'POST',
			url: baseurl+'pincode/update',
			crossDomain: true,
			data: JSON.stringify(order),
			dataType: 'json',
			success: function(responseData, textStatus, jqXHR) {
				toastr.success("Pin codes Changed");
				handleRecords(ballot_id);
				var modal = $('#editVoterModal');
				modal.modal('hide');
			},
			error: function (responseData, textStatus, errorThrown) {
				alert('POST failed.');
			}
		});		
	});
	$('#delete_pin_btn').click(function(){
		var pin = $('#del_voter_id').val();
		var order = {	
			"ballot_id":window.ballot_id,		
			"pin": pin
		}
		// console.log(order);
		$.ajax({
			type: 'POST',
			url: baseurl+'pincode/delete',
			crossDomain: true,
			data: JSON.stringify(order),
			dataType: 'json',
			success: function(responseData, textStatus, jqXHR) {
				toastr.success("Pin codes Changed");
				handleRecords(window.ballot_id);
				$('#deleteVoterModal').modal('hide');;
			},
			error: function (responseData, textStatus, errorThrown) {
				alert('POST failed.');
			}
		});		
	});

	$(document).on('click', '.delPinCode', function(){
		var modal = $('#deleteGroupModal');
		var allVals = [];
		var table = $('#voter_table');
		table.find(".selcheck:checked").each(function() {  
			allVals.push($(this).data('id'));
		});

		if(allVals.length <= 0) {
			var confrim = $('#confirmModal');
			confrim.modal('show');
		} else {
			modal.modal('show');
			var target_id = 'pin';
			// console.log(allVals);
			var ids = allVals.join(",");
			var api = baseurl+'pincode/delete';

			modal.find('.ballot_id').val(ballot_id);
			modal.find('.target_id').val(target_id);
			modal.find('.ids').val(ids);
			modal.find('.api').val(api);
		}
	});
	
	$('#add_pin_btn').click(function(){
		var order = {
		"ballot_id": ballot_id,
		"pincode_len": parseInt($('#add_pin_length').val()),
		"expiration_time": $('#add_expire_time').val(),
		"pincode_count": parseInt($('#add_pin_count').val())
		}
		$.ajax({
			type: 'POST',
			url: baseurl+'pincode/multicreate',
			crossDomain: true,
			data: JSON.stringify(order),
			dataType: 'json',
			error: function(responseData, textStatus, jqXHR) {
				toastr.success("Pin codes added");
				handleRecords(ballot_id);
				var modal = $('#addPinCode');
				modal.modal('hide');
			}
		});		
	});
</script>
@endsection