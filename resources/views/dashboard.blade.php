@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Active Ballots
		</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							Ballot Table
						</div>
						<div class="actions">
							<button href="#addBallotModal" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus-circle"></i> <span>  Add Ballot</span></button>
							<button href="#addLanguageModal" class="btn btn-warning" data-toggle="modal"><i class="fa fa-plus-circle"></i> <span>  Add Language</span></button>
						</div>
					</div>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover" id="dashboard_table">
							<thead>
								<tr>
									<th class="table-checkbox">
										<input type="checkbox" class="group-checkable" data-set="#dashboard_table .checkboxes"/>
									</th>
									<th class="table-no">
										No
									</th>
									<th>
										Ballot
									</th>
									<th>
										Start Date
									</th>
									<th>
										End Date
									</th>
								</tr>
							</thead>
							<tbody>
                                @if(empty($ballots->data))
                                @else
                                    @foreach($ballots->data as $ballot)
                                    <tr class="odd gradeX">
                                        <td>
                                            <input type="checkbox" class="checkboxes" value="{{ $ballot->ballot_id }}" data-id="{{ $ballot->ballot_id }}"/>
                                        </td>
                                        <td>
                                        {{ $loop->index+1 }}
                                        </td>
                                        <td>
                                        {{ $ballot->election }}
                                        </td>
                                        <td>
                                        {{ $ballot->start_date }}
                                        </td>
                                        <td>
                                        {{ $ballot->end_date }}
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

<div id="addBallotModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add New Ballot</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/createBallot') }}">
        @csrf
            <div class="for-group">
                <p class="mini-title">Primary Details</p>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Client:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="client" placeholder="Example: Luna Park Housing Corporation" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Election:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="election" placeholder="Example: Election of Board of Directiors" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Address:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="address" placeholder="Example: Boorklyn, New York" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Board:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="board" placeholder="Example: Honest Ballot Association" required>
                </div>
            </div>
            <div class="for-group">
                <p class="mini-title">Times</p>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">Start Date:</label>
                <div class="col-sm-9">
                    <input type="datetime-local" class="form-control" name="start_date" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="title">End Date:</label>
                <div class="col-sm-9">
                    <input type="datetime-local" class="form-control" name="end_date" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">
                    <span id="" class='glyphicon glyphicon-check'></span> Add
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class='glyphicon glyphicon-remove'></span> Close
                </button>
            </div>
        </form>
    </div>
</div>

<div id="changepwd" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Change Password</h4>
    </div>
    <div class="modal-body">
        <form action="#">
            <div class="form-group">
                <label class="control-label">Current Password</label>
                <input id='currentpwd' type="password" class="form-control"/>
            </div>
            <div class="form-group">
                <label class="control-label">New Password</label>
                <input id='newpwd' type="password" class="form-control"/>
            </div>
            <div class="form-group">
                <label class="control-label">Re-type New Password</label>
                <input id='rnewpwd' type="password" class="form-control"/>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <a id="changebtn" class="btn green-haze">Change Password </a>
        <a id="reset" class="btn default"> Cancel </a>
    </div>
</div>
<div id="addLanguageModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add Language</h4>
    </div>
    <div class="modal-body langModalBody">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Language code:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="lang_code" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Language name:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="lang_name" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Language button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="lang_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Skip button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="skip_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Next button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="next_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">back_button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="back_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Reset ballot button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="reset_ballot_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">"of":</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="of" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Review button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="review_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Contest tip:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="contest_tip" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Proposition tip:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="proposition_tip" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Choice Part 1:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="choice_part_1" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Choice Part 2 - single:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="choice_part_2_single" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Choice Part 2 - plural:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="choice_part_2_plural" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Back to vote button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="back_vot_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Print button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="print_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Cast button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="cast_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Done:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="done" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Thank you:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="thanks" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Review title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="review_title" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Review tip:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="review_tip" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">No selection:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="no_selection" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Voter:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="voter" autofocus>
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
@endsection
@section('script')
<script>
    $('#changebtn').click(function(){
        const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
        const baseurl = document.head.querySelector("[name~=baseurl][content]").content;
        var userid = $('#userid').val();
        var newpwd = $('#newpwd').val();
        var rnewpwd = $('#rnewpwd').val();
        if(newpwd == rnewpwd && newpwd != ''){

            let order = {
                "user_password": newpwd,
                "keys": {"user_id":parseInt(userid)}
            }
            console.log(order);
            fetch(baseurl+'user/update', {
                mode: 'no-cors',
                method: 'post',
                body: JSON.stringify(order),
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    "X-CSRF-Token": csrfToken
                }
            })
            .then(response => {
                // console.log(response);
                toastr.success("Password Changed");
                window.location.href='/logout';
                return response;
            })
            .then(text => {
                return console.log(text);
            })
            .catch(error => console.error(error));
        }else{
            toastr.warning("Please re-enter password");
        }
        
    });
    $('#reset').click(function(){
        $('#currentpwd').val(null);
        $('#newpwd').val(null);
        $('#rnewpwd').val(null);
    });
</script>
@endsection