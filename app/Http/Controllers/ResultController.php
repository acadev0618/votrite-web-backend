<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class ResultController extends Controller
{
    public function candidate() {
        $result = [];
        $blt_cnt = 0;
        if(Session::get('display_name')) {
            $BallotController = new BallotController;

            $ballots = $BallotController->getActiveBallot();
            
            if(!empty($ballots->data)) {
                $ballot_id = $ballots->data[0]->ballot_id;
                // $races = $RaceController->getRaceOfBallot($ballot_id);
                
                $Api = new ApiController;
                
                $api_url_cand = env('API').'/result/candidate';
                $param_cand = 'ballot_id='.$ballots->data[0]->ballot_id;
                $response_cand = $Api->getParamApi($api_url_cand, $param_cand);
                if(count(get_object_vars($response_cand)) != 0 && property_exists($response_cand, "data")){
                    if(count($response_cand->data) != 0){
                        foreach($response_cand->data as $cand){
                            if(array_key_exists($cand->race_id, $result)){
                                array_push($result[$cand->race_id], $cand);
                            }else{
                                $result[$cand->race_id] = [];
                                array_push($result[$cand->race_id], $cand);
                            }
                        }
                    }
                }
                // dd($result);
                $api_url_prop = env('API').'/result/proposition';
                $param_prop = 'ballot_id='.$ballots->data[0]->ballot_id;
                $response_prop = $Api->getParamApi($api_url_prop, $param_prop);

                $data = array(
                    "ballot_id" => $ballots->data[0]->ballot_id
                );
                $data = json_encode($data);
                $api = env('API').'/result/ballot/counter';
                // $Api = new ApiController;
                $ballot_cnt = $Api->postApi($data, $api);
                if(count(get_object_vars($ballot_cnt)) != 0){
                    $blt_cnt = $ballot_cnt->data[0]->count;
                }

                // dd($ballot_cnt);
                // $parties = $PartyController->getPartyOfBallot($ballot_id);
                // if(empty($races->data)) {
                //     $candidates = trim(' ');
                //     $parties = trim(' ');
                // } else {
                //     $race_id = $races->data[0]->race_id;
                //     $candidates = $CandidateController->getCandidateOfRace($race_id);
                // }
            }
            // dd($ballots, $races, $candidates, $parties);
            return view('result.candidate')->with([
                'sliderAction' => 'result', 
                'subAction' => 'candidate',
                'ballots' => $ballots,
                // 'races' => $races,
                'candidates' => $result,
                'blt_cnt' => $blt_cnt,
                'props' => $response_prop
            ]);
        } else {
            return redirect('admin/');
        }
    }

    public function ballotcal(Request $request) {
        $result = [];
        $blt_cnt = 0;
            $BallotController = new BallotController;

            $ballots = $BallotController->getActiveBallot();
            
            if(!empty($ballots->data)) {
                $ballot_id = $request->ballot_id;
                // $races = $RaceController->getRaceOfBallot($ballot_id);
                
                $Api = new ApiController;
                
                $api_url_cand = env('API').'/result/candidate';
                $param_cand = 'ballot_id='.$request->ballot_id;
                $response_cand = $Api->getParamApi($api_url_cand, $param_cand);
                if(count(get_object_vars($response_cand)) != 0 && property_exists($response_cand, "data")){
                    if(count($response_cand->data) != 0){
                        foreach($response_cand->data as $cand){
                            if(array_key_exists($cand->race_id, $result)){
                                array_push($result[$cand->race_id], $cand);
                            }else{
                                $result[$cand->race_id] = [];
                                array_push($result[$cand->race_id], $cand);
                            }
                        }
                    }
                }
                // dd($result);
                $api_url_prop = env('API').'/result/proposition';
                $param_prop = 'ballot_id='.$request->ballot_id;
                $response_prop = $Api->getParamApi($api_url_prop, $param_prop);

                $data = array(
                    "ballot_id" => $request->ballot_id
                );
                $data = json_encode($data);
                $api = env('API').'/result/ballot/counter';
                // $Api = new ApiController;
                $ballot_cnt = $Api->postApi($data, $api);
                if(count(get_object_vars($ballot_cnt)) != 0){
                    $blt_cnt = $ballot_cnt->data[0]->count;
                }

                // dd($ballot_cnt);
                // $parties = $PartyController->getPartyOfBallot($ballot_id);
                // if(empty($races->data)) {
                //     $candidates = trim(' ');
                //     $parties = trim(' ');
                // } else {
                //     $race_id = $races->data[0]->race_id;
                //     $candidates = $CandidateController->getCandidateOfRace($race_id);
                // }
            }
            // dd($ballots, $races, $candidates, $parties);
            return view('result.common.table')->with([
                'sliderAction' => 'result', 
                'subAction' => 'candidate',
                'ballots' => $ballots,
                // 'races' => $races,
                'candidates' => $result,
                'blt_cnt' => $blt_cnt,
                'props' => $response_prop
            ]);
    }
    public function proposition() {
        if(Session::get('display_name')) {
            $BallotController = new BallotController;
            $CountyController = new CountyController;
            $RaceController = new RaceController;
            $PropositionController = new PropositionController;

            $ballots = $BallotController->getActiveBallot();
            
            if(empty($ballots->data)) {
                $races = trim(' ');
                $countries = trim(' ');
                $propositions = trim(' ');
            } else {
                $ballot_id = $ballots->data[0]->ballot_id;
                $races = $RaceController->getRaceOfBallot($ballot_id);
                $prop_type = 'P';
                $countries = $CountyController->getCountyOfBallot($ballot_id);
                $propositions = $PropositionController->getPropOfBallot($ballot_id, $prop_type);
            }

            return view('result.proposition')->with([
                'sliderAction' => 'result',
                'subAction' => 'proposition',
                'ballots' => $ballots,
                'races' => $races,
                'countries' => $countries,
                'propositions' => $propositions
            ]);
        } else {
            return redirect('admin/');
        }
    }

    public function ballot() {
        if(Session::get('display_name')) {
            $BallotController = new BallotController;
            $ballots = $BallotController->getActiveBallot();

            return view('result.ballot')->with([
                'ballots' => $ballots, 
                'sliderAction' => 'result', 
                'subAction' => 'ballot'
            ]);
        } else {
            return redirect('admin/');
        }
    }
    public function voter() {
        if(Session::get('display_name')) {
            $candrlt = [];
            $BallotController = new BallotController;
            $ballots = $BallotController->getActiveBallot();
            $Api = new ApiController;
            $api_url = env('API').'/pincode';
            $param = 'ballot_id='.$ballots->data[0]->ballot_id;

            $response = $Api->getParamApi($api_url, $param);

            $data = array(
                "ballot_id" => $ballots->data[0]->ballot_id,
                "pincode" => $response->data[0]->pin
            );
            $data = json_encode($data);
            $api = env('API').'/counter/candidate/pincode';
            // $Api = new ApiController;
            $candidate = $Api->postApi($data, $api);
            if(count(get_object_vars($candidate)) != 0 && property_exists($candidate, "data")){
                
                if(count($candidate->data) != 0){
                    foreach($candidate->data as $cand){
                        // if(property_exists($candidate, $cand->race_id)){
                        //     $candrlt[$cand->race_id] = [];
                        // }
                        if(array_key_exists($cand->race_id, $candrlt)){
                            // dd($candrlt[$cand->race_id], $cand->race_id);
                            array_push($candrlt[$cand->race_id], (array)$cand);
                        }else{
                            $candrlt[$cand->race_id] = [];
                            array_push($candrlt[$cand->race_id], (array)$cand);
                        }
                    }
                    // dd($candrlt);
                }
            }
            // dd($candidate);
            // $handle = curl_init($api);

            // curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($handle, CURLINFO_HEADER_OUT, true);
            // curl_setopt($handle, CURLOPT_POST, true);
            // curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
            // curl_setopt($handle, CURLOPT_HTTPHEADER, array(
            //     'Content-Type: application/json',
            //     'Content-Length: ' . strlen($data))
            // );

            // $output = curl_exec($handle);
            // curl_close($handle);
            
            // $candidate = json_decode($output);
            
            // dd($api, $data, $candidate);
            $api1 = env('API').'/counter/proposition/pincode';
            // $Api = new ApiController;
            $prop = $Api->postApi($data, $api1);
            // dd($candidate);
            // $handle1 = curl_init($api1);

            // curl_setopt($handle1, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($handle1, CURLINFO_HEADER_OUT, true);
            // curl_setopt($handle1, CURLOPT_POST, true);
            // curl_setopt($handle1, CURLOPT_POSTFIELDS, $data);
            // curl_setopt($handle1, CURLOPT_HTTPHEADER, array(
            //     'Content-Type: application/json',
            //     'Content-Length: ' . strlen($data))
            // );

            // $output1 = curl_exec($handle1);
            // // dd($api, $output);
            // curl_close($handle1);

            // $prop = json_decode($output1);
            
            return view('result.voter')->with([
                'ballots' => $ballots, 
                'response' => $response, 
                'candidate' => $candrlt, 
                'prop' => $prop, 
                'sliderAction' => 'result', 
                'subAction' => 'voter'
            ]);
        } else {
            return redirect('admin/');
        }
    }
    public function votercal(Request $request) {
        // dd($request->all());
        $candrlt=[];
        $proprlt=[];
        $Api = new ApiController;
        $data = array(
            "ballot_id" => $request->ballot_id,
            "pincode" => $request->pincode
        );
        $data = json_encode($data);
        $api = env('API').'/counter/candidate/pincode';
        $Api = new ApiController;
        $candidate = $Api->postApi($data, $api);
        // dd($candidate);
        // $handle = curl_init($api);

        // curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($handle, CURLINFO_HEADER_OUT, true);
        // curl_setopt($handle, CURLOPT_POST, true);
        // curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($handle, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json',
        //     'Content-Length: ' . strlen($data))
        // );

        // $output = curl_exec($handle);
        // // dd($api, $output);
        // curl_close($handle);

        // $candidate = json_decode($output);

        $api1 = env('API').'/counter/proposition/pincode';
        // $Api = new ApiController;
        $prop = $Api->postApi($data, $api1);
        // dd($candidate);
        // $handle1 = curl_init($api1);

        // curl_setopt($handle1, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($handle1, CURLINFO_HEADER_OUT, true);
        // curl_setopt($handle1, CURLOPT_POST, true);
        // curl_setopt($handle1, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($handle1, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json',
        //     'Content-Length: ' . strlen($data))
        // );

        // $output1 = curl_exec($handle1);
        // // dd($api, $output);
        // curl_close($handle1);

        // $prop = json_decode($output1);
        // dd($prop);
        if(count(get_object_vars($candidate)) != 0 && property_exists($candidate, "data")){
            $candrlt = [];
            if(count($candidate->data) != 0){
                foreach($candidate->data as $cand){
                    // if(property_exists($candidate, $cand->race_id)){
                    //     $candrlt[$cand->race_id] = [];
                    // }
                    if(array_key_exists($cand->race_id, $candrlt)){
                        // dd($candrlt[$cand->race_id], $cand->race_id);
                        array_push($candrlt[$cand->race_id], (array)$cand);
                    }else{
                        $candrlt[$cand->race_id] = [];
                        array_push($candrlt[$cand->race_id], (array)$cand);
                    }
                }
                // dd($candrlt);
            }
        }
        if(count(get_object_vars($prop)) != 0 && property_exists($prop, "data")){
            $proprlt = $prop->data;
        }
        return response()->json([
            'candidate' => $candrlt,
            'prop' => $proprlt
        ]);
    }
}
