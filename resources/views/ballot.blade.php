@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Active Ballots
		</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							Ballot Table
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-6">
									<div class="btn-group">
                                            <select class="form-control" id="active_change_option" name="active_change_option">
                                                <option value="1">Active</option>
                                                <option value="2">Show All</option>
                                            </select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="btn-group ballot-actions">
										<button href="#addBallotModal" class="btn btn-primary" data-toggle="modal"><i class="fa fa-plus-circle"></i> <span>  Add Ballot</span></button>
										<button class="btn btn-danger deleteBallotsModal" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-minus-circle"></i> <span>  Delete Ballots</span></button>
									</div>
								</div>
							</div>
						</div>
                        <div id="change_table">
                            <table class="table table-striped table-bordered table-hover" id="ballot_table">
                                <thead>
                                    <tr>
                                        <th class="table-checkbox">
                                            <input type="checkbox" class="form-control group-checkable" data-set="#ballot_table .checkboxes"/>
                                        </th>
                                        <th class="table-no">
                                            No
                                        </th>
                                        <th>
                                            Ballot
                                        </th>
                                        <th>
                                            Client
                                        </th>
                                        <th>
                                            Address
                                        </th>
                                        <th style="width: 4%;">
                                            Status
                                        </th>
                                        <th style="width: 6%;">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(empty($ballots->data))
                                    @else
                                    @foreach($ballots->data as $ballot)
                                    <tr class="odd gradeX">
                                        <td>
                                            <input type="checkbox" class="form-control checkboxes" data-id="{{ $ballot->ballot_id }}"/>
                                        </td>
                                        <td>
                                        {{ $loop->index+1 }}
                                        </td>
                                        <td id="election">
                                            {{ $ballot->election }}
                                        </td>
                                        <td>
                                            {{ $ballot->client }}
                                        </td>
                                        <td>
                                            {{ $ballot->address }}
                                        </td>
                                        <td>
                                        @if($ballot->is_delete == 'true')
                                            <!-- <input type="checkbox" name="active_ballot_checkbox" data-id="{{ $ballot->ballot_id }}"> -->
                                            Inactive
                                        @else
                                            <!-- <input type="checkbox" checked="checked" name="active_ballot_checkbox" data-id="{{ $ballot->ballot_id }}"> -->
                                            Active
                                        @endif
                                        </td>
                                        <td>
                                            <a class="previewBallotModal" data-id="{{ $ballot->ballot_id }}" data-election="{{ $ballot->election }}" data-client="{{ $ballot->client }}" data-address="{{ $ballot->address }}" data-board="{{ $ballot->board }}" data-start="{{ $ballot->start_date }}" data-end="{{ $ballot->end_date }}" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
                                            <a class="editBallotModal" data-id="{{ $ballot->ballot_id }}" data-election="{{ $ballot->election }}" data-client="{{ $ballot->client }}" data-address="{{ $ballot->address }}" data-board="{{ $ballot->board }}" data-start="{{ $ballot->start_date }}" data-end="{{ $ballot->end_date }}" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
                                            <a class="deleteBallotModal" data-id="{{ $ballot->ballot_id }}" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
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

<div id="addBallotModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title text-center">Add New Ballot</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/createBallot') }}">
        @csrf
            <div class="for-group">
                <p class="mini-title">Primary Details</p>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Client:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="client" placeholder="Example: Luna Park Housing Corporation" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Election:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="election" placeholder="Example: Election of Board of Directiors" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Address:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="address" placeholder="Example: Boorklyn, New York" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Board:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="board" placeholder="Example: Honest Ballot Association" required>
                </div>
            </div>
            <div class="for-group">
                <p class="mini-title">Times</p>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Start Date:</label>
                <div class="col-sm-9">
                    <input type="datetime-local" class="form-control" name="start_date" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">End Date:</label>
                <div class="col-sm-9">
                    <input type="datetime-local" class="form-control" name="end_date" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">
                    <span id="" class='glyphicon glyphicon-check'></span> Add
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Close
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editBallotModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title text-center">Edit The Ballot</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/updateBallot') }}">
        @csrf
            <div class="for-group">
                <p class="mini-title">Primary Details</p>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Client:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="editClient" name="client" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Election:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="editElection" name="election" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Address:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="editAddress" name="address" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Board:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="editBoard" name="board" required>
                </div>
            </div>
            <div class="for-group">
                <p class="mini-title">Times</p>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Start Date:</label>
                <div class="col-sm-9">
                    <input type="datetime-local" class="form-control" id="editStart" name="start_date" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">End Date:</label>
                <div class="col-sm-9">
                    <input type="datetime-local" class="form-control" id="editEnd" name="end_date" required>
                </div>
            </div>

            <div class="modal-footer">
                <input type="text" id="editBallot_id" name="ballot_id" hidden />
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

<div id="previewBallotModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title text-center">Preview The Ballot</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="for-group">
                <p class="mini-title">Primary Details</p>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Client:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="previewClient" name="client" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Election:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="previewElection" name="election" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Address:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="previewAddress" name="address" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Board:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="previewBoard" name="board" readonly autofocus>
                </div>
            </div>
            <div class="for-group">
                <p class="mini-title">Times</p>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Start Date:</label>
                <div class="col-sm-9">
                    <input type="datetime-local" class="form-control" id="previewStart" name="start_date" readonly>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">End Date:</label>
                <div class="col-sm-9">
                    <input type="datetime-local" class="form-control" id="previewEnd" name="end_date" readonly>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Close
                </button>
            </div>
        </form>
    </div>
</div>

<div id="deleteBallotModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title text-center">Delete The Ballot</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete this Ballot?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <form class="form-horizontal" role="from" method="post" action="{{ asset('/deleteData') }}">
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

<div id="deleteBallotsModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title text-center">Delete Ballots</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete these Ballots?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer"> 
    <form class="form-horizontal" role="form" method="post" action="{{ asset('/mutiDeleteData') }}">
		@csrf            
			<input type="text" class="ids" name="ids" hidden />
			<input type="text" class="target_id" name="target_id" hidden />
			<input type="text" class="api" name="api" hidden />
            <button type="submit" class="btn btn-danger deleteballots">
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
        <p>Please select ballots.</p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">
            <span class='glyphicon glyphicon-remove'></span> Close
        </button>
    </div>
</div>
@endsection