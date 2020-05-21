<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class CandidateController extends Controller {
    public function index() {
        if(Session::get('display_name')) {
            $BallotController = new BallotController;
            $RaceController = new RaceController;
            $PartyController = new PartyController;
            $LanguageController = new LanguageController;

            $ballots = $BallotController->getActiveBallot();
            if(empty($ballots->data)) {
                $races = trim(' ');
                $parties = trim(' ');
                $candidates = trim(' ');
                $languages = trim(' ');
            } else {
                $ballot_id = $ballots->data[0]->ballot_id;
                $races = $RaceController->getRaceOfBallot($ballot_id);
                $parties = $PartyController->getPartyOfBallot($ballot_id);
                $languages = $LanguageController->getLangOfBallot($ballot_id);
                if(empty($races->data)) {
                    $candidates = trim(' ');
                } else {
                    $race_id = $races->data[0]->race_id;
                    $candidates = $this->getCandidateOfRace($race_id);
                }
            }

            return view('candidate')->with([
                'sliderAction' => 'manage', 
                'subAction' => 'candidate',
                'ballots' => $ballots,
                'races' => $races,
                'languages' => $languages,
                'candidates' => $candidates,
                'parties' => $parties
            ]);
        } else {
            return redirect('/');
        }
    }

    public function getCandidateOfRace($race_id){
        $Api = new ApiController;
        $api_url = env('API').'/candidate';
        $param = 'race_id='.$race_id;

        $response = $Api->getParamApi($api_url, $param);
        return $response;
    }

    public function createCandidate(Request $request) {
        $BaseController = new BaseController;
        $directory = "candidate/";
        $photo = $request->file('photo');
        $photo_link = $BaseController->fileUpload($photo, $directory);

        $data = array(
            "ballot_id" => $request->ballot_id,
            "race_id" => $request->race_id,
            "candidate_name" => $request->candidate_name,
            "email" => $request->email,
            "photo" => $photo_link,
            "party_id" => $request->party_id,
            "lang_id" => $request->lang_id
        );
        $data = json_encode($data);
        $api = env('API').'/candidate/create';
        
        $BaseController = new BaseController;
        return $BaseController->createData($data, $api);
    }

    public function getOneCand(Request $request) {
        $candidate_id = $request->candidate_id;
        $Api = new ApiController;
        $api_url = env('API').'/candidate';
        $param = 'candidate_id='.$candidate_id;

        $race = $Api->getParamApi($api_url, $param);
        $race = json_encode($race);

        return $race;
    }

    public function updateCandidate(Request $request) {
        $BaseController = new BaseController;
        $directory = "candidate/";
        $photo = $request->file('edit_photo');
        $photo_link = $BaseController->fileUpload($photo, $directory);

        $cand_id = array('candidate_id' => $request->edit_cand_id);
        $data = array(
            "candidate_name" => $request->edit_candidate_name,
            "email" => $request->edit_email,
            "photo" => $photo_link,
            "party_id" => $request->edit_party_id,
            "lang_id" => $request->edit_lang_id,
            'keys' => $cand_id
        );
        $data = json_encode($data);
        $api = env('API').'/candidate/update';

        $BaseController = new BaseController;
        return $BaseController->updateData($data, $api);
    }

    public function getChangedCand(Request $request) {
        $BallotController = new BallotController;
        $RaceController = new RaceController;
        $PartyController = new PartyController;
        $LanguageController = new LanguageController;

        $ballots = $BallotController->getActiveBallot();
        if(empty($ballots->data)) {
            $races = trim(' ');
            $parties = trim(' ');
            $candidates = trim(' ');
            $languages = trim(' ');
        } else {
            $ballot_id = $request->ballot_id;
            $races = $RaceController->getRaceOfBallot($ballot_id);
            $parties = $PartyController->getPartyOfBallot($ballot_id);
            $languages = $LanguageController->getLangOfBallot($ballot_id);
            if(empty($races->data)) {
                $candidates = trim(' ');
            } else {
                $race_id = $races->data[0]->race_id;
                $candidates = $this->getCandidateOfRace($race_id);
            }
        }

        return view('candidateTable')->with([
            'ballots' => $ballots,
            'races' => $races,
            'languages' => $languages,
            'candidates' => $candidates,
            'parties' => $parties
        ]);
    }

    public function getCandRaces(Request $request) {
        $ballot_id = $request->ballot_id;
        $RaceController = new RaceController;
        $races = $RaceController->getRaceOfBallot($ballot_id);
        return json_encode($races);
    }
}
