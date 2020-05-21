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
		@foreach($langs->data as $lang)
		<tr class="odd gradeX">
			<td>
				{{$loop->index+1}}
			</td>
			<td>
				{{ $lang->language_code }}
			</td>
			<td>
				{{ $lang->language_name }}
			</td>
			<td class="text-center">
			@if(empty($ballot_langs->data))
				<input type="checkbox" style="width: 20px; height: 17px;" id="aval_ballot_lang" name="aval_ballot_lang" data-id="{{ $lang->language_id }}">
			@else
				@foreach($ballot_langs->data as $ballot_lang)
					@if($ballot_lang->ballot_lang_id == $lang->language_id)
						<input type="checkbox" checked="checked" style="width: 20px; height: 17px;" id="aval_ballot_lang" name="aval_ballot_lang" data-id="{{ $lang->language_id }}">
					@else
						<input type="checkbox" style="width: 20px; height: 17px;" id="aval_ballot_lang" name="aval_ballot_lang" data-id="{{ $lang->language_id }}">
					@endif
				@endforeach
			@endif
			</td>
		</tr>
		@endforeach
	@endif
	</tbody>
</table>