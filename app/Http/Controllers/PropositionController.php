<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class PropositionController extends Controller {
    
    public function index(Request $request) {
        if(Session::get('display_name')) {
            $BallotController = new BallotController;
            $LanguageController = new LanguageController;
            $CountyController = new CountyController;

            $ballots = $BallotController->getActiveBallot();
            
            if(empty($ballots->data)) {
                $languages = trim(' ');
                $counties = trim(' ');
                $propositions = trim(' ');
            } else {
                $old_prop_ballot_id = session::get('old_prop_ballot_id');
                $ballot_id = $request->old('ballot_id')==null?$ballots->data[0]->ballot_id:$request->old('ballot_id');
                if(($old_prop_ballot_id != null) && ($old_prop_ballot_id != $ballot_id)) {
                    $ballot_id = $old_prop_ballot_id;
                }
                $prop_type = 'P';
                $languages = $LanguageController->getLangOfBallot($ballot_id);
                $counties = $CountyController->getCountyOfBallot($ballot_id);
                $propositions = $this->getPropOfBallot($ballot_id, $prop_type);
            }

            return view('proposition')->with([
                'sliderAction' => 'manage',
                'subAction' => 'proposition',
                'ballots' => $ballots,
                'languages' => $languages,
                'counties' => $counties,
                'propositions' => $propositions
            ]);
        } else {
            return redirect('admin/');
        }
    }

    public function getPropOfBallot($ballot_id, $prop_type) {
        $Api = new ApiController;
        $api_url = env('API').'/proposition';
        $param = 'ballot_id='.$ballot_id.'&prop_type='.$prop_type;

        $response = $Api->getParamApi($api_url, $param);
        return $response;
    }

    public function createProposition(Request $request){
        $ballot_id = $request->ballot_id;

        if(empty($request->prop_name)) {
            $prop_name = "";
        } else {
            $prop_name = $request->prop_name;
        }
        if(empty($request->prop_text)) {
            $prop_text = "";
        } else {
            $prop_text = $request->prop_text;
        }

        if($request->prop_location_id == 0 || $request->prop_lang_id == 0) {
            $data = array(
                "ballot_id" => $request->ballot_id,
                "prop_name" => $prop_name,
                "prop_title" => $request->prop_title,
                "prop_text" => $prop_text,
                "prop_answer_type" => $request->prop_answer_type,
                "prop_type" => $request->prop_type
            );
        } else {
            $data = array(
                "ballot_id" => $request->ballot_id,
                "prop_name" => $prop_name,
                "prop_title" => $request->prop_title,
                "prop_text" => $prop_text,
                "prop_answer_type" => $request->prop_answer_type,
                "prop_location_id" => $request->prop_location_id,
                "prop_lang_id" => $request->prop_lang_id,
                "prop_type" => $request->prop_type
            );
        }
        $data = json_encode($data);
        $api = env('API').'/proposition/create';

        $BaseController = new BaseController;
        return $BaseController->createData($data, $api);
    }

    public function getOneProp(Request $request) {
        $prop_id = $request->prop_id;
        $Api = new ApiController;
        $api_url = env('API').'/proposition';
        $param = 'proposition_id='.$prop_id;

        $race = $Api->getParamApi($api_url, $param);
        $race = json_encode($race);

        return $race;
    }

    public function updateProposition(Request $request) {
        $prop_id = array('proposition_id' => $request->prop_id);

        if(empty($request->prop_name)) {
            $prop_name = "";
        } else {
            $prop_name = $request->prop_name;
        }
        if(empty($request->prop_text)) {
            $prop_text = "";
        } else {
            $prop_text = $request->prop_text;
        }

        if($request->prop_location_id == 0 || $request->prop_lang_id == 0) {
            $data = array(
                "ballot_id" => $request->ballot_id,
                "prop_name" => $prop_name,
                "prop_title" => $request->prop_title,
                "prop_text" => $prop_text,
                "prop_answer_type" => $request->prop_answer_type,
                "prop_type" => $request->prop_type,
                'keys' => $prop_id
            );
        } else {
            $data = array(
                "ballot_id" => $request->ballot_id,
                "prop_name" => $prop_name,
                "prop_title" => $request->prop_title,
                "prop_text" => $prop_text,
                "prop_answer_type" => $request->prop_answer_type,
                "prop_location_id" => $request->prop_location_id,
                "prop_lang_id" => $request->prop_lang_id,
                "prop_type" => $request->prop_type,
                'keys' => $prop_id
            );
        }
        $data = json_encode($data);
        $api = env('API').'/proposition/update';

        $BaseController = new BaseController;
        return $BaseController->updateData($data, $api);
    }

    public function getChangedProps(Request $request) {
        $BallotController = new BallotController;
        $LanguageController = new LanguageController;
        $CountyController = new CountyController;

        $ballots = $BallotController->getActiveBallot();

        session(['old_prop_ballot_id' => $request->ballot_id]);

        if(empty($ballots->data)) {
            $languages = trim(' ');
            $counties = trim(' ');
            $propositions = trim(' ');
        } else {
            $ballot_id = $request->ballot_id;
            $prop_type = $request->prop_type;
            $languages = $LanguageController->getLangOfBallot($ballot_id);
            $counties = $CountyController->getCountyOfBallot($ballot_id);
            $propositions = $this->getPropOfBallot($ballot_id, $prop_type);
        }
        
        return view('propsTable')->with([
            'ballots' => $ballots,
            'languages' => $languages,
            'counties' => $counties,
            'propositions' => $propositions
        ]);
    }
}
