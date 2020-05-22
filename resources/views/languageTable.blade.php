<div class="row" id="lang_list" style="margin-top: 35px;">
	@if(empty($ballots->data))
		<h4 class="text-center">There aren't any ballots.</h4>
	@else
		@if(empty($languages->data))
			<h4 class="text-center">There aren't any languages.</h4>
		@else
			@if(empty($ballot_languages->data))
				@foreach($languages->data as $language)
					<div class="col-sm-2 change_aval_county" data-id="{{ $language->language_id }}" style="margin-bottom: 5px;">
						<input type="checkbox" class="changed_lang lang_check" data-id="{{ $language->language_id }}" style="margin-left: 6px;">
						<label style="margin-left: 2px;" data-id="{{ $language->language_id }}">{{ $language->language_name }}</label>
					</div>
				@endforeach
			@else
				@foreach($languages->data as $language)
				<?php $flag = 0;?>
					@foreach($ballot_languages->data as $ballot_language)
						@if($language->language_id == $ballot_language->lang_id)
						<?php $flag = 1;?>														
						@endif
					@endforeach
					<?php if($flag == 1) { ?>
						<div class="col-sm-2 change_aval_county" data-id="{{ $language->language_id }}" style="margin-bottom: 5px;">
							<input type="checkbox" checked="checked" class="changed_lang lang_check" data-id="{{ $language->language_id }}" style="margin-left: 6px;">
							<label style="margin-left: 2px;" data-id="{{ $language->language_id }}">{{ $language->language_name }}</label>
						</div>
					<?php }  else { ?>
						<div class="col-sm-2 change_aval_county" data-id="{{ $language->language_id }}" style="margin-bottom: 5px;">
							<input type="checkbox" class="changed_lang lang_check" data-id="{{ $language->language_id }}" style="margin-left: 6px;">
							<label style="margin-left: 2px;" data-id="{{ $language->language_id }}">{{ $language->language_name }}</label>
						</div>
					<?php } ?>
				@endforeach
			@endif
		@endif
	@endif
	</div>