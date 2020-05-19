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
										<button href="#deleteVotersModal" class="btn btn-danger" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-minus-circle"></i> <span>  Delete Voters</span></button>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover" id="users_table">
							<thead>
								<tr>
									<th class="table-checkbox">
										<input type="checkbox" class="group-checkable" data-set="#users_table .checkboxes"/>
									</th>
									<th class="table-no">
										No
									</th>
									<th>
										Email
									</th>
									<th>
										Phone Number
									</th>
									<th style="width: 6%;">
										Verificaiton
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
                                        admin@admin.com
									</td>
									<td>
										1111111111
									</td>
									<td>
										<input type="checkbox" class="make-switch" data-size="small" checked data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>"> 
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

<div id="deleteVotersModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete Voters</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete these Voter?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-danger" value="Delete">
    </div>
</div>
@endsection