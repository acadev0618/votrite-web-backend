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
								<div class="col-md-6 col-md-offset-6">
									<div class="btn-group ballot-actions">
										<button href="#addBallotModal" class="btn btn-primary" data-toggle="modal"><i class="fa fa-plus-circle"></i> <span>  Add Ballot</span></button>
										<button class="btn btn-danger deleteBallotsModal" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-minus-circle"></i> <span>  Delete Ballots</span></button>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover" id="ballot_table">
							<thead>
								<tr>
									<th class="table-checkbox">
										<input type="checkbox" class="group-checkable" data-set="#ballot_table .checkboxes"/>
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
									<th style="width: 6%;">
										Actions
									</th>
								</tr>
							</thead>
							<tbody>
                                @foreach($ballots as $ballot)
								<tr class="odd gradeX">
									<td>
										<input type="checkbox" class="checkboxes" data-id="{{ $ballot->ballot_id }}"/>
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
										<a class="previewBallotModal" data-id="{{ $ballot->ballot_id }}" data-election="{{ $ballot->election }}" data-client="{{ $ballot->client }}" data-address="{{ $ballot->address }}" data-board="{{ $ballot->board }}" data-start="{{ $ballot->start_date }}" data-end="{{ $ballot->end_date }}" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a class="editBallotModal" data-id="{{ $ballot->ballot_id }}" data-election="{{ $ballot->election }}" data-client="{{ $ballot->client }}" data-address="{{ $ballot->address }}" data-board="{{ $ballot->board }}" data-start="{{ $ballot->start_date }}" data-end="{{ $ballot->end_date }}" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a class="deleteBallotModal" data-id="{{ $ballot->ballot_id }}" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
									</td>
                                </tr>
                                @endforeach
							</tbody>
						</table>
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
                <label class="control-label col-sm-3" for="title">Client:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="client" placeholder="Example: Luna Park Housing Corporation" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Election:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="election" placeholder="Example: Election of Board of Directiors" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Address:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="address" placeholder="Example: Boorklyn, New York" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Board:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="board" placeholder="Example: Honest Ballot Association" required>
                </div>
            </div>
            <div class="for-group">
                <p class="mini-title">Times</p>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Start Date:</label>
                <div class="col-sm-9">
                    <input type="datetime-local" class="form-control" name="start_date" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">End Date:</label>
                <div class="col-sm-9">
                    <input type="datetime-local" class="form-control" name="end_date" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Close
                </button>
                <button type="submit" class="btn btn-success">
                    <span id="" class='glyphicon glyphicon-check'></span> Add
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
                <label class="control-label col-sm-3" for="title">Client:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="editClient" name="client" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Election:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="editElection" name="election" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Address:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="editAddress" name="address" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Board:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="editBoard" name="board" required>
                </div>
            </div>
            <div class="for-group">
                <p class="mini-title">Times</p>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Start Date:</label>
                <div class="col-sm-9">
                    <input type="datetime-local" class="form-control" id="editStart" name="start_date" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">End Date:</label>
                <div class="col-sm-9">
                    <input type="datetime-local" class="form-control" id="editEnd" name="end_date" required>
                </div>
            </div>

            <div class="modal-footer">
                <input type="text" id="editBallot_id" name="ballot_id" hidden />
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Close
                </button>
                <button type="submit" class="btn btn-success addInvoice">
                    <span id="" class='glyphicon glyphicon-check'></span> Edit
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
                <label class="control-label col-sm-3" for="title">Client:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="previewClient" name="client" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Election:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="previewElection" name="election" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Address:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="previewAddress" name="address" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Board:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="previewBoard" name="board" readonly autofocus>
                </div>
            </div>
            <div class="for-group">
                <p class="mini-title">Times</p>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Start Date:</label>
                <div class="col-sm-9">
                    <input type="datetime-local" class="form-control" id="previewStart" name="start_date" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">End Date:</label>
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
        <form class="form-horizontal" role="from" method="post" action="{{ asset('/deleteBallot') }}">
        @csrf
            <input type="text" name="ballot_id" id="ballot_id" hidden>
			<button type="button" class="btn btn-warning" data-dismiss="modal">
				<span class='glyphicon glyphicon-remove'></span> Close
			</button>
			<button type="submit" class="btn btn-danger delete">
				<i class="fa fa-trash-o"></i> Delete
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
        <form class="form-horizontal" role="from" method="post" action="{{ asset('/deleteBallots') }}">
        @csrf
            <input class="ballot_ids" name="ids" hidden>
            <button type="button" class="btn btn-warning" data-dismiss="modal">
                <span class='glyphicon glyphicon-remove'></span> Close
            </button>
            <button type="submit" class="btn btn-danger deleteballots">
                <i class="fa fa-trash-o"></i> Delete
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