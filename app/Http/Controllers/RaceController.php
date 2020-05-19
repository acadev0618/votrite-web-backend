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
            $languages = $LanguageController->getLangOfBallot(1);
            $countries = $CountryController->getCountryOfBallot(1);
            $races = $this->getRaceOfBallot(1);

            return view('race')->with(
                [
                    'ballots' => $ballots->data, 
                    'races' => $races->data,
                    'languages' => $languages->data,
                    'countries' => $countries->data,
                    'sliderAction' => 'manage',
                    'subAction' => 'race',
                ]
            );
        } else {
            return redirect('/');
        }
    }

    // public function getRaceData(Request $request) {
    //     $race_id = $request->race_id;
    //     $LanguageController = new LanguageController;
    //     $CountryController = new CountryController;

    //     $race = $this->getOneRace($race_id);
    //     $ballot_id = json_decode($race)->data[0]->ballot_id;
    //     $ballot_languages = $LanguageController->getLangOfBallot($ballot_id);
    //     $ballot_countries = $CountryController->getCountryOfBallot($ballot_id);
        
    //     $response = array(
    //         'race' => $race,
    //         'languages' => $ballot_languages,
    //         'countries' => $ballot_countries
    //     );
    //     $response = json_encode($response);
        
    //     return $response;
    // }

    public function getOneRace(Request $request) {
        $race_id = $request->race_id;
        $Api = new ApiController;
        $api_url = env('api').'/race';
        $param = 'race_id='.$race_id;

        $race = $Api->getParamApi($api_url, $param);
        $race = json_encode($race);

        return $race;
    }

    public function getRaceOfBallot($ballot_id) {
        $Api = new ApiController;
        $api_url = env('api').'/race';
        $param = 'ballot_id='.$ballot_id;

        $response = $Api->getParamApi($api_url, $param);
        return $response;
    }

    public function getAllRace() {
        $Api = new ApiController;

        $api_url = env('api').'/race';

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
        $api = env('api').'/race/create';

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
        $api = env('api').'/race/update';

        $BaseController = new BaseController;
        return $BaseController->updateData($data, $api);
    }
}
