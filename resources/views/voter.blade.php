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
										<button class="btn btn-primary addPinCode" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-plus-circle"></i> <span>  Create PinCode</span></button>
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
								<tbody>
								@if(empty($voters->data))
                                @else
                                    @foreach($voters->data as $voter) 
										<tr class="odd gradeX">
											<td>
												<input type="checkbox" class="checkboxes" data-id="{{ $voter->pin }}"/>
											</td>
											<td>
												{{ $loop->index+1 }}
											</td>
											<td>
												{{ $voter->pin }}
											</td>
											<td>
												{{ $voter->expiration_time }}
											</td>
											<td>
											@if($voter->is_active == 'true')
												<input type="checkbox" checked="checked" name="verify_checkbox" class="verify_checkbox" data-id="{{ $voter->pin }}">
											@else
												<input type="checkbox" name="verify_checkbox" class="verify_checkbox" data-id="{{ $voter->pin }}">
											@endif
											</td>
                                            <td>
                                                <a class="editVoterModal" data-toggle="modal" data-id="{{ $voter->pin }}" style="margin-left: 14px;"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
                                                <a class="deleteVoterModal" data-toggle="modal" data-id="{{ $voter->pin }}"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
                                            </td>
										</tr>
                                    @endforeach
                                @endif
								</tbody>
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
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/createPin') }}">
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
					<input type="datetime-local" class="form-control" name="expire_time" id="add_expire_time" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Count of Code:</label>
                <div class="col-sm-7">
                    <input type="number" class="form-control" name="pin_count" id="add_pin_count" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success addInvoice">
                    <span id="" class='glyphicon glyphicon-check'></span> Create
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
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/updateVoter') }}">
        @csrf
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Voter Email:</label>
                <div class="col-sm-7">
                    <input type="email" class="form-control" name="voter_email" id="edit_voter_email">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Vorer Phone Number:</label>
                <div class="col-sm-7">
                    <input type="number" class="form-control" name="voter_phone" id="edit_voter_phone"></input>
                </div>
            </div>
            <div class="modal-footer">
			<input type="text" name="voter_id" id="edit_voter_id" hidden>
                <button type="submit" class="btn btn-success addInvoice">
                    <span id="" class='glyphicon glyphicon-check'></span> Save
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
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/deleteData') }}">
        @csrf 
			<input type="text" class="target_id" name="target_id" hidden />
			<input type="text" class="id" name="id" hidden />
			<input type="text" class="api" name="api" hidden />

			<button type="submit" class="btn btn-danger delete">
				<i class="fa fa-trash-o"></i> Delete
			</button>
			<button type="button" class="btn btn-warning" data-dismiss="modal">
				<span class='glyphicon glyphicon-remove'></span> Close
			</button>
		</form>
    </div>
</div>

<div id="deleteVotersModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete Voters</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete these Voters?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/mutiDeleteData') }}">
		@csrf            
			<input type="text" class="ids" name="ids" hidden />
			<input type="text" class="target_id" name="target_id" hidden />
			<input type="text" class="api" name="api" hidden />

			<button type="submit" class="btn btn-danger delete">
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