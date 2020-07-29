@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Locations
		</h3>
		<div class="row">
			<div class="col-md-6">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							State Table
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-6">
								</div>
								<div class="col-md-6">
									<div class="btn-group ballot-actions">
										<button class="btn btn-primary addStateModal" data-toggle="modal"><i class="fa fa-plus-circle"></i> <span>  Add State</span></button>
									</div>
								</div>
							</div>
						</div>
                        <div id='state_change_table'>
                            <table class="table table-striped table-bordered table-hover" id="state_table">
                                <thead>
                                    <tr>
                                        <th class="table-no" style="width: 10%;">
                                            No
                                        </th>
                                        <th>
                                            State Code
                                        </th>
                                        <th style="width: 10%;">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(empty($states->data))
                                @else
                                    @foreach($states->data as $state)
                                    <tr class="odd gradeX">
                                        <td>
                                            {{ $loop->index+1 }}
                                        </td>
                                        <td>
                                            {{ $state->state_code }}
                                        </td>
                                        <td>
                                            <a class="editStateModal" data-toggle="modal" data-id="{{ $state->state_id }}" data-code="{{ $state->state_code }}"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
                                            <a class="deleteStateModal" data-toggle="modal" data-id="{{ $state->state_id }}"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
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
            
			<div class="col-md-6">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							County Table
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<div class="row">
                                        <label class="col-md-3 col-sm-2 label_des select_name">State:</label>
                                        <div class="col-md-5 col-sm-4">
                                            <select class="form-control" name="loc_state_name" id="loc_state_name">
                                            @if(empty($states->data))
                                            @else
                                                @foreach($states->data as $state)
                                                    @if($state->state_id == session::get('old_state_id'))
                                                        <option value="{{ $state->state_id }}" selected>{{ $state->state_code }}</opiton>
                                                    @else
                                                        @if($state->state_id == old('old_state_id'))
                                                        <option value="{{ $state->state_id }}" selected>{{ $state->state_code }}</opiton>
                                                        @else
                                                        <option value="{{ $state->state_id }}">{{ $state->state_code }}</opiton>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                            </select>
                                        </div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6">
									<div class="btn-group ballot-actions">
										<button class="btn btn-primary addCountyModal" data-toggle="modal"><i class="fa fa-plus-circle"></i> <span>  Add County</span></button>
									</div>
								</div>
							</div>
						</div>
                        <div id='county_change_table'>
                            <table class="table table-striped table-bordered table-hover" id="county_table">
                                <thead>
                                    <tr>
                                        <th class="table-no" style="width: 10%;">
                                            No
                                        </th>
                                        <th>
                                            County Name
                                        </th>
                                        <th style="width: 10%;">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(empty($counties->data))
                                @else
                                    @foreach($counties->data as $county)
                                    <tr class="odd gradeX">
                                        <td>
                                            {{ $loop->index+1 }}
                                        </td>
                                        <td>
                                            {{ $county->county_name }}
                                        </td>
                                        <td>
                                            <a class="editCountyModal" data-toggle="modal" data-id="{{ $county->county_id }}" data-name="{{ $county->county_name }}"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
                                            <a class="deleteCountyModal" data-toggle="modal" data-id="{{ $county->county_id }}"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
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

<div id="addStateModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add New State</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/createState') }}" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">State Code:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="add_state_code" id="add_state_code" required>
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

<div id="editStateModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edit The State</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" method="post" action="{{asset('updateState')}}" enctype="multipart/form-data">
        @csrf
			<div class="form-group">
                <label class="label_des col-sm-4" for="title">State Code:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="edit_state_code" id="edit_state_code">
                </div>
            </div>
            <div class="modal-footer">
                <input type="text" name="edit_state_id" id="edit_state_id" hidden>
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

<div id="deleteStateModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete The State</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete this State?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/deleteData') }}">
        @csrf 
            <input type="text" id="id" name="id" hidden/>
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

<div id="addCountyModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add New County</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/createCounty') }}" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">County Code:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="add_county_name" id="add_county_name" required>
                </div>
            </div>
            <div class="modal-footer">
                <input type="text" name="add_state_id" id="add_state_id" hidden>
                
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

<div id="editCountyModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edit The County</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" method="post" action="{{asset('updateCounty')}}" enctype="multipart/form-data">
        @csrf
			<div class="form-group">
                <label class="label_des col-sm-4" for="title">County Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="edit_county_name" id="edit_county_name">
                </div>
            </div>
            <div class="modal-footer">
                <input type="text" name="edit_county_id" id="edit_county_id" hidden>
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

<div id="deleteCountyModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete The County</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete this County?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/deleteData') }}">
        @csrf 
            <input type="text" id="id" name="id" hidden/>
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
@endsection