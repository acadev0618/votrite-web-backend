<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class RaceController extends Controller {
    
    public function index(Request $request) {
        if(Session::get('display_name')) {
            $BallotController = new BallotController;
            $LanguageController = new LanguageController;
            $CountyController = new CountyController;
            
            $ballots = $BallotController->getActiveBallot();
            if(empty($ballots->data)) {
                $languages = trim(' ');
                $counties = trim(' ');
                $races = trim(' ');
            } else {
                $old_race_ballot_id = session::get('old_race_ballot_id');
                $ballot_id = $request->old('ballot_id')==null?$ballots->data[0]->ballot_id:$request->old('ballot_id');
                if(($old_race_ballot_id != null) && ($old_race_ballot_id != $ballot_id)) {
                    $ballot_id = $old_race_ballot_id;
                }
                $languages = $LanguageController->getLangOfBallot($ballot_id);
                $counties = $CountyController->getCountyOfBallot($ballot_id);
                $races = $this->getRaceOfBallot($ballot_id);
            }

            return view('race')->with(
                [
                    'ballots' => $ballots, 
                    'races' => $races,
                    'languages' => $languages,
                    'counties' => $counties,
                    'sliderAction' => 'manage',
                    'subAction' => 'race',
                ]
            );
        } else {
            return redirect('admin/');
        }
    }
    
    public function getOneRace(Request $request) {
        $race_id = $request->race_id;
        $Api = new ApiController;
        $api_url = env('API').'/race';
        $param = 'race_id='.$race_id;

        $race = $Api->getParamApi($api_url, $param);
        $race = json_encode($race);

        return $race;
    }

    public function getChangedRaces(Request $request) {
        $BallotController = new BallotController;
        $LanguageController = new LanguageController;
        $CountyController = new CountyController;

        session(['old_race_ballot_id' => $request->ballot_id]);

        $ballots = $BallotController->getActiveBallot();
        if(empty($ballots->data)) {
            $languages = trim(' ');
            $counties = trim(' ');
            $races = trim(' ');
        } else {
            $ballot_id = $request->ballot_id;
            $languages = $LanguageController->getLangOfBallot($ballot_id);
            $counties = $CountyController->getCountyOfBallot($ballot_id);
            $races = $this->getRaceOfBallot($ballot_id);
        }
        
        return view('raceTable')->with([
            'ballots' => $ballots,
            'languages' => $languages,
            'counties' => $counties,
            'races' => $races
        ]);
    }

    public function getRaceOfBallot($ballot_id) {
        $Api = new ApiController;
        $api_url = env('API').'/race';
        $param = 'ballot_id='.$ballot_id;

        $response = $Api->getParamApi($api_url, $param);
        return $response;
    }

    public function getAllRace() {
        $Api = new ApiController;

        $api_url = env('API').'/race';

        $response = $Api->getApi($api_url);
        return $response;
    }

    public function createRace(Request $request) {
        if(($request->race_lang_id == 0) || ($request->race_location_id == 0)) {
            $data = array(
                "ballot_id" => $request->ballot_id,
                "race_title" => $request->race_title,
                "race_voted_position" => $request->race_voted_position,
                "race_name" => $request->race_name,
                "min_num_of_votes" => $request->min_num_of_vote,
                "max_num_of_votes" => $request->max_num_of_vote,
                "max_num_of_write_ins" => $request->max_num_of_write_ins,
                "race_type" => $request->race_type
            );
        } else {
            $data = array(
                "ballot_id" => $request->ballot_id,
                "race_title" => $request->race_title,
                "race_voted_position" => $request->race_voted_position,
                "race_name" => $request->race_name,
                "min_num_of_votes" => $request->min_num_of_vote,
                "max_num_of_votes" => $request->max_num_of_vote,
                "max_num_of_write_ins" => $request->max_num_of_write_ins,
                "race_type" => $request->race_type,
                "race_lang_id" => $request->race_lang_id,
                "race_location_id" => $request->race_location_id
            );
        }

        $data = json_encode($data);
        $api = env('API').'/race/create';

        $BaseController = new BaseController;
                
        return $BaseController->createData($data, $api);
    }

    public function updateRace(Request $request) {
        $race_id = array('race_id' => $request->race_id);
        if(($request->race_lang_id == 0) || ($request->race_location_id == 0)) {
            $data = array(
                "ballot_id" => $request->ballot_id,
                'race_title' => $request->race_title,
                'race_voted_position' => $request->race_voted_position,
                'race_name' => $request->race_name,
                'min_num_of_votes' => $request->min_num_of_votes,
                'max_num_of_votes' => $request->max_num_of_votes,
                'max_num_of_write_ins' => $request->max_num_of_write_ins,
                'race_type' => $request->race_type,
                'keys' => $race_id
            );
        } else {
            $data = array(
                "ballot_id" => $request->ballot_id,
                'race_title' => $request->race_title,
                'race_voted_position' => $request->race_voted_position,
                'race_name' => $request->race_name,
                'min_num_of_votes' => $request->min_num_of_votes,
                'max_num_of_votes' => $request->max_num_of_votes,
                'max_num_of_write_ins' => $request->max_num_of_write_ins,
                'race_type' => $request->race_type,
                'race_lang_id' => $request->race_lang_id,
                'race_location_id' => $request->race_location_id,
                'keys' => $race_id
            );
        }

        $data = json_encode($data);
        $api = env('API').'/race/update';

        $BaseController = new BaseController;
        return $BaseController->updateData($data, $api);
    }
}
