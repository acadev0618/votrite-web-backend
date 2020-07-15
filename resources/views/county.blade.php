@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Counties
		</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							Choose counties
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-6 select_options">
									<div class="col-md-4 form-group">
										<label class="col-sm-2 label_des select_name">Ballot:</label>
										<div class="col-sm-10">
											<select class="form-control" name="county_ballot_option" id="county_ballot_option">
											@if(empty($ballots->data))
											@else
												@foreach($ballots->data as $ballot)
													@if($ballot->ballot_id == session::get('old_county_ballot_id'))
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
									<div class="col-md-6 form-group">
										<label class="col-sm-2 label_des select_name">State:</label>
										<div class="col-sm-5">
											<select class="form-control" name="county_state_option" id="county_state_option">
											@if(empty($states->data))
											@else
												@foreach($states->data as $state)
													@if($state->state_id == session::get('old_county_state_id'))
													<option value="{{ $state->state_id }}" selected>{{ $state->state_code }}</opiton>
													@else	
													<option value="{{ $state->state_id }}">{{ $state->state_code }}</opiton>
													@endif
												@endforeach
											@endif
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="col-sm-12 btn-group ballot-actions">
										<div class="col-sm-8"></div>
										<div class="col-sm-2" style="margin-top: 8px;">
											<input type="checkbox" class="form-control select_all_ballot_county" id="select_all_ballot_county" data-set="#county_list .county_check">
											<label class="form-label">Select all</label>
										</div>
										<div class="col-sm-2">
											<button type="submit" id="save_all_ballot_county" class="btn btn-success save_all_ballot_county disabled"><span id="" class='glyphicon glyphicon-check'></span> Save all</button>
											<button type="submit" id="save_all_ballot_county" class="btn btn-success save_all_ballot_county_ disabled" style="display:none;"><span id="" class='glyphicon glyphicon-check'></span> Save all</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="change_table">
							<div class="row" id="county_list" style="margin-top: 40px;">
							@if(empty($ballots->data) || empty($states->data))
								<h4 class="text-center">There aren't any ballots or states.</h4>
							@else
								@if(empty($counties->data))
									<h4 class="text-center">There aren't any counties.</h4>
								@else
									@if(empty($ballot_counties->data))
										@foreach($counties->data as $county)
											<div class="col-sm-2 change_aval_county" data-id="{{ $county->county_id }}" style="margin-bottom: 10px;">
												<input type="checkbox" class="form-control county_check" name="county_check" data-id="{{ $county->county_id }}">
												<label class="form-label" id="county_name" name="county_name" data-id="{{ $county->county_id }}">{{ $county->county_name }}</label>
											</div>
										@endforeach
									@else
										@foreach($counties->data as $county)
										<?php $flag = 0;?>
											@foreach($ballot_counties->data as $ballot_county)
												@if($county->county_id == $ballot_county->county_id)
												<?php $flag = 1;?>														
												@endif
											@endforeach
											<?php if($flag == 1) { ?>
												<div class="col-sm-2 change_aval_county" data-id="{{ $county->county_id }}" style="margin-bottom: 10px;">
													<input type="checkbox" checked="checked" class="form-control county_check" name="county_check" data-id="{{ $county->county_id }}">
													<label class="form-label" id="county_name" name="county_name" data-id="{{ $county->county_id }}">{{ $county->county_name }}</label>
												</div>
											<?php }  else { ?>
												<div class="col-sm-2 change_aval_county" data-id="{{ $county->county_id }}" style="margin-bottom: 10px;">
													<input type="checkbox" class="form-control county_check" name="county_check" data-id="{{ $county->county_id }}">
													<label class="form-label" id="county_name" name="county_name" data-id="{{ $county->county_id }}">{{ $county->county_name }}</label>
												</div>
											<?php } ?>
										@endforeach
									@endif
								@endif
							@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection