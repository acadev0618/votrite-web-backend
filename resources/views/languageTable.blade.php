<table class="table table-striped table-bordered table-hover" id="language_table">
	<thead>
		<tr>
			<th class="table-no">
				No
			</th>
			<th>
				Language Code
			</th>
			<th>
				Language Name
			</th>
			<th style="width: 6%;">
				Avaliable
			</th>
		</tr>
	</thead>
	<tbody>
	@if(empty($ballots->data))
	@else
		@if(empty($languages->data))
		@else
			@foreach($languages->data as $language)
			<tr class="odd gradeX">
				<td>
					{{$loop->index+1}}
				</td>
				<td>
					{{ $language->language_code }}
				</td>
				<td>
					{{ $language->language_name }}
				</td>
				<td class="text-center">
					@if(empty($ballot_languages->data))
						<input type="checkbox" class="form-control changed_sel" id="aval_ballot_lang" name="aval_ballot_lang" data-id="{{ $language->language_id }}" style="margin-left: 30px;">
					@else
						<input type="checkbox" checked="checked" class="form-control changed_sel" id="aval_ballot_lang" name="aval_ballot_lang" data-id="{{ $language->language_id }}" style="margin-left: 30px;">
					@endif
				</td>
			</tr>
			@endforeach
		@endif
	@endif
	</tbody>
</table>