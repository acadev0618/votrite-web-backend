@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Countries
		</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							Country Table
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
										<label class="col-sm-2 control-label select_name">State:</label>
										<div class="col-sm-10">
											<select class="form-control" name="location_id">
												<option>AR</opiton>
												<option>AR</opiton>
												<option>AR</opiton>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="btn-group ballot-actions">
										<button href="#addCountryModal" class="btn btn-primary" data-toggle="modal"><i class="fa fa-plus-circle"></i> <span>  Add Country</span></button>
										<button href="#deleteCountrisModal" class="btn btn-danger" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-minus-circle"></i> <span>  Delete Countries</span></button>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover" id="country_table">
							<thead>
								<tr>
									<th class="table-checkbox">
										<input type="checkbox" class="group-checkable" data-set="#country_table .checkboxes"/>
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
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="addCountryModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add New Race</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">International Race Name:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="race_name" placeholder="Example: LElection of Board of Directiors" autofocus>
                </div>
            </div>
			<div class="form-group">
				<div class="col-sm-7 col-sm-offset-5">
					<input class="form-control" type="checkbox">
					<label class="control-label" for="title">Rank Voting</label>
				</div>
			</div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Mimimum number of votes:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="min_num_of_vote">
						<option>0</opiton>
						<option>1</opiton>
						<option>2</opiton>
						<option>3</opiton>
						<option>4</opiton>
						<option>5</opiton>
						<option>6</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Maximum number of votes:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="max_num_of_votes">
						<option>1</opiton>
						<option>2</opiton>
						<option>3</opiton>
						<option>4</opiton>
						<option>5</opiton>
						<option>6</opiton>
						<option>7</opiton>
						<option>8</opiton>
						<option>9</opiton>
						<option>10</opiton>
						<option>11</opiton>
						<option>12</opiton>
						<option>13</opiton>
						<option>14</opiton>
						<option>15</opiton>
						<option>16</opiton>
						<option>17</opiton>
						<option>18</opiton>
					</select>
                </div>
			</div>
			<div class="form-group">
                <label class="control-label col-sm-5" for="title">Maximum number of Write-Ins:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="max_num_of_write_ins">
						<option>0</opiton>
						<option>1</opiton>
						<option>2</opiton>
						<option>3</opiton>
					</select>
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose language:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="race_lang_id">
						<option>English</opiton>
						<option>Russia</opiton>
						<option>Franch</opiton>
					</select>
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose country:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="race_location_id,">
						<option>AAAA</opiton>
						<option>BBBB</opiton>
						<option>CCCC</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Race title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="race_title," placeholder="Example: Election of Board of Directors" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Voted Position:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="race_voted_position" autofocus></textarea>
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

<div id="editCountryModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edit The Cnadidate</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">International Race Name:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="race_name" placeholder="Example: LElection of Board of Directiors" value="GOV" autofocus>
                </div>
            </div>
			<div class="form-group">
				<div class="col-sm-7 col-sm-offset-5">
					<input class="form-control" type="checkbox">
					<label class="control-label" for="title">Rank Voting</label>
				</div>
			</div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Mimimum number of votes:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="min_num_of_vote">
						<option>0</opiton>
						<option>1</opiton>
						<option selected="selected">2</opiton>
						<option>3</opiton>
						<option>4</opiton>
						<option>5</opiton>
						<option>6</opiton>
					</select>
                </div>
			</div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Maximum number of votes:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="max_num_of_votes">
						<option>1</opiton>
						<option>2</opiton>
						<option>3</opiton>
						<option>4</opiton>
						<option selected="selected">5</opiton>
						<option>6</opiton>
						<option>7</opiton>
						<option>8</opiton>
						<option>9</opiton>
						<option>10</opiton>
						<option>11</opiton>
						<option>12</opiton>
						<option>13</opiton>
						<option>14</opiton>
						<option>15</opiton>
						<option>16</opiton>
						<option>17</opiton>
						<option>18</opiton>
					</select>
                </div>
			</div>
			<div class="form-group">
                <label class="control-label col-sm-5" for="title">Maximum number of Write-Ins:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="max_num_of_write_ins">
						<option>0</opiton>
						<option>1</opiton>
						<option selected="selected">2</opiton>
						<option>3</opiton>
					</select>
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose language:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="race_lang_id">
						<option>English</opiton>
						<option selected="selected">Russia</opiton>
						<option>Franch</opiton>
					</select>
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose country:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="race_location_id">
						<option>AAAA</opiton>
						<option selected="selected">BBBB</opiton>
						<option>CCCC</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Race title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="race_title," placeholder="Example: Election of Board of Directors" value="State Wide Races" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Voted Position:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="race_voted_position" autofocus>Candidates for : GOVERNOR AND LIEUTENANT GOVERNOR</textarea>
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

<div id="previewCountryModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Preview The Candidate</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">International Race Name:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="race_name" placeholder="Example: LElection of Board of Directiors" value="GOV" readonly autofocus>
                </div>
            </div>
			<div class="form-group">
				<div class="col-sm-7 col-sm-offset-5">
					<input class="form-control" type="checkbox" readonly>
					<label class="control-label" for="title">Rank Voting</label>
				</div>
			</div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Mimimum number of votes:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="min_num_of_vote" readonly>
						<option disabled>0</opiton>
						<option disabled>1</opiton>
						<option disabled selected="selected">2</opiton>
						<option disabled>3</opiton>
						<option disabled>4</opiton>
						<option disabled>5</opiton>
						<option disabled>6</opiton>
					</select>
                </div>
			</div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Maximum number of votes:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="max_num_of_votes">
						<option disabled>1</opiton>
						<option disabled>2</opiton>
						<option disabled>3</opiton>
						<option disabled>4</opiton>
						<option disabled selected="selected">5</opiton>
						<option disabled>6</opiton>
						<option disabled>7</opiton>
						<option disabled>8</opiton>
						<option disabled>9</opiton>
						<option disabled>10</opiton>
						<option disabled>11</opiton>
						<option disabled>12</opiton>
						<option disabled>13</opiton>
						<option disabled>14</opiton>
						<option disabled>15</opiton>
						<option disabled>16</opiton>
						<option disabled>17</opiton>
						<option disabled>18</opiton>
					</select>
                </div>
			</div>
			<div class="form-group">
                <label class="control-label col-sm-5" for="title">Maximum number of Write-Ins:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="max_num_of_write_ins">
						<option disabled>0</opiton>
						<option disabled>1</opiton>
						<option disabled selected="selected">2</opiton>
						<option disabled>3</opiton>
					</select>
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose language:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="race_lang_id">
						<option disabled>English</opiton>
						<option disabled selected="selected">Russia</opiton>
						<option disabled>Franch</opiton>
					</select>
                </div>
            </div>
			<div class="form-group">
                <label class="control-label col-sm-5" for="title">Choose country:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="race_location_id">
						<option disabled>AAAA</opiton>
						<option disabled selected="selected">BBBB</opiton>
						<option disabled>CCCC</opiton>
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Race title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="race_title," placeholder="Example: Election of Board of Directors" value="State Wide Races" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Voted Position:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="race_voted_position" readonly autofocus>Candidates for : GOVERNOR AND LIEUTENANT GOVERNOR</textarea>
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

<div id="deleteCountrisModal" class="modal fade" tabindex="-1" data-width="520">
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

<div id="deleteCountryModal" class="modal fade" tabindex="-1" data-width="520">
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