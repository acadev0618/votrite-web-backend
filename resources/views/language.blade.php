@extends('layouts.app')

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<h3 class="page-title">
		Languages
		</h3>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
                        Language Table
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
                            <div class="row">
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-5 form-group">
											<label class="col-sm-2 control-label select_name">Ballot:</label>
											<div class="col-sm-10">
												<select class="form-control select_ballot" name="ballot_lang_option" id="ballot_lang_option">
                                                    @if(empty($ballots->data))
                                                    @else
                                                        @foreach($ballots->data as $ballot)
															@if($ballot->ballot_id == session::get('old_lang_ballot_id'))
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
									</div>
								</div>
								<div class="col-md-6">
									<div class="col-sm-12 btn-group ballot-actions">
										<div class="col-sm-8"></div>
										<div class="col-sm-2" style="margin-top: 8px;">
											<input type="checkbox" class="form-control select_all_ballot_lang" id="select_all_ballot_lang" data-set="#lang_list .lang_check">
											<label class="form-label">Select all</label>
										</div>
										<div class="col-sm-2">
											<button type="submit" id="save_all_ballot_lang" class="btn btn-success save_all_ballot_lang disabled"><span id="" class='glyphicon glyphicon-check'></span> Save all</button>
											<button type="submit" id="save_all_ballot_lang" class="btn btn-success save_all_ballot_lang_ disabled" style="display:none;"><span id="" class='glyphicon glyphicon-check'></span> Save all</button>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div id="change_table">
                            <div class="row" id="lang_list" style="margin-top: 40px;">
							@if(empty($ballots->data))
                                <h4 class="text-center">There aren't any ballots.</h4>
                            @else
                                @if(empty($languages->data))
                                    <h4 class="text-center">There aren't any languages.</h4>
                                @else
                                    @if(empty($ballot_languages->data))
                                        @foreach($languages->data as $language)
                                            <div class="col-sm-2 change_aval_lang" data-id="{{ $language->language_id }}" style="margin-bottom: 10px;">
                                                <input type="checkbox" class="form-control lang_check" name="lang_check" data-id="{{ $language->language_id }}">
                                                <label class="form-label" data-id="{{ $language->language_id }}">{{ $language->language_name }}</label>
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
                                                <div class="col-sm-2 change_aval_lang" data-id="{{ $language->language_id }}" style="margin-bottom: 10px;">
                                                    <input type="checkbox" checked="checked" class="form-control lang_check" name="lang_check" data-id="{{ $language->language_id }}">
                                                    <label class="form-label" data-id="{{ $language->language_id }}">{{ $language->language_name }}</label>
                                                </div>
                                            <?php }  else { ?>
                                                <div class="col-sm-2 change_aval_lang" data-id="{{ $language->language_id }}" style="margin-bottom: 10px;">
                                                    <input type="checkbox" class="form-control lang_check" name="lang_check" data-id="{{ $language->language_id }}">
                                                    <label class="form-label" data-id="{{ $language->language_id }}">{{ $language->language_name }}</label>
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