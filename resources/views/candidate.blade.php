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
								<div class="col-lg-7 col-md-12 col-sm-12 select_options">
									<div class="col-md-4 col-sm-12 form-group">
										<label class="col-sm-3 label_des select_name">Ballot:</label>
										<div class="col-sm-9">
											<select class="form-control" name="cand_ballot_name" id="cand_ballot_name">
											@if(empty($ballots->data))
											@else
												@foreach($ballots->data as $ballot)
													@if($ballot->ballot_id == session::get('old_cand_ballot_id'))
													<option value="{{ $ballot->ballot_id }}" selected>{{ $ballot->election }}</opiton>
													@else	
														@if($ballot->ballot_id == old('ballot_id'))
														<option value="{{ $ballot->ballot_id }}" selected>{{ $ballot->election }}</opiton>
														@else
														<option value="{{ $ballot->ballot_id }}">{{ $ballot->election }}</opiton>
														@endif
													@endif
												@endforeach
											@endif
											</select>
										</div>
									</div>
									<div class="col-md-4 col-sm-12 form-group ">
										<label class="col-sm-3 label_des select_name">Race:</label>
										<div class="col-sm-9">
											<select class="form-control" name="cand_race_name" id="cand_race_name">
											@if(empty($races->data))
											@else
												@foreach($races->data as $race)
													@if($race->race_id == session::get('old_cand_race_id'))
													<option value="{{ $race->race_id }}" selected>{{ $race->race_name }}</opiton>
													@else
														@if($race->race_id == old('race_id'))
														<option value="{{ $race->race_id }}" selected>{{ $race->race_name }}</opiton>
														@else
														<option value="{{ $race->race_id }}">{{ $race->race_name }}</opiton>
														@endif
													@endif
												@endforeach
											@endif
											</select>
										</div>
									</div>
									<div class="col-md-4 col-sm-12 form-group">
										<label class="col-sm-4 label_des select_name">Language:</label>
										<div class="col-sm-8">
											<select class="form-control" name="cand_lang_name" id="cand_lang_name">
											@if(empty($languages->data))
											@else
												@foreach($languages->data as $lang)
												<option value="{{ $lang->lang_id }}">{{ $lang->language_name }}</option>
												@endforeach
											@endif
											</select>
										</div>
									</div>
								</div>
								<div class="col-lg-5 col-md-12 col-sm-12">
									<div class="btn-group ballot-actions">
										<button class="btn btn-primary addCandidateModal" data-toggle="modal"><i class="fa fa-plus-circle"></i> <span>  Add Candidate</span></button>
										<button class="btn btn-danger deleteCandidatesModal" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-minus-circle"></i> <span>  Delete Candidates</span></button>
									</div>
								</div>
							</div>
						</div>
                        <div id='change_table'>
							<table class="table table-striped table-bordered table-hover" id="candidate_table">
								<thead>
									<tr>
										<th class="table-checkbox">
											<input type="checkbox" class="group-checkable changed_sel" data-set="#candidate_table .checkboxes"/>
										</th>
										<th class="table-no">
											No
										</th>
										<th>
											Candidate Name
										</th>
										<th style="width: 6%;">
											Candidate Photo
										</th>
										<th>
											Party Name
										</th>
										<th style="width: 6%;">
											Party Logo
										</th>
										<th style="width: 6%;">
											Actions
										</th>
									</tr>
								</thead>
								<tbody>
								@if(empty($ballots->data))
								@else
									@if(empty($races->data))
									@else
										@if(empty($candidates->data))
										@else
											@foreach($candidates->data as $candidate)
											<tr class="odd gradeX">
												<td>
													<input type="checkbox" class="checkboxes changed_sel" value="1" data-id="{{ $candidate->candidate_id }}"/>
												</td>
												<td>
													{{ $loop->index+1 }}
												</td>
												<td>
													{{ $candidate->candidate_name }}
												</td>
												<td class="text-center">
													@if(empty($candidate->photo))
													@else
													<img src="{{ $candidate->photo }}" width="60" height="60">
													@endif
												</td>
												<td>
													{{ $candidate->party_name }}
												</td>
												<td class="text-center">
													@if(empty($candidate->party_logo))
													@else
													<img src="{{ $candidate->party_logo }}" width="60" height="60">
													@endif
												</td>
												<td>
													<a class="previewCandidateModal" data-toggle="modal" data-id="{{ $candidate->candidate_id }}"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
													<a class="editCandidateModal" data-toggle="modal" data-id="{{ $candidate->candidate_id }}"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
													<a class="deleteCandidateModal" data-toggle="modal" data-id="{{ $candidate->candidate_id }}"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
												</td>
											</tr>
											@endforeach
										@endif
									@endif
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

<div id="addCandidateModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add New Candidate</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/createCandidate') }}" enctype="multipart/form-data">
			@csrf
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Candidate Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="candidate_name" required>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Candidate Photo:</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" name="photo" accept="image/png, image/jpeg"></input>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Email:</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" name="email">
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Party:</label>
                <div class="col-sm-8">
                    <select class="form-control" name="party_id" id="add_cand_party">
					@if(empty($parties->data))
						<option value="-1">No Party</opiton>
					@else
						<option value="0"></opiton>
						@foreach($parties->data as $party)
							<option value="{{ $party->party_id }}">{{ $party->party_name }}</opiton>
						@endforeach
					@endif
					</select>
                </div>
            </div>
            <div class="modal-footer">
				<input type="text" name="ballot_id" id="ballot_id" hidden/>
				<input type="text" name="race_id" id="race_id" hidden/>
				<input type="text" name="lang_id" id="lang_id" hidden/>

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

<div id="editCandidateModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edit The Candidate</h4>
    </div>
    <div class="modal-body">
		<form class="form-horizontal" role="form" method="post" action="{{ asset('/updateCandidate') }}" enctype="multipart/form-data">
			@csrf
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Candidate Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="edit_candidate_name" id="edit_candidate_name">
                </div>
            </div>
            <div class="form-group">
               <label class="label_des col-sm-4" for="title">Candidate Photo:</label>
               <div class="col-sm-8">
                  <input type="file" class="form-control" name="edit_photo" id="edit_photo" value="sdfsfd.txt" accept="image/png, image/jpeg"></input>
               </div>
            </div>
            <div class="form-group">
               <label class="label_des col-sm-4" for="title">Photo Delete:</label>
               <div class="col-sm-8" style="margin-top: 6px;">
                  <input type="checkbox" class="form-control del_photo" name="del_photo" id="del_photo"></input>
               </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Email:</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" name="edit_email" id="edit_email">
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Party:</label>
                <div class="col-sm-8">
                    <select class="form-control" name="edit_party_id" id="edit_party_id">
					@if(empty($parties->data))
						<option value="-1">No Party</opiton>
					@else
						<option value="0"></opiton>
						@foreach($parties->data as $party)
							<option value="{{ $party->party_id }}">{{ $party->party_name }}</opiton>
						@endforeach
					@endif
					</select>
                </div>
            </div>
            <div class="modal-footer">
				<input type="text" name="ballot_id" id="ballot_id" hidden/>
				<input type="text" name="race_id" id="race_id" hidden/>
				<input type="text" name="edit_lang_id" id="edit_lang_id" hidden/>
				<input type="text" name="edit_cand_id" id="edit_cand_id" hidden/>
				<input type="text" name="edit_del_photo" id="edit_del_photo" value="false" hidden/>
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

<div id="previewCandidateModal" class="modal fade" tabindex="-1" data-width="600">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Preview The Candidate</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
			<div class="form-group">
				<div class="col-sm-4">
					<label class="label_des col-sm-12" for="title">Candidate Name:</label>
				</div>
				<div class="col-sm-8">
                    <input type="text" class="form-control" id="prev_candidate_name" required readonly>
                </div>
            </div>
            <div class="form-group">
				<div class="col-sm-6">
					<label class="label_des col-sm-8" for="title">Candidate Photo:</label>
					<div class="col-sm-4">
						<img id="prev_cand_photo" style="width: 60px;">
					</div>
				</div>
				<div class="col-sm-6">
					<label class="label_des col-sm-8" for="title">Party Logo:</label>
					<div class="col-sm-4">
						<img id="prev_party_logo" style="width: 60px;">
					</div>
				</div>
            </div>
            <div class="form-group">
				<div class="col-sm-6">
					<label class="label_des col-sm-3" for="title">Email:</label>
					<div class="col-sm-9">
						<input type="email" class="form-control" id="email" readonly>
					</div>
				</div>
				<div class="col-sm-6">
					<label class="label_des col-sm-3" for="title">Party:</label>
					<div class="col-sm-9">
						<select class="form-control" id="party_id" readonly>
					@if(empty($parties->data))
						<option value="-1" disabled="disabled">No Party</opiton>
					@else
						<option value="0" disabled="disabled"></opiton>
						@foreach($parties->data as $party)
							<option value="{{ $party->party_id }}" disabled="disabled">{{ $party->party_name }}</opiton>
						@endforeach
					@endif
						</select>
					</div>
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

<div id="deleteCandidatesModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete Candidates</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete these Candidates?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
		<form class="form-horizontal" role="form" method="post" action="{{ asset('/mutiDeleteData') }}">
		@csrf           
			<input type="text" name="ballot_id" id="ballot_id" hidden/>
			<input type="text" name="race_id" id="race_id" hidden/> 
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

<div id="deleteCandidateModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete The Candidate</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete this Candidate?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
		<form class="form-horizontal" role="form" method="post" action="{{ asset('/deleteData') }}">
        @csrf 
			<input type="text" name="ballot_id" id="ballot_id" hidden /> 
			<input type="text" name="race_id" id="race_id" hidden/>
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

<div id="candConfirmModal" class="modal fade" tabindex="-1" data-width="320">
	<div class="modal-header">
		<button type="button" class="close modal_hide">×</button>
		<h4 class="modal-title text-center">Confirm</h4>
	</div>
	<div class="modal-body">					
		<p class="modal_content">Please select porpositions.</p>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-warning modal_hide">
			<span class='glyphicon glyphicon-remove'></span> Close
		</button>
	</div>
</div>
@endsection