@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Users
		</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							User Table
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-6 col-md-offset-6">
									<div class="btn-group ballot-actions">
										<a class="btn btn-primary addUserModal" data-toggle="modal" href="#addUserModal"><i class="fa fa-plus-circle"></i><span>  Add User</span></a>
										<button class="btn btn-danger deleteUsersModal" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-minus-circle"></i><span>  Delete Users</span></button>
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
										Username
									</th>
									<th>
										Alias
									</th>
									<th>
										Email
									</th>
									<th style="width: 6%;">
										Actions
									</th>
								</tr>
							</thead>
							<tbody>
                                @if(empty($users->data))
                                @else
                                    @foreach($users->data as $user) 
                                    <tr class="odd gradeX">
                                        <td>
                                            <input type="checkbox" class="checkboxes" value="{{ $user->user_id }}" data-id="{{ $user->user_id }}"/>
                                        </td>
                                        <td>
                                        {{ $loop->index+1 }}
                                        </td>
                                        <td>
                                            {{ $user->user_name }}
                                        </td>
                                        <td>
                                            {{ $user->display_name }}
                                        </td>
                                        <td>
                                            {{ $user->user_email }}
                                        </td>
                                        <td>
                                            <a class="previewUserModal" data-toggle="modal" data-id="{{ $user->user_id }}" data-username="{{ $user->user_name }}" data-alias="{{ $user->display_name }}" data-email="{{ $user->user_email }}" data-password="{{ $user->user_password }}" data-avatar="{{ $user->user_avatar }}"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
                                            <a class="editUserModal" data-toggle="modal" data-id="{{ $user->user_id }}" data-username="{{ $user->user_name }}" data-alias="{{ $user->display_name }}" data-email="{{ $user->user_email }}" data-password="{{ $user->user_password }}" data-avatar="{{ $user->user_avatar }}"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
                                            <a class="deleteUserModal" data-toggle="modal" data-id="{{ $user->user_id }}"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
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

<div id="addUserModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title text-center">Add New User</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/createUser') }}" enctype="multipart/form-data">
		@csrf
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">User Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="user_name" id="add_user_name" required>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Alias:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="display_name" id="add_display_name" required>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Email:</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" name="user_email" id="add_user_email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Password:</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="user_password" id="add_user_password" required>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Avatar:</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" name="user_avatar" id="add_user_avatar">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success add">
                    <span id="" class='glyphicon glyphicon-check'></span> Add
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Close
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editUserModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title text-center">Edit The User</h4>
    </div>
    <div class="modal-body">
		<form class="form-horizontal" role="form" method="post" action="{{ asset('/updateUser') }}" enctype="multipart/form-data">
		@csrf
		<div class="form-group">
                <label class="label_des col-sm-4" for="title">User Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="user_name" id="edit_user_name" />
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Alias:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="display_name" id="edit_display_name" />
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Email:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="user_email" id="edit_user_email" />
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Avatar:</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" name="user_avatar" id="edit_user_avatar" accept="image/png, image/jpeg"></input>
                </div>
            </div>
            <div class="modal-footer">
				<input type="text" class="user_id" name="user_id" hidden />
                <button type="submit" class="btn btn-success edit">
                    <span class='glyphicon glyphicon-check'></span> Save
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Close
                </button>
            </div>
        </form>
    </div>
</div>

<div id="previewUserModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title text-center">Preview The User</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">User Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="preview_user_name" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Alias:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="preview_display_name" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Email:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="preview_user_email" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="label_des col-sm-4" for="title">Avatar:</label>
                <div class="col-sm-8">
                    <img id="preview_user_avatar" style="width: 60px;">
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

<div id="deleteUserModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title text-center">Delete The User</h4>
    </div>
    <div class="modal-body">
        <p>Are you sure you want to delete this User?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
		<form class="form-horizontal" role="form" method="post" action="{{ asset('/deleteData') }}">
		@csrf
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

<div id="deleteUsersModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title text-center">Delete Users</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete these Users?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/mutiDeleteData') }}">
        @csrf
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

<div id="confirmModal" class="modal fade" tabindex="-1" data-width="320">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title text-center">Confirm</h4>
    </div>
    <div class="modal-body">					
        <p>Please select users.</p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">
            <span class='glyphicon glyphicon-remove'></span> Close
        </button>
    </div>
</div>
@endsection