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
                                                    <option value="-1">No Ballot</opiton>
                                                    @else
                                                        @foreach($ballots->data as $ballot)
                                                        <option value="{{ $ballot->ballot_id }}">{{ $ballot->election }}</opiton>
                                                        @endforeach
                                                    @endif
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div id="change_table">
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
                                                    <input type="checkbox" class="form-control" id="aval_ballot_lang" name="aval_ballot_lang" data-id="{{ $language->language_id }}">
                                                @else
                                                    @foreach($ballot_languages->data as $ballot_language)
                                                        @if($ballot_language->lang_id == $language->language_id)
                                                            <input type="checkbox" checked="checked" class="form-control" id="aval_ballot_lang" name="aval_ballot_lang" data-id="{{ $language->language_id }}">
                                                            @break
                                                        @else
                                                            <input type="checkbox" class="form-control" id="aval_ballot_lang" name="aval_ballot_lang" data-id="{{ $language->language_id }}">
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
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
@endsection