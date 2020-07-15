
<table class="table table-striped table-bordered table-hover" id="proposition_table">
	<thead>
		<tr>
			<th class="table-checkbox">
				<input type="checkbox" class="group-checkable changed_sel" data-set="#proposition_table .checkboxes" style="margin-left: 5px; margin-right: 5px;"/>
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
	@if(empty($ballots->data))
	@else
		@if(empty($propositions->data))
		@else
			@foreach($propositions->data as $prop)
			<tr class="odd gradeX">
				<td>
					<input type="checkbox" class="checkboxes changed_sel" value="1" data-id="{{ $prop->proposition_id }}" style="margin-left: 5px; margin-right: 5px;"/>
				</td>
				<td>
					{{ $loop->index+1 }}
				</td>
				<td>
					{{ $prop->prop_name }}
				</td>
				<td>
					{{ $prop->prop_name }}
				</td>
				<td>
				@if($prop->prop_answer_type == '1')
					YES/NO
				@else
					FOR/AGAINST
				@endif
				</td>
				<td>
					<a class="preview previewPropositionModal" data-toggle="modal" data-id="{{ $prop->proposition_id }}"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
					<a class="editPropositionModal" data-toggle="modal" data-id="{{ $prop->proposition_id }}"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
					<a class="deletePropositionModal" data-toggle="modal" data-id="{{ $prop->proposition_id }}"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
				</td>
			</tr>
			@endforeach
		@endif
	@endif
	</tbody>
</table>

<div id="addPropositionModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add New Proposition</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/createProposition') }}">
		@csrf
            <div class="form-group">
                <label class="label_des col-sm-5" for="title">International Proposition Name:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="prop_name" id="prop_name" placeholder="Example: LElection of Board of Directiors" required>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-5" for="title">Choose Language:</label>
                <div class="col-sm-7">
					<select class="form-control" name="prop_lang_id" id="add_prop_lang_id">
						@if(empty($languages->data))
						<option value="0">No Language</option>
						@else
							@foreach($languages->data as $lang)
							<option value="{{ $lang->ballot_lang_id }}">{{ $lang->language_name }}</option>
							@endforeach
						@endif
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-5" for="title">Proposition Answer:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_answer_type" id="prop_answer_type">
						<option value='1'>YES/NO</option>
						<option value='2'>FOR/AGAINST</option>
					</select>
                </div>
			</div>
			<div class="form-group">
                <label class="label_des col-sm-5" for="title">Choose County:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_location_id" id="prop_location_id">
					@if(empty($counties->data))
					<option value="0" value="0">No Counties</option>
					@else
						@foreach($counties->data as $county)
						<option value="{{ $county->ballot_county_id }}">{{ $county->county_name }}</option>
						@endforeach
					@endif
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-5" for="title">Proposition Title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="prop_title" id="prop_title" placeholder="Example: Proposition 1" required>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-5" for="title">Proposition Text:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="prop_text" id="prop_text"></textarea>
                </div>
            </div>
            <div class="modal-footer">
				<input type="text" name="ballot_id" id="ballot_id" hidden />
				<input type="text" name="prop_type" value="P" hidden />
                <button type="submit" class="btn btn-success" id="add">
                    <span class="glyphicon glyphicon-check"></span> Add
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
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/updateProposition') }}">
		@csrf
			<div class="form-group">
                <label class="label_des col-sm-5" for="title">International Proposition Name:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="prop_name" id="edit_prop_name">
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-5" for="title">Choose Language:</label>
                <div class="col-sm-7">
					<select class="form-control" name="prop_lang_id" id="edit_prop_lang_id">
						@if(empty($languages->data))
						<option value="0">No Language</option>
						@else
							@foreach($languages->data as $lang)
							<option value="{{ $lang->ballot_lang_id }}" >{{ $lang->language_name }}</option>
							@endforeach
						@endif
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-5" for="title">Proposition Answer:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_answer_type" id="edit_prop_answer_type">
						<option value='1'>YES/NO</option>
						<option value='2'>FOR/AGAINST</option>
					</select>
                </div>
			</div>
			<div class="form-group">
                <label class="label_des col-sm-5" for="title">Choose County:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_location_id" id="edit_prop_location_id">
					@if(empty($counties->data))
					<option value="0">No Counties</option>
					@else
						@foreach($counties->data as $county)
						<option value="{{ $county->ballot_county_id }}">{{ $county->county_name }}</option>
						@endforeach
					@endif
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-5" for="title">Proposition Title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="prop_title" id="edit_prop_title">
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-5" for="title">Proposition Text:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="prop_text" id="edit_prop_text"></textarea>
                </div>
            </div>
            <div class="modal-footer">
				<input type="text" name="ballot_id" id="ballot_id" hidden />
                <input type="text" id="edit_prop_id" name="prop_id" hidden>
                <input type="text" name="prop_type" value="P" hidden>
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

<div id="previewPropositionModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Preview The Proposition</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
			<div class="form-group">
                <label class="label_des col-sm-5" for="title">International Proposition Name:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="prop_name" id="prev_prop_name" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-5" for="title">Choose Language:</label>
                <div class="col-sm-7">
					<select class="form-control" name="prop_lang_id" id="prev_prop_lang_id" readonly>
						@if(empty($languages->data))
						<option value="0" disabled>No Language</option>
						@else
							@foreach($languages->data as $lang)
							<option value="{{ $lang->ballot_lang_id }}" disabled >{{ $lang->language_name }}</option>
							@endforeach
						@endif
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-5" for="title">Proposition Answer:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_answer_type" id="prev_prop_answer_type" readonly>
						<option value='1' disabled>YES/NO</option>
						<option value='2' disabled>FOR/AGAINST</option>
					</select>
                </div>
			</div>
			<div class="form-group">
                <label class="label_des col-sm-5" for="title">Choose County:</label>
                <div class="col-sm-7">
                    <select class="form-control" name="prop_location_id" id="prev_prop_location_id" readonly>
					@if(empty($counties->data))
					<option value="0" disabled>No Counties</option>
					@else
						@foreach($counties->data as $county)
						<option value="{{ $county->ballot_county_id }}" disabled>{{ $county->county_name }}</option>
						@endforeach
					@endif
					</select>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-5" for="title">Proposition Title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="prop_title" id="prev_prop_title" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-5" for="title">Proposition Text:</label>
                <div class="col-sm-7">
                    <textarea type="text" class="form-control" name="prop_text" id="prev_prop_text" readonly></textarea>
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

<div id="deletePropositionsModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete Propositions</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete these Propositions?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
		<form class="form-horizontal" role="form" method="post" action="{{ asset('/mutiDeleteData') }}">
		@csrf      
            <input type="text" name="ballot_id" id="ballot_id" hidden />      
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

<div id="deletePropositionModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete The Proposition</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete this Proposition?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
		<form class="form-horizontal" role="form" method="post" action="{{ asset('/deleteData') }}">
        @csrf 
            <input type="text" name="ballot_id" id="ballot_id" hidden />
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