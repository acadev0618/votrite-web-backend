<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class VoterController extends Controller {
    public function index() {
        if(Session::get('display_name')) {
            $BallotController = new BallotController;
            $ballots = $BallotController->getActiveBallot();

            if(empty($ballots->data)) {
                $voters = trim(' ');
            } else {
                $ballot_id = $ballots->data[0]->ballot_id;
                $old_voter_ballot_id = session::get('old_voter_ballot_id');
                if(($old_voter_ballot_id != null) && ($old_voter_ballot_id != $ballot_id)) {
                    $ballot_id = $old_voter_ballot_id;
                }
                $voters = $this->getPinsOfBallot($ballot_id);
            }

            return view('voter')->with([
                'sliderAction' => 'manage', 
                'subAction' => 'voter',
                'ballots' => $ballots,
                'voters' => $voters
            ]);
        } else {
            return redirect('admin/');
        }
    }

    public function getPinsOfBallot($ballot_id) {
        $Api = new ApiController;
        $api_url = env('API').'/pincode';
        $param = 'ballot_id='.$ballot_id;

        $response = $Api->getParamApi($api_url, $param);
        return $response;
    }

    public function createVoter(Request $request){
        $data = array(
            "voter_email" => $request->voter_email,
            "voter_phone" => $request->voter_phone
        );
        
        $data = json_encode($data);
        $api = env('API').'/voter/create';

        $BaseController = new BaseController;
        return $BaseController->createData($data, $api);
    }

    public function getOneVoter(Request $request) {
        $voter_id = $request->voter_id;
        $Api = new ApiController;
        $api_url = env('API').'/voter';
        $param = 'voter_id='.$voter_id;

        $voter = $Api->getParamApi($api_url, $param);
        $voter = json_encode($voter);

        return $voter;
    }

    public function updateVoter(Request $request) {
        $voter_id = array('voter_id' => $request->voter_id);
        $data = array(
            "voter_email" => $request->voter_email,
            "voter_phone" => $request->voter_phone,
            'keys' => $voter_id
        );
        $data = json_encode($data);
        $api = env('API').'/voter/update';

        $BaseController = new BaseController;
        return $BaseController->updateData($data, $api);
    }

    public function verifiyVoter(Request $request) {
        $voter_id = array('voter_id' => $request->voter_id);
        $data = array(
            "registration_confirmed" => $request->registration_confirmed,
            'keys' => $voter_id
        );
        $data = json_encode($data);
        $api = env('API').'/voter/update';

        $Api = new ApiController;
        $response = $Api->postApi($data, $api);

        return json_encode($response);
    }

    public function setOldVB(Request $request) {
       $old_voter_ballot_id = $request->ballot_id;
       session(['old_voter_ballot_id' => $old_voter_ballot_id]);
       return $old_voter_ballot_id;
    }
}
