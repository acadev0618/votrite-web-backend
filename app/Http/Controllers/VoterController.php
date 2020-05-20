<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class VoterController extends Controller {
    public function index() {
        if(Session::get('display_name')) {
            $voters = $this->getAllVoter();

            return view('voter')->with([
                'sliderAction' => 'manage', 
                'subAction' => 'voter',
                'voters' => $voters
            ]);
        } else {
            return redirect('/');
        }
    }

    public function getAllVoter(){
        $api_url = env('API').'/voter';

        $Api = new ApiController;
        $response = $Api->getApi($api_url);

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
}
