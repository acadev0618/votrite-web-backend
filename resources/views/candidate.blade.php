@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Candidates
		</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							Candidate Table
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-9 select_options">
									<div class="col-md-4 form-group">
										<label class="col-sm-2 control-label select_name">Ballot:</label>
										<div class="col-sm-10">
											<select class="form-control" name="ballot_id">
												<option>Rochdale Vilage Election</opiton>
												<option>Rochdale Vilage Election</opiton>
												<option>Rochdale Vilage Election</opiton>
											</select>
										</div>
									</div>
									<div class="col-md-4 form-group">
										<label class="col-sm-2 control-label select_name">Race:</label>
										<div class="col-sm-10">
											<select class="form-control" name="race_id">
												<option>BOD</opiton>
												<option>BOD</opiton>
												<option>BOD</opiton>
											</select>
										</div>
									</div>
								
									<div class="col-md-4 form-group">
										<label class="col-sm-3 control-label select_name">Language:</label>
										<div class="col-sm-9">
											<select class="form-control" name="ballot_lang_id">
												<option>English</opiton>
												<option>Russina</opiton>
												<option>French</opiton>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="btn-group ballot-actions">
										<button href="#addCandidateModal" class="btn btn-primary" data-toggle="modal"><i class="fa fa-plus-circle"></i> <span>  Add Candidate</span></button>
										<button href="#deleteCandidatesModal" class="btn btn-danger" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-minus-circle"></i> <span>  Delete Candidates</span></button>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover" id="candidate_table">
							<thead>
								<tr>
									<th class="table-checkbox">
										<input type="checkbox" class="group-checkable" data-set="#candidate_table .checkboxes"/>
									</th>
									<th class="table-no">
										No
									</th>
									<th>
										Candidate
									</th>
									<th>
										Photo
									</th>
									<th>
										Party
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
										Andrew M. Cuomo For Governor
									</td>
									<td>
										DEMOCRAT
									</td>
									<td>
										DEMOCRAT
									</td>
									<td>
										<a href="#previewCandidateModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editCandidateModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deleteCandidateModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
									</td>
								</tr>
								<tr class="odd gradeX">
									<td>
										<input type="checkbox" class="checkboxes" value="1"/>
									</td>
									<td>
										2
									</td>
									<td>
										Anderson M. Cuomo For Governor
									</td>
									<td>
										DEMOCRAT
									</td>
									<td>
										REPUBLICAN
									</td>
									<td>
										<a href="#previewCandidateModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editCandidateModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deleteCandidateModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
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

<div id="addCandidateModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add New Race</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Ballot:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="ballot_id">
						<option>Rochdale Vilage Election</opiton>
						<option>Rochdale Vilage Election</opiton>
						<option>Rochdale Vilage Election</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Race:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="race_id">
						<option>GOV</opiton>
						<option>COMP</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Candidate Name:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="candidate_name" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Photo:</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" name="photo"></input>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Party:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="party_id">
						<option>DEMOCRAT</opiton>
						<option>REPUBLICAN</opiton>
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

<div id="editCandidateModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add New Race</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Ballot:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="ballot_id">
						<option>Rochdale Vilage Election</opiton>
						<option selected="selected">Rochdale Vilage Election</opiton>
						<option>Rochdale Vilage Election</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Race:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="race_id">
						<option selected="selected">GOV</opiton>
						<option>COMP</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Candidate Name:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="candidate_name" value="Andrew M. Cuomo For Governor" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Photo:</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" name="photo"></input>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Party:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="party_id">
						<option selected="selected">DEMOCRAT</opiton>
						<option>REPUBLICAN</opiton>
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

<div id="previewCandidateModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add New Race</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Ballot:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="ballot_id">
						<option disabled >Rochdale Vilage Election</opiton>
						<option disabled  selected="selected">Rochdale Vilage Election</opiton>
						<option disabled >Rochdale Vilage Election</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Race:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="race_id">
						<option disabled selected="selected">GOV</opiton>
						<option disabled>COMP</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Candidate Name:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="candidate_name" value="Andrew M. Cuomo For Governor" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Photo:</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" name="photo" readonly></input>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Party:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="party_id">
						<option disabled selected="selected">DEMOCRAT</opiton>
						<option disabled>REPUBLICAN</opiton>
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

<div id="deleteCandidatesModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete Candidates</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete these Candidates?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-danger" value="Delete">
    </div>
</div>

<div id="deleteCandidateModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete The Candidate</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete this Candidate?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-danger" value="Delete">
    </div>
</div>
@endsection