<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class PartyController extends Controller {
    public function index(Request $request) {
        if(Session::get('display_name')) {
            $BallotController = new BallotController;
            $ballots = $BallotController->getActiveBallot();

            if(empty($ballots->data)) {
                $parties = trim(' ');
            } else {
                $ballot_id = $request->old('ballot_id')==null?$ballots->data[0]->ballot_id:$request->old('ballot_id');
                $old_party_ballot_id = session::get('old_party_ballot_id');
                if(($old_party_ballot_id != null) && ($old_party_ballot_id != $ballot_id)) {
                    $ballot_id = $old_party_ballot_id;
                }
                $parties = $this->getPartyOfBallot($ballot_id);
            }

            return view('party')->with([
                'sliderAction' => 'manage', 
                'subAction' => 'party',
                'ballots' => $ballots,
                'parties' => $parties
            ]);
        } else {
            return redirect('admin/');
        }
    }

    public function getPartyOfBallot($ballot_id) {
        $Api = new ApiController;
        $api_url = env('API').'/ballot/party';
        $param = 'ballot_id='.$ballot_id;

        $response = $Api->getParamApi($api_url, $param);
        return $response;
    }

    public function getOneParty(Request $request) {
        $party_id = $request->party_id;
        $Api = new ApiController;
        $api_url = env('API').'/ballot/party';
        $param = 'party_id='.$party_id;

        $party = $Api->getParamApi($api_url, $param);
        $party = json_encode($party);

        return $party;
    }

    public function createParty(Request $request){
        $BaseController = new BaseController;
        $directory = "party/";
        $photo = $request->file('party');
        $photo_link = $BaseController->fileUpload($photo, $directory);

        $data = array(
            "ballot_id" => $request->ballot_id,
            "party_name" => $request->party_name,
            "party_logo" => $photo_link
        );
        
        $data = json_encode($data);
        $api = env('API').'/ballot/party/create';

        $BaseController = new BaseController;
        return $BaseController->createData($data, $api);
    }

    public function updateParty(Request $request) {
        $party_id = array('party_id' => $request->party_id);
        $data = array(
            "ballot_id" => $request->ballot_id,
            "party_name" => $request->party_name,
            'keys' => $party_id
        );

        $BaseController = new BaseController;
        $directory = "party/";
        $photo = $request->file('edit_party');
        if($photo) {
            $photo_link = $BaseController->fileUpload($photo, $directory);
            $data += [ "party_logo" => $photo_link ];
        }

        $data = json_encode($data);
        $api = env('API').'/ballot/party/update';

        $BaseController = new BaseController;
        return $BaseController->updateData($data, $api);
    }

    public function getChangedParty(Request $request) {
        $BallotController = new BallotController;
        $ballots = $BallotController->getActiveBallot();

        session(['old_party_ballot_id' => $request->ballot_id]);

        if(empty($ballots->data)) {
            $parties = trim(' ');
        } else {
            $ballot_id = $request->ballot_id;
            $parties = $this->getPartyOfBallot($ballot_id);
        }

        return view('partyTable')->with([
            'ballots' => $ballots,
            'parties' => $parties
        ]);

    }
}
