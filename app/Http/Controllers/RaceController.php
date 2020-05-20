<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class RaceController extends Controller {
    
    public function index() {
        if(Session::get('display_name')) {
            $BallotController = new BallotController;
            $LanguageController = new LanguageController;
            $CountryController = new CountryController;
            
            $ballots = $BallotController->getActiveBallot();
            if(empty($ballots->data)) {
                $languages = trim(' ');
                $countries = trim(' ');
                $races = trim(' ');
            } else {
                $ballot_id = $ballots->data[0]->ballot_id;
                $languages = $LanguageController->getLangOfBallot($ballot_id);
                $countries = $CountryController->getCountryOfBallot($ballot_id);
                $races = $this->getRaceOfBallot($ballot_id);
            }

            return view('race')->with(
                [
                    'ballots' => $ballots, 
                    'races' => $races,
                    'languages' => $languages,
                    'countries' => $countries,
                    'sliderAction' => 'manage',
                    'subAction' => 'race',
                ]
            );
        } else {
            return redirect('/');
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
        $CountryController = new CountryController;

        $ballots = $BallotController->getActiveBallot();
        if(empty($ballots->data)) {
            $languages = trim(' ');
            $countries = trim(' ');
            $races = trim(' ');
        } else {
            $ballot_id = $request->ballot_id;
            $languages = $LanguageController->getLangOfBallot($ballot_id);
            $countries = $CountryController->getCountryOfBallot($ballot_id);
            $races = $this->getRaceOfBallot($ballot_id);
        }
        
        return view('raceTable')->with([
            'ballots' => $ballots,
            'languages' => $languages,
            'countries' => $countries,
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
        $data = array(
            "ballot_id" => $request->ballot_id,
            "race_title" => $request->race_title,
            "race_voted_position" => $request->race_voted_position,
            "race_name" => $request->race_name,
            "min_num_of_votes" => $request->min_num_of_votes,
            "max_num_of_votes" => $request->max_num_of_votes,
            "max_num_of_write_ins" => $request->max_num_of_write_ins,
            "race_type" => $request->race_type,
            "race_lang_id" => $request->race_lang_id,
            "race_location_id" => $request->race_location_id
        );
        $data = json_encode($data);
        $api = env('API').'/race/create';

        $BaseController = new BaseController;
        return $BaseController->createData($data, $api);
    }

    public function updateRace(Request $request) {
        $race_id = array('race_id' => $request->race_id);
        $data = array(
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
        $data = json_encode($data);
        $api = env('API').'/race/update';

        $BaseController = new BaseController;
        return $BaseController->updateData($data, $api);
    }
}
