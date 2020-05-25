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
										<!-- <button class="btn yellow importPinCode" data-toggle="modal"><i class="fa fa-level-down"></i> <span>  Import Excel</span></button>
										<button class="btn yellow expertPinCode" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-print"></i> <span>  Export Excel</span></button> -->
										<button class="btn btn-primary addPinCode" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-plus-circle"></i> <span>  Create PinCode</span></button>
										<button class="btn btn-danger delPinCode" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-trash-o"></i> <span>  Delete PinCode</span></button>
									</div>
								</div>
							</div>
						</div>
						<div id="change_tabel"></div>
						<table class="table table-striped table-bordered table-hover" id="voter_table">
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
										<th style="width: 6%;">
											Active Status
										</th>
                                        <th style="width: 4%;">
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
					<input type="checkbox" checked="checked" id="verify_checkbox" name="verify_checkbox" class="verify_checkbox" data-id="">
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
	@else
	var ballot_id = '{{ $ballots->data[0]->ballot_id }}';
	@endif
	
	function getInput(data, type, full, meta) {
		return '<div class="checker"><span><input type="checkbox" name="active_ballot_checkbox" class="checkboxes" data-id='+data+' /></span></div>';
	}
	function getChecked(data, type, full, meta) {
		if(data){
			return '<div class="checker"><span class="checked"><input type="checkbox" class="checkboxes" checked="checked" /></span></div>';
		}else{
			return '<div class="checker"><span><input type="checkbox" class="checkboxes" /></span></div>';
		}
	}
	function getAction(data, type, full, meta) {
		console.log(data, type, full, meta);
		return  '<a class="editVoterModal" data-toggle="modal" data-id='+data+' data-checked='+type.is_active+' ><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a><a class="deleteVoterModal" data-toggle="modal" data-id='+data+' ><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>';
	}

	var editor;

	function selectColumns ( editor, csv, header ) {
		var selectEditor = new $.fn.dataTable.Editor();
		var fields = editor.order();
	
		for ( var i=0 ; i<fields.length ; i++ ) {
			var field = editor.field( fields[i] );
	
			selectEditor.add( {
				label: field.label(),
				name: field.name(),
				type: 'select',
				options: header,
				def: header[i]
			} );
		}
	
		selectEditor.create({
			title: 'Map CSV fields',
			buttons: 'Import '+csv.length+' records',
			message: 'Select the CSV column you want to use the data from for each field.'
		});
	
		selectEditor.on('submitComplete', function (e, json, data, action) {
			// Use the host Editor instance to show a multi-row create form allowing the user to submit the data.
			editor.create( csv.length, {
				title: 'Confirm import',
				buttons: 'Submit',
				message: 'Click the <i>Submit</i> button to confirm the import of '+csv.length+' rows of data. Optionally, override the value for a field to set a common value by clicking on the field below.'
			} );
	
			for ( var i=0 ; i<fields.length ; i++ ) {
				var field = editor.field( fields[i] );
				var mapped = data[ field.name() ];
	
				for ( var j=0 ; j<csv.length ; j++ ) {
					field.multiSet( j, csv[j][mapped] );
				}
			}
		} );
	}

	var handleRecords = function (ballot_id) {

		propurl = baseurl+'pincode?ballot_id='+ballot_id;

		editor = new $.fn.dataTable.Editor( {
			ajax: function (method, url, d, successCallback, errorCallback) {
				$.ajax({
				url: propurl,
				type: 'GET',
				dataType: 'json',
				success:function(data){
					successCallback(data);
				}
				});
			},
			table: "#voter_table",
			fields: [ {
					label: "Pin codes:",
					name: "pin"
				}, {
					label: "Expire Time:",
					name: "expire_time"
				}, {
					label: "Active Status:",
					name: "is_active",
				}, {
					label: "Actions:",
					name: "ballot_id"
				}
			]
		} );
		
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
						header: true,
						skipEmptyLines: true,
						complete: function (results) {
							if ( results.errors.length ) {
								console.log( results );
								uploadEditor.field('csv').error( 'CSV parsing error: '+ results.errors[0].message );
							}
							else {
								uploadEditor.close();
								selectColumns( editor, results.data, results.meta.fields );
							}
						}
					});
				}
			} ]
		});

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
					console.log(data);
					callback(data);
				}
				});
			},
			"columns": [
				{ "data": "pin", render: getInput },
				{ render: function (data, type, row, meta) {
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
			dom: 'Bfrtip',
			buttons: [
				{ 	
					"extend": 'csvHtml5', 
					"text":'<i class="fa fa-plus-circle"></i>Export EXCEL',
					"className": 'btn yellow importPinCode' ,
					customize: function (ballot_id) {
						return "Ballot id \n"+ballot_id;
					}
				},
				{
					text: '<i class="fa fa-plus-circle"></i>Import EXCEL',
					action: function () {
						uploadEditor.create( {
							title: 'CSV file import'
						} );
					},
					"className": 'btn yellow expertPinCode'
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
		console.log($('#edit_voter_id').val());
		var modal = $('#deleteVoterModal');
		modal.modal('show');
	}); 
		
	$('#pin_ballot').change(function(){
		ballot_id = $(this).val();
		if(ballot_id != '' || ballot_id != -1){
			handleRecords(ballot_id);
		}
	});

	$('#update_pin_btn').click(function(){
		var pin = $('#edit_voter_id').val();
		var order = {
			"is_active": $('#verify_checkbox').val(),
			"expiration_time": $("#edit_expire_time").val(),
			"keys": {
				"pin": pin
			}
		}
		console.log(order);
		$.ajax({
			type: 'POST',
			url: baseurl+'pincode/update',
			crossDomain: true,
			data: JSON.stringify(order),
			dataType: 'json',
			success: function(responseData, textStatus, jqXHR) {
				toastr.success("Pin codes Changed");
			},
			error: function (responseData, textStatus, errorThrown) {
				alert('POST failed.');
			}
		});		
	});

	$('#delete_pin_btn').click(function(){
		var pin = $('#edit_voter_id').val();
		var order = {
			"ballot_id":ballot_id,
			"pin":pin
		}
		console.log(order);
		$.ajax({
			type: 'POST',
			url: baseurl+'pincode/delete',
			crossDomain: true,
			data: JSON.stringify(order),
			dataType: 'json',
			success: function(responseData, textStatus, jqXHR) {
				toastr.success("Pin deleted");
			},
			error: function (responseData, textStatus, errorThrown) {
				alert('POST failed.');
			}
		});		
	});

	
	$('#add_pin_btn').click(function(){
		var order = {
		"ballot_id": ballot_id,
		"pincode_len": parseInt($('#add_pin_length').val()),
		"expiration_time": $('#add_expire_time').val(),
		"pincode_count": parseInt($('#add_pin_count').val())
		}
		console.log(order);
		$.ajax({
			type: 'POST',
			url: baseurl+'pincode/multicreate',
			crossDomain: true,
			data: JSON.stringify(order),
			dataType: 'json',
			success: function(responseData, textStatus, jqXHR) {
				toastr.success("Pin codes added");
			},
			error: function (responseData, textStatus, errorThrown) {
				alert('POST failed.');
			}
		});		
	});
</script>
@endsection