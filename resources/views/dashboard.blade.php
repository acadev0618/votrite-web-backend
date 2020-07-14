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
                                        {{ $loop->index+1 }}
                                        </td>
                                        <td>
                                        {{ $ballot->election }}
                                        </td>
                                        <td>
                                            <?php
                                                $start_date = $ballot->start_date;
                                                
                                                $date = substr($start_date, 0, 10);
                                                $date = strtotime($date);
                                                $date = date('d F, Y', $date);  

                                                $time = substr($start_date, 11, 8);
                                                $time = strtotime($time);
                                                $time = date('h:i:s A', $time);  

                                                $start = $date." ".$time;
                                            ?>
                                        {{ $start }}
                                        </td>
                                        <td>
                                            <?php
                                                $end_date = $ballot->end_date;
                                                
                                                $date = substr($end_date, 0, 10);
                                                $date = strtotime($date);
                                                $date = date('F d, Y', $date);  

                                                $time = substr($end_date, 11, 8);
                                                $time = strtotime($time);
                                                $time = date('h:i A', $time);  

                                                $end = $date." ".$time;
                                            ?>
                                        {{ $end }}
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
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Client:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="client" placeholder="Example: Luna Park Housing Corporation" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Election:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="election" placeholder="Example: Election of Board of Directiors" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Address:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="address" placeholder="Example: Boorklyn, New York" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Board:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="board" placeholder="Example: Honest Ballot Association" required>
                </div>
            </div>
            <div class="for-group">
                <p class="mini-title">Times</p>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Start Date:</label>
                <div class="col-sm-9">
                    <input type="datetime-local" class="form-control" name="start_date" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">End Date:</label>
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

<div id="addLanguageModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add Language</h4>
    </div>
    <div class="modal-body langModalBody">
        <form class="form-horizontal">
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Language code:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="lang_code" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Language name:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="lang_name" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Language button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="lang_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Skip button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="skip_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Next button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="next_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">back_button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="back_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Reset ballot button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="reset_ballot_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">"of":</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="of" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Review button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="review_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Contest tip:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="contest_tip" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Proposition tip:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="proposition_tip" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Choice Part 1:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="choice_part_1" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Choice Part 2 - single:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="choice_part_2_single" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Choice Part 2 - plural:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="choice_part_2_plural" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Back to vote button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="back_vot_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Print button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="print_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Cast button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="cast_button" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Done:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="done" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Thank you:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="thanks" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Review title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="review_title" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Review tip:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="review_tip" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">No selection:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="no_selection" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-1"></div>
                <label class="label_des col-sm-2" for="title">Voter:</label>
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
