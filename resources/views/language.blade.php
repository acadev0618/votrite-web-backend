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
								<div class="col-md-6 col-md-offset-6">
									<div class="btn-group ballot-actions">
										<button href="#addLanguageModal" class="btn btn-primary" data-toggle="modal"><i class="fa fa-plus-circle"></i> <span>  Add Language</span></button>
										<button href="#deleteLanguagesModal" class="btn btn-danger" data-toggle="modal" style="margin-left: 10px;"><i class="fa fa-minus-circle"></i> <span>  Delete Languages</span></button>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover" id="language_table">
							<thead>
								<tr>
									<th class="table-checkbox">
										<input type="checkbox" class="group-checkable" data-set="#language_table .checkboxes"/>
									</th>
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
										Actions
									</th>
								</tr>
							</thead>
							<tbody>
								<tr class="odd gradeX">
									<td>
										<input type="checkbox" class="checkboxes" value="1"/>
									</td>
									<td>
										1
									</td>
									<td>
										en-US
									</td>
									<td>
										English
									</td>
									<td>
										<a href="#previewLanguageModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editLanguageModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deleteLanguageModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
									</td>
								</tr>
								<tr class="odd gradeX">
									<td>
										<input type="checkbox" class="checkboxes" value="1"/>
									</td>
									<td>
										2
									</td>
									<td>
										en-US
									</td>
									<td>
										English
									</td>
									<td>
										<a href="#previewLanguageModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editLanguageModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deleteLanguageModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
									</td>
								</tr>
								<tr class="odd gradeX">
									<td>
										<input type="checkbox" class="checkboxes" value="1"/>
									</td>
									<td>
										3
									</td>
									<td>
										en-US
									</td>
									<td>
										English
									</td>
									<td>
										<a href="#previewLanguageModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editLanguageModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deleteLanguageModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
									</td>
								</tr>
								<tr class="odd gradeX">
									<td>
										<input type="checkbox" class="checkboxes" value="1"/>
									</td>
									<td>
										4
									</td>
									<td>
										en-US
									</td>
									<td>
										English
									</td>
									<td>
										<a href="#previewLanguageModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editLanguageModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deleteLanguageModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
									</td>
								</tr>
								<tr class="odd gradeX">
									<td>
										<input type="checkbox" class="checkboxes" value="1"/>
									</td>
									<td>
										5
									</td>
									<td>
										en-US
									</td>
									<td>
										English
									</td>
									<td>
										<a href="#previewLanguageModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editLanguageModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deleteLanguageModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
									</td>
								</tr>
								<tr class="odd gradeX">
									<td>
										<input type="checkbox" class="checkboxes" value="1"/>
									</td>
									<td>
										6
									</td>
									<td>
										en-US
									</td>
									<td>
										English
									</td>
									<td>
										<a href="#previewLanguageModal" class="preview" data-toggle="modal"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
										<a href="#editLanguageModal" class="edit" data-toggle="modal"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
										<a href="#deleteLanguageModal" class="delete" data-toggle="modal"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
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

<div id="editLanguageModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edit The Language</h4>
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

<div id="previewLanguageModal" class="modal fade" tabindex="-1" data-width="620">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Preview The Language</h4>
    </div>
    <div class="modal-body langModalBody">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Language code:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="lang_code" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Language name:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="lang_name" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Language button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="lang_button" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Skip button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="skip_button" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Next button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="next_button" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">back_button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="back_button" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Reset ballot button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="reset_ballot_button" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">"of":</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="of" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Review button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="review_button" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Contest tip:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="contest_tip" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Proposition tip:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="proposition_tip" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Choice Part 1:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="choice_part_1" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Choice Part 2 - single:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="choice_part_2_single" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Choice Part 2 - plural:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="choice_part_2_plural" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Back to vote button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="back_vot_button" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Print button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="print_button" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Cast button:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="cast_button" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Done:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="done" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Thank you:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="thanks" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Review title:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="review_title" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Review tip:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="review_tip" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">No selection:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="no_selection" readonly autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5" for="title">Voter:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="voter" readonly autofocus>
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

<div id="deleteLanguagesModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete Languages</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete these Languages?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-danger" value="Delete">
    </div>
</div>

<div id="deleteLanguageModal" class="modal fade" tabindex="-1" data-width="520">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Delete The Language</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete this Language?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
        <input type="submit" class="btn btn-danger" value="Delete">
    </div>
</div>
@endsection