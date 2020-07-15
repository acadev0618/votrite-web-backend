<table class="table table-striped table-bordered table-hover" id="race_table">
    <thead>
        <tr>
            <th class="table-checkbox">
                <input type="checkbox" class="group-checkable" data-set="#race_table .checkboxes"/>
            </th>
            <th class="table-no">
                No
            </th>
            <th>
                International Race Name
            </th>
            <th>
                Race Title
            </th>
            <th>
                Voted Position
            </th>
            <th>
                Race Type
            </th>
            <th style="width: 6%;">
                Actions
            </th>
        </tr>
    </thead>
    <tbody id="race_tbody">
        @if(empty($ballots->data))
        @else
            @if(empty($races->data))
            @else
                @foreach($races->data as $race)
                <tr class="odd gradeX">
                    <td>
                        <input type="checkbox" class="checkboxes" value="{{ $race->race_id }}" data-id="{{ $race->race_id }}"/>
                    </td>
                    <td>
                        {{ $loop->index+1 }}
                    </td>
                    <td>
                        {{ $race->race_name }}
                    </td>
                    <td>
                        {{ $race->race_title }}
                    </td>
                    <td>
                        {{ $race->race_voted_position }}
                    </td>
                    <td>
                        @if($race->race_type == "P")
                            Primary
                        @endif
                        @if($race->race_type == "R")
                            Ranking
                        @endif
                        @if($race->race_type == "S")
                            Standard
                        @endif
                    </td>
                    <td>
                        <a class="preview previewRaceModal" data-toggle="modal" data-id="{{ $race->race_id }}" data-ballotId="{{ $race->ballot_id }}" data-raceName="{{ $race->race_name }}" data-maxNum="{{ $race->max_num_of_votes }}" data-minNum="{{ $race->min_num_of_votes }}" data-lang="{{ $race->race_lang_id }}" data-county="{{ $race->race_location_id }}" data-raceTitle="{{ $race->race_title }}" data-votedPosition="{{ $race->race_voted_position }}"><i class="fa fa-eye" data-toggle="tooltip" title="Preview"></i></a>
                        <a class="editRaceModal" data-toggle="modal" data-id="{{ $race->race_id }}"><i class="fa fa-edit" data-toggle="tooltip" title="Edit"></i></a>
                        <a class="deleteRaceModal" data-toggle="modal" data-id="{{ $race->race_id }}"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete"></i></a>
                    </td>
                </tr>
                @endforeach
            @endif
        @endif
    </tbody>
</table>

    <div id="addRaceModal" class="modal fade" tabindex="-1" data-width="620">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title text-center">Add The Race</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" role="form" method="post" action="{{ asset('/createRace') }}">
            @csrf
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">International Race Name:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="add_race_name" name="race_name" required placeholder="Example: BOD">
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Race Type:</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="race_type" id="add_race_type">
                            <option value="P">Primary</option>
                            <option value="R">Ranking</option>
                            <option value="S">Standard</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Minimum number of vote:</label>
                    <div class="col-sm-7">
                        <select class="form-control min_cand" name="min_num_of_vote" id="add_min_num_of_vote">
                            <option value="0">0</opiton>
                            <option value="1">1</opiton>
                            <option value="2">2</opiton>
                            <option value="3">3</opiton>
                            <option value="4">4</opiton>
                            <option value="5">5</opiton>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Maximum number of vote:</label>
                    <div class="col-sm-7">
                        <select class="form-control max_cand" name="max_num_of_vote" id="add_max_num_of_vote">
                            <option value="0">0</opiton>
                            <option value="1">1</opiton>
                            <option value="2">2</opiton>
                            <option value="3">3</opiton>
                            <option value="4">4</opiton>
                            <option value="5">5</opiton>
                            <option value="6">6</opiton>
                            <option value="7">7</opiton>
                            <option value="8">8</opiton>
                            <option value="9">9</opiton>
                            <option value="10">10</opiton>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Maximum number of Write-Ins:</label>
                    <div class="col-sm-7">
                        <select class="form-control max_w_cand" name="max_num_of_write_ins" id="add_max_num_of_write_ins">
                            <option value="0">0</opiton>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Choose Language:</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="race_lang_id" id="add_race_lang_id">
                            @if(empty($languages->data))
                            <option value="0">No Language</option>
                            @else
                                @foreach($languages->data as $lang)
                                <option value="{{ $lang->lang_id }}">{{ $lang->language_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Choose County:</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="race_location_id" id="add_race_location_id">
                        @if(empty($counties->data))
                        <option value="0">No Counties</option>
                        @else
                            @foreach($counties->data as $county)
                            <option value="{{ $county->county_id }}">{{ $county->county_name }}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Race title:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="add_race_title" name="race_title" required placeholder="Example: Election of Board of Directors">
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Voted Position:</label>
                    <div class="col-sm-7">
                        <textarea type="text" class="form-control" id="add_race_voted_position" name="race_voted_position" required placeholder="Candidates for: Director"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="text" id="ballot_id" name="ballot_id" hidden />
                    <button type="submit" class="btn btn-success add">
                        <span id="" class='glyphicon glyphicon-check'></span> Add
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="previewRaceModal" class="modal fade" tabindex="-1" data-width="620">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title text-center">Preview The Race</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">International Race Name:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="race_name" name="race_name" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Race Type:</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="race_type" id="race_type" readonly>
                            <option disabled value="P">Primary</option>
                            <option disabled value="R">Ranking</option>
                            <option disabled value="S">Standard</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Minimum number of vote:</label>
                    <div class="col-sm-7">
                        <select class="form-control min_cand" name="min_num_of_votes" id="min_num_of_votes" readonly>
                            <option disabled value="0">0</opiton>
                            <option disabled value="1">1</opiton>
                            <option disabled value="2">2</opiton>
                            <option disabled value="3">3</opiton>
                            <option disabled value="4">4</opiton>
                            <option disabled value="5">5</opiton>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Maximum number of vote:</label>
                    <div class="col-sm-7">
                        <select class="form-control max_cand" name="max_num_of_votes" id="max_num_of_votes" readonly>
                            <option disabled value="0">0</opiton>
                            <option disabled value="1">1</opiton>
                            <option disabled value="2">2</opiton>
                            <option disabled value="3">3</opiton>
                            <option disabled value="4">4</opiton>
                            <option disabled value="5">5</opiton>
                            <option disabled value="6">6</opiton>
                            <option disabled value="7">7</opiton>
                            <option disabled value="8">8</opiton>
                            <option disabled value="9">9</opiton>
                            <option disabled value="10">10</opiton>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Maximum number of Write-Ins:</label>
                    <div class="col-sm-7">
                        <select class="form-control max_w_cand" name="max_num_of_write_ins" id="max_num_of_write_ins" readonly>
                            <option disabled value="0">0</opiton>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Language:</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="race_lang_id" id="race_lang_id" readonly>
                            @if(empty($languages->data))
                            <option value="0">No Language</option>
                            @else
                                @foreach($languages->data as $lang)
                                <option disabled value="{{ $lang->lang_id }}">{{ $lang->language_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">County:</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="race_location_id" id="race_location_id" readonly>
                        @if(empty($counties->data))
                        <option value="0">No Counties</option>
                        @else
                            @foreach($counties->data as $county)
                            <option disabled value="{{ $county->county_id }}">{{ $county->county_name }}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Race title:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="race_title" name="race_title" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Voted Position:</label>
                    <div class="col-sm-7">
                        <textarea type="text" class="form-control" id="race_voted_position" name="race_voted_position" readonly></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="editRaceModal" class="modal fade" tabindex="-1" data-width="620">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title text-center">Edit The Race</h4>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" role="form" method="post" action="{{ asset('/updateRace') }}">
            @csrf
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">International Race Name:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="edit_race_name" name="race_name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Race Type:</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="race_type" id="edit_race_type">
                            <option value="P">Primary</option>
                            <option value="R">Ranking</option>
                            <option value="S">Standard</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Minimum number of vote:</label>
                    <div class="col-sm-7">
                        <select class="form-control min_cand" name="min_num_of_votes" id="edit_min_num_of_votes">
                            <option value="0">0</opiton>
                            <option value="1">1</opiton>
                            <option value="2">2</opiton>
                            <option value="3">3</opiton>
                            <option value="4">4</opiton>
                            <option value="5">5</opiton>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Maximum number of vote:</label>
                    <div class="col-sm-7">
                        <select class="form-control max_cand" name="max_num_of_votes" id="edit_max_num_of_votes">
                            <option value="0">0</opiton>
                            <option value="1">1</opiton>
                            <option value="2">2</opiton>
                            <option value="3">3</opiton>
                            <option value="4">4</opiton>
                            <option value="5">5</opiton>
                            <option value="6">6</opiton>
                            <option value="7">7</opiton>
                            <option value="8">8</opiton>
                            <option value="9">9</opiton>
                            <option value="10">10</opiton>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Maximum number of Write-Ins:</label>
                    <div class="col-sm-7">
                        <select class="form-control max_w_cand" name="max_num_of_write_ins" id="edit_max_num_of_write_ins">
                            <option value="0">0</opiton>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Choose Language:</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="race_lang_id" id="edit_race_lang_id">
                            @if(empty($languages->data))
                            <option value="0">No Language</option>
                            @else
                                @foreach($languages->data as $lang)
                                <option value="{{ $lang->lang_id }}">{{ $lang->language_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Choose County:</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="race_location_id" id="edit_race_location_id">
                        @if(empty($counties->data))
                        <option value="0">No Counties</option>
                        @else
                            @foreach($counties->data as $county)
                            <option value="{{ $county->county_id }}">{{ $county->county_name }}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Race title:</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="edit_race_title" name="race_title">
                    </div>
                </div>
                <div class="form-group">
                    <label class="label_des col-sm-5" for="title">Voted Position:</label>
                    <div class="col-sm-7">
                        <textarea type="text" class="form-control" id="edit_race_voted_position" name="race_voted_position"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="text" id="ballot_id" name="ballot_id" hidden />
                    <input type="text" id="edit_race_id" name="race_id" hidden>
                    <button type="submit" class="btn btn-success addInvoice">
                        <span id="" class='glyphicon glyphicon-check'></span> Save
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </form>
        </div>
    </div>

<div id="deleteRacesModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title text-center">Delete Races</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete these Races?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/mutiDeleteData') }}">
        @csrf     
            <input type="text" id="ballot_id" name="ballot_id" hidden />       
            <input type="text" class="ids" name="ids" hidden />
            <input type="text" class="target_id" name="target_id" hidden />
            <input type="text" class="api" name="api" hidden />

            <button type="submit" class="btn btn-danger delete">
                <i class="fa fa-trash-o"></i> Delete
            </button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">
                <span class='glyphicon glyphicon-remove'></span> Close
            </button>
        </form>
    </div>
</div>

<div id="deleteRaceModal" class="modal fade" tabindex="-1" data-width="420">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title text-center">Delete The Race</h4>
    </div>
    <div class="modal-body">					
        <p>Are you sure you want to delete this Race?</p>
        <p class="text-warning"><small>This action cannot be undone.</small></p>
    </div>
    <div class="modal-footer">
        <form class="form-horizontal" role="form" method="post" action="{{ asset('/deleteData') }}">
        @csrf
            <input type="text" id="ballot_id" name="ballot_id" hidden />      
            <input type="text" class="target_id" name="target_id" hidden />
            <input type="text" class="id" name="id" hidden />
            <input type="text" class="api" name="api" hidden />
            
            <button type="submit" class="btn btn-danger delete">
                <i class="fa fa-trash-o"></i> Delete
            </button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">
                <span class='glyphicon glyphicon-remove'></span> Close
            </button>
        </form>
    </div>
</div>