<div class="row" id="county_list" style="margin-top: 35px;">
@if(empty($ballots->data) || empty($states->data))
	<h4 class="text-center">There aren't any ballots or states.</h4>
@else
	@if(empty($counties->data))
		<h4 class="text-center">There aren't any counties.</h4>
	@else
		@if(empty($ballot_counties->data))
			@foreach($counties->data as $county)
				<div class="col-sm-2 change_aval_county" data-id="{{ $county->county_id }}" style="margin-bottom: 5px;">
					<input type="checkbox" class="county_check changed_county" style="margin-left: 6px;" name="county_check" data-id="{{ $county->county_id }}">
					<label id="county_name" style="margin-left: 2px;" name="county_name" data-id="{{ $county->county_id }}">{{ $county->county_name }}</label>
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
					<div class="col-sm-2 change_aval_county" data-id="{{ $county->county_id }}" style="margin-bottom: 5px;">
						<input type="checkbox" checked="checked" class="county_check changed_county" style="margin-left: 6px;" name="county_check" data-id="{{ $county->county_id }}">
						<label id="county_name" style="margin-left: 2px;" name="county_name" data-id="{{ $county->county_id }}">{{ $county->county_name }}</label>
					</div>
				<?php }  else { ?>
					<div class="col-sm-2 change_aval_county" data-id="{{ $county->county_id }}" style="margin-bottom: 5px;">
						<input type="checkbox" class="county_check changed_county" style="margin-left: 6px;" name="county_check" data-id="{{ $county->county_id }}">
						<label id="county_name" style="margin-left: 2px;" name="county_name" data-id="{{ $county->county_id }}">{{ $county->county_name }}</label>
					</div>
				<?php } ?>
			@endforeach
		@endif
	@endif
@endif
</div>