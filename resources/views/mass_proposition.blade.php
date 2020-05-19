@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Mass Propositions
		</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							Mass Proposition Table
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-5 form-group">
											<label class="col-sm-2 control-label select_name">Ballot:</label>
											<div class="col-sm-10">
												<select class="form-control" name="ballot_id">
													<option>Rochdale Vilage Election</opiton>
													<option>Rochdale Vilage Election</opiton>
													<option>Rochdale Vilage Election</opiton>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="btn-group ballot-actions">
										<button href="#addMassPropositionModal" class="btn btn-primary" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-plus-circle"></i> <span>  Add Mass Proposition</span></button>
										<button href="#deleteMassPropositionsModal" class="btn btn-danger" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-minus-circle"></i> <span>  Delete Mass Proposiitons</span></button>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover" id="mass_proposition_table">
							<thead>
								<tr>
									<th class="table-checkbox">
										<input type="checkbox" class="group-checkable" data-set="#mass_proposition_table .checkboxes"/>
									</th>
									<th class="table-no">
										No
									</th>
									<th>
										Title
									</th>
									<th>
										Current Article Read
									</th>
									<th>
										Proposed Change To Read
									</th>
									<th>
										Proposition Answer
									</th>
									<th style="width: 6%;">
										Actions
									</th>
								</tr>
							</thead>
							<tbody>
								<tr class="odd gradeX">
									<td>
										<input type="checkbox" class="checkboxes" value="1"/>
									</td>
									<td>
										1
									</td>
									<td>
										MP 1
									</td>
									<td>
									This is a change in the current article that reads the text to test the save and translate functionality
									</td>
									<td>
									Proposed change to read
									</td>
									<td>
										YES/NO
									</td>
									<td>
										<a href="#previewMassPropositionModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editMassPropositionModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deleteMassPropositionModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="addMassPropositionModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add New Mass Proposition</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose Ballot:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="ballot_id">
						<option>Rochdale Vilage Election</opiton>
						<option>Rochdale Vilage Election</opiton>
						<option>Rochdale Vilage Election</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Mass Proposition Title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="mass_prop_title" placeholder="Example: LElection of Board of Directiors" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Current Article Read:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="mass_prop_article"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Proposed Change To Read:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="mass_prop_change"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Mass Proposition Answer:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="mass_prop_answer_type">
						<option>YES/NO</opiton>
						<option>FOR/AGAIST</opiton>
					</select>
                </div>
			</div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success addInvoice">
                    <span id="" class='glyphicon glyphicon-check'></span> Add
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Close
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editMassPropositionModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edit The Mass Proposition</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose Ballot:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="ballot_id">
						<option>Rochdale Vilage Election</opiton>
						<option selected="selected">Rochdale Vilage Election</opiton>
						<option>Rochdale Vilage Election</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Mass Proposition Title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="mass_prop_title" value="MP 1">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Current Article Read:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="mass_prop_article">This is a change in the current article that reads the text to test the save and translate functionality</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Proposed Change To Read:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="mass_prop_change">Proposed change to read</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Mass Proposition Answer:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="mass_prop_answer_type">
						<option selected="selected">YES/NO</opiton>
						<option>FOR/AGAIST</opiton>
					</select>
                </div>
			</div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success addInvoice">
                    <span id="" class='glyphicon glyphicon-check'></span> Edit
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Close
                </button>
            </div>
        </form>
    </div>
</div>

<div id="previewMassPropositionModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Preview The Mass Proposition</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose Ballot:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="ballot_id">
						<option disabled>Rochdale Vilage Election</opiton>
						<option disabled selected="selected">Rochdale Vilage Election</opiton>
						<option disabled>Rochdale Vilage Election</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Mass Proposition Title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="mass_prop_title" value="MP 1" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Current Article Read:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="mass_prop_article" readonly>This is a change in the current article that reads the text to test the save and translate functionality</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Proposed Change To Read:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="mass_prop_change" readonly>Proposed change to read</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Mass Proposition Answer:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="mass_prop_answer_type">
						<option disabled selected="selected">YES/NO</opiton>
						<option disabled>FOR/AGAIST</opiton>
					</select>
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

<div id="deleteMassPropositionsModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete Mass Propositions</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete these mass propositions?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-danger" value="Delete">
    </div>
</div>

<div id="deleteMassPropositionModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete The Mass Proposition</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete this mass proposition?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-danger" value="Delete">
    </div>
</div>
@endsection