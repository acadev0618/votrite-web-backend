@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Propositions
		</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							Proposition Table
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
										<!-- <a href="{{ asset('/mass_proposition') }}" class="btn btn-warning" data-toggle="modal"><i lass="fa fa-edit"></i> <span>  Mass Change Proposition</span></a> -->
										<button href="#addPropositionModal" class="btn btn-primary" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-plus-circle"></i> <span>  Add Proposition</span></button>
										<button href="#deletePropositionsModal" class="btn btn-danger" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-minus-circle"></i> <span>  Delete Proposiitons</span></button>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover" id="proposition_table">
							<thead>
								<tr>
									<th class="table-checkbox">
										<input type="checkbox" class="group-checkable" data-set="#proposition_table .checkboxes"/>
									</th>
									<th class="table-no">
										No
									</th>
									<th>
										Proposition Name
									</th>
									<th>
										Proposition Title
									</th>
									<th>
										Answer Type
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
										Proposition 1
									</td>
									<td>
									PROPOSAL NUMBER ONE,  AN AMENDMENT
									</td>
									<td>
										YES/NO
									</td>
									<td>
										<a href="#previewPropositionModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editPropositionModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deletePropositionModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
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
										Proposition 2
									</td>
									<td>
									PROPOSAL NUMBER ONE,  AN AMENDMENT
									</td>
									<td>
										FOR/AGAIST
									</td>
									<td>
										<a href="#previewPropositionModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editPropositionModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deletePropositionModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
									</td>
								</tr>
								<tr class="odd gradeX">
									<td>
										<input type="checkbox" class="checkboxes" value="1"/>
									</td>
									<td>
										4
									</td>
									<td>
										Proposition 4
									</td>
									<td>
									PROPOSAL NUMBER ONE,  AN AMENDMENT
									</td>
									<td>
										YES/NO
									</td>
									<td>
										<a href="#previewPropositionModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editPropositionModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deletePropositionModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
									</td>
								</tr>
								<tr class="odd gradeX">
									<td>
										<input type="checkbox" class="checkboxes" value="1"/>
									</td>
									<td>
										4
									</td>
									<td>
										Proposition 4
									</td>
									<td>
									PROPOSAL NUMBER ONE,  AN AMENDMENT
									</td>
									<td>
										YES/NO
									</td>
									<td>
										<a href="#previewPropositionModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editPropositionModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deletePropositionModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
									</td>
								</tr>
								<tr class="odd gradeX">
									<td>
										<input type="checkbox" class="checkboxes" value="1"/>
									</td>
									<td>
										5
									</td>
									<td>
										Proposition 5
									</td>
									<td>
									PROPOSAL NUMBER ONE,  AN AMENDMENT
									</td>
									<td>
										FOR/AGAINST
									</td>
									<td>
										<a href="#previewPropositionModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editPropositionModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deletePropositionModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
									</td>
								</tr>
								<tr class="odd gradeX">
									<td>
										<input type="checkbox" class="checkboxes" value="1"/>
									</td>
									<td>
										6
									</td>
									<td>
										Proposition 6
									</td>
									<td>
									PROPOSAL NUMBER ONE,  AN AMENDMENT
									</td>
									<td>
										YES/NO
									</td>
									<td>
										<a href="#previewPropositionModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editPropositionModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deletePropositionModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
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

<div id="addPropositionModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add New Proposition</h4>
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
                <label class="control-label col-sm-5" for="title">International Proposition Name:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="prop_name" placeholder="Example: LElection of Board of Directiors" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose Language:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_lang_id">
						<option>English</opiton>
						<option>Russian</opiton>
						<option>French</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Proposition Answer:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_answer_type">
						<option>YES/NO</opiton>
						<option>FOR/AGAIST</opiton>
					</select>
                </div>
			</div>
			<div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose Country:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_location_id">
						<option>Country 1</opiton>
						<option>Country 2</opiton>
						<option>Country 3</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Proposition Title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="prop_title," placeholder="Example: Proposition 1" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Proposition Text:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="prop_text" autofocus></textarea>
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

<div id="editPropositionModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edit The Proposition</h4>
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
                <label class="control-label col-sm-5" for="title">International Proposition Name:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="prop_name" value="Proposition 1" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose Language:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_lang_id">
						<option selected="selected">English</opiton>
						<option>Russian</opiton>
						<option>French</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Proposition Answer:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_answer_type">
						<option selected="selected">YES/NO</opiton>
						<option>FOR/AGAIST</opiton>
					</select>
                </div>
			</div>
			<div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose Country:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_location_id">
						<option>Country 1</opiton>
						<option selected="selected">Country 2</opiton>
						<option>Country 3</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Proposition Title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="prop_title," value="Proposition 1" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Proposition Text:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="prop_text" autofocus>Proposition 1</textarea>
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

<div id="previewPropositionModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Preview The Proposition</h4>
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
                <label class="control-label col-sm-5" for="title">International Proposition Name:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="prop_name" value="Proposition 1" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose Language:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_lang_id">
						<option disabled selected="selected">English</opiton>
						<option disabled>Russian</opiton>
						<option disabled>French</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Proposition Answer:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_answer_type">
						<option disabled selected="selected">YES/NO</opiton>
						<option disabled>FOR/AGAIST</opiton>
					</select>
                </div>
			</div>
			<div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose Country:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_location_id">
						<option disabled>Country 1</opiton>
						<option disabled selected="selected">Country 2</opiton>
						<option disabled>Country 3</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Proposition Title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="prop_title," value="Proposition 1" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Proposition Text:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="prop_text" readonly autofocus>Proposition 1</textarea>
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

<div id="deletePropositionsModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete Propositions</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete these Propositions?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-danger" value="Delete">
    </div>
</div>

<div id="deletePropositionModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete The Proposition</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete this Proposition?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-danger" data-dismiss="modal" value="Delete">
    </div>
</div>
@endsection