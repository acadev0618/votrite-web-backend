@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Parties
		</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							Party Table
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
										<button href="#addPartyModal" class="btn btn-primary" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-plus-circle"></i> <span>  Add Party</span></button>
										<button href="#deletePartiesModal" class="btn btn-danger" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-minus-circle"></i> <span>  Delete Parties</span></button>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover" id="party_table">
							<thead>
								<tr>
									<th class="table-checkbox">
										<input type="checkbox" class="group-checkable" data-set="#party_table .checkboxes"/>
									</th>
									<th class="table-no">
										No
									</th>
									<th>
										Party Name
									</th>
									<th>
										Party Logo
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
                                        Democrat
									</td>
									<td>
										1111111111
									</td>
									<td>
										<a href="#previewPartyModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editPartyModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deletePartyModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
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
                                        Republican
									</td>
									<td>
										1111111111
									</td>
									<td>
										<a href="#previewPartyModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editPartyModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deletePartyModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
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

<div id="addPartyModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add New Party</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-4" for="title">Party Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="party_name" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="title">Party Logo:</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" name="party_logo" autofocus>
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

<div id="editPartyModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edit The Party</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
			<div class="form-group">
                <label class="control-label col-sm-4" for="title">Party Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="party_name" value="Publican" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="title">Party Logo:</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" name="party_logo" autofocus>
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

<div id="previewPartyModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Preview The Party</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
			<div class="form-group">
                <label class="control-label col-sm-4" for="title">Party Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="party_name" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="title">Party Logo:</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" name="party_logo" readonly autofocus>
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

<div id="deletePartiesModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete Parties</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete these Parties?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-danger" value="Delete">
    </div>
</div>

<div id="deletePartyModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete The Party</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete this Party?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-danger" value="Delete">
    </div>
</div>
@endsection