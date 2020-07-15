<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class CountyController extends Controller {

    public function index(Request $request) {
        if(Session::get('display_name')) {
            $BallotController = new BallotController;
            $ballots = $BallotController->getActiveBallot();
            $states = $this->getAllStates();

            if(empty($ballots->data) || empty($states->data)) {
                $ballot_counties = trim(' ');
                $counties = trim(' ');
            } else {
                $state_id = $states->data[0]->state_id;

                $old_county_state_id = session::get('old_county_state_id');
                if(($old_county_state_id != null) && ($old_county_state_id != $state_id)) {
                    $state_id = $old_county_state_id;
                }
                
                $counties = $this->getCountiesOfState($state_id);

                $ballot_id = $request->old('ballot_id')==null?$ballots->data[0]->ballot_id:$request->old('ballot_id');
                $old_county_ballot_id = session::get('old_county_ballot_id');
                if(($old_county_ballot_id != null) && ($old_county_ballot_id != $ballot_id)) {
                    $ballot_id = $old_county_ballot_id;
                }

                $ballot_counties = $this->getCounties($ballot_id , $state_id);
            }

            return view('county')->with([
                'sliderAction' => 'manage', 
                'subAction' => 'county',
                'ballots' => $ballots,
                'states' => $states,
                'ballot_counties' => $ballot_counties,
                'counties' => $counties
            ]);
        } else {
            return redirect('admin/');
        }
    }

    public function getChangedCountyOfBallot(Request $request) {
        $BallotController = new BallotController;
        $ballots = $BallotController->getActiveBallot();
        $states = $this->getAllStates();

        session(['old_county_ballot_id' => $request->ballot_id]);
        session(['old_county_state_id' => $request->state_id]);
        
        if(empty($ballots->data) || empty($states->data)) {
            $ballot_counties = trim(' ');
            $counties = trim(' ');
        } else {
            $state_id = $request->state_id;
            $counties = $this->getCountiesOfState($state_id);
            $ballot_id = $request->ballot_id;
            $ballot_counties = $this->getCounties($ballot_id , $state_id);
        }

        return view('countyChanged')->with([
            'ballots' => $ballots,
            'states' => $states,
            'ballot_counties' => $ballot_counties,
            'counties' => $counties
        ]);
    }
    
    public function getCounties($ballot_id, $state_id) {
        $Api = new ApiController;
        $api_url = env('API').'/ballot/county';
        $param = 'ballot_id='.$ballot_id.'&'.'state_id='.$state_id;

        $response = $Api->getParamApi($api_url, $param);
        return $response;
    }
    
    public function getCountyOfBallot($ballot_id) {
        $Api = new ApiController;
        $api_url = env('API').'/ballot/county';
        $param = 'ballot_id='.$ballot_id;

        $response = $Api->getParamApi($api_url, $param);
        return $response;
    }

    public function getAllStates() {
        $Api = new ApiController;
        $api_url = env('API').'/location/state';

        $response = $Api->getApi($api_url);

        return $response;
    }

    public function getCountiesOfState($state_id) {
        $Api = new ApiController;
        $api_url = env('API').'/location/county';
        $param = 'state_id='.$state_id;

        $response = $Api->getParamApi($api_url, $param);
        return $response;
    }

    public function setAvalBallotCounty(Request $request) {
        $ballot_id = $request->ballot_id;
        $state_id = $request->state_id;
        $county_id = $request->county_id;
        $avaliable = $request->avaliable;
        $Api = new ApiController;

        $data = array(
            'ballot_id' => $ballot_id,
            'state_id' => $state_id,
            'county_id' => $county_id
        );
        $data = json_encode($data);
        
        $ballot_counties = $this->getCountyOfBallot($ballot_id);

        if($avaliable == "true") {
            $api = env('API').'/ballot/county/create';
            $response = $Api->postApi($data, $api);
        } else if($avaliable == "false") {
            $api = env('API').'/ballot/county/delete';
            $response = $Api->postApi($data, $api);
        }

        return json_encode($response);
    }

    public function saveAllCounty(Request $request) {
        $ballot_id = $request->ballot_id;
        $state_id = $request->state_id;
        $ids = $request->ids;

        $avaliable = $request->avaliable;
        if($avaliable == "false") {
            $response = $this->deleteAll($ballot_id, $state_id);
            return $response;
        } else if($avaliable == "true") {
            $response = $this->saveAll($ballot_id, $state_id, $ids);
            return $response;
        }
    }

    public function saveAll($ballot_id, $state_id, $ids) {
        $ids = explode(',', $ids);
        $ballot_counties = $this->getCounties($ballot_id , $state_id);
        if(empty($ballot_counties->data)) {
            for($i = 0; $i < count($ids); $i ++) {
                $data = array(
                    'ballot_id' => $ballot_id,
                    'state_id' => $state_id,
                    'county_id' => $ids[$i]
                );
                $json = json_encode($data);
                $api_url = env('API').'/ballot/county/create';
                
                $controller = new ApiController;
                $response = $controller->postApi($json, $api_url);
            }
            return json_encode($response);
        } else if(count($ids) == count($ballot_counties->data)){
            $response = array(
                'state' => "success",
                'message'=> "-2"
            );
            return json_encode($response);
        } else {
            $selected = [];
            for($i = 0; $i < count($ids); $i ++) {
                $flag = 0;
                for($j = 0; $j < count($ballot_counties->data); $j ++) {
                    if($ids[$i] == $ballot_counties->data[$j]->county_id) {
                        $flag = 1;
                    }
                }
                if($flag != 1) {
                    array_push($selected, $ids[$i]);
                }
            }

            for($k = 0; $k < count($selected); $k ++) {
                $data = array(
                    'ballot_id' => $ballot_id,
                    'state_id' => $state_id,
                    'county_id' => $selected[$k]
                );
                $json = json_encode($data);
                $api_url = env('API').'/ballot/county/create';
                
                $controller = new ApiController;
                $response = $controller->postApi($json, $api_url);
            }
            return json_encode($response);
        } 
    }

    public function deleteAll($ballot_id, $state_id) {
        $ballot_counties = $this->getCountyOfBallot($ballot_id);

        if(empty($ballot_counties->data)) {
            $response = array(
                'state' => "success",
                'message'=> "-1"
            );
            return json_encode($response);
        } else {
            $ids = [];
            for($i = 0; $i < count($ballot_counties->data); $i ++) {
                array_push($ids, $ballot_counties->data[$i]->county_id);
            }

            for($i = 0; $i < count($ids); $i ++) {
                $data = array(
                    'ballot_id' => $ballot_id,
                    'state_id' => $state_id,
                    'county_id' => $ids[$i]
                );
                $json = json_encode($data);
                $api_url = env('API').'/ballot/county/delete';
                
                $controller = new ApiController;
                $response = $controller->postApi($json, $api_url);
            }
            return json_encode($response);
        }
    }
}
