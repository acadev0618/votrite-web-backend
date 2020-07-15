<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class CandidateController extends Controller {
    public function index(Request $request) {
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
                $old_cand_ballot_id = session::get('old_cand_ballot_id');
                $ballot_id = $request->old('ballot_id')==null?$ballots->data[0]->ballot_id:$request->old('ballot_id');
                if(($old_cand_ballot_id != null) && ($old_cand_ballot_id != $ballot_id)) {
                    $ballot_id = $old_cand_ballot_id;
                }
                $races = $RaceController->getRaceOfBallot($ballot_id);
                $parties = $PartyController->getPartyOfBallot($ballot_id);
                $languages = $LanguageController->getLangOfBallot($ballot_id);
                if(empty($races->data)) {
                    $candidates = trim(' ');
                } else {
                    $old_cand_race_id = session::get('old_cand_race_id');
                    $race_id = $request->old('race_id')==null?$races->data[0]->race_id:$request->old('race_id');
                    if(($old_cand_race_id != null) && ($old_cand_race_id != $race_id)) {
                        $race_id = $old_cand_race_id;
                    }
                    $candidates = $this->getCandidateOfRace($race_id);
                }

                // var_dump($ballot_id, $race_id);die();
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
            return redirect('admin/');
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

        if(empty($photo)) {
            $photo_link = "";
        } else {
            $photo_link = $BaseController->fileUpload($photo, $directory);
        }

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
        $del_photo = $request->edit_del_photo;
        $cand_id = array('candidate_id' => $request->edit_cand_id);
        $data = array(
            "ballot_id" => $request->ballot_id,
            "race_id" => $request->race_id,
            "candidate_name" => $request->edit_candidate_name,
            "email" => $request->edit_email,
            "party_id" => $request->edit_party_id,
            'keys' => $cand_id
        );

        if($del_photo == "false") {
            $BaseController = new BaseController;
            $directory = "candidate/";
            $photo = $request->file('edit_photo');
            if($photo) {
                $photo_link = $BaseController->fileUpload($photo, $directory);
                $data += [ "photo" => $photo_link ];
            }
        } else if($del_photo == "true") {
            $data += [ "photo" => null ];
        }

        if($request->edit_lang_id != -1) {
            $data += [ "lang_id" => $request->edit_lang_id ];
        }
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
        session(['old_cand_ballot_id' => $request->ballot_id]);
        session(['old_cand_race_id' => $request->race_id]);

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
                $race_id = $request->race_id;
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

    public function getChangedCand1(Request $request) {
        $BallotController = new BallotController;
        $RaceController = new RaceController;
        $PartyController = new PartyController;
        $LanguageController = new LanguageController;

        session(['old_cand_ballot_id' => $request->ballot_id]);
        session(['old_cand_race_id' => $request->race_id]);

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
                $race_id = $request->race_id;
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
        $LanguageController = new LanguageController;
        $races = $RaceController->getRaceOfBallot($ballot_id);
        $langs = $LanguageController->getLangOfBallot($ballot_id);
        $response = array(
            'races' => $races,
            'langs' => $langs
        );
        return json_encode($response);
    }
}
