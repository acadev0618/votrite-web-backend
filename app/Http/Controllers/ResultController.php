<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class ResultController extends Controller
{
    public function candidate() {
        if(Session::get('display_name')) {
            $BallotController = new BallotController;
            $RaceController = new RaceController;
            $PartyController = new PartyController;
            $CandidateController = new CandidateController;

            $ballots = $BallotController->getActiveBallot();
            
            if(empty($ballots->data)) {
                $races = trim(' ');
                $candidates = trim(' ');
                $parties = trim(' ');
            } else {
                $ballot_id = $ballots->data[0]->ballot_id;
                $races = $RaceController->getRaceOfBallot($ballot_id);
                $parties = $PartyController->getPartyOfBallot($ballot_id);
                if(empty($races->data)) {
                    $candidates = trim(' ');
                    $parties = trim(' ');
                } else {
                    $race_id = $races->data[0]->race_id;
                    $candidates = $CandidateController->getCandidateOfRace($race_id);
                }
            }

            return view('result.candidate')->with([
                'sliderAction' => 'result', 
                'subAction' => 'candidate',
                'ballots' => $ballots,
                'races' => $races,
                'candidates' => $candidates,
                'parties' => $parties
            ]);
        } else {
            return redirect('admin/');
        }
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
            // $candidate = $Api->postApi($data, $api);
            // dd($candidate);
            $handle = curl_init($api);

            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLINFO_HEADER_OUT, true);
            curl_setopt($handle, CURLOPT_POST, true);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
            curl_setopt($handle, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
            );

            $output = curl_exec($handle);
            curl_close($handle);
            
            $candidate = json_decode($output);
            // dd($api, $data, $candidate);
            return view('result.voter')->with([
                'ballots' => $ballots, 
                'response' => $response, 
                'candidate' => $candidate, 
                'sliderAction' => 'result', 
                'subAction' => 'voter'
            ]);
        } else {
            return redirect('admin/');
        }
    }
    public function votercal(Request $request) {
        // dd($request->all());
        $Api = new ApiController;
        $data = array(
            "ballot_id" => $request->ballot_id,
            "pincode" => $request->pincode
        );
        $data = json_encode($data);
        $api = env('API').'/counter/candidate/pincode';
        // $Api = new ApiController;
        // $candidate = $Api->postApi($data, $api);
        // dd($candidate);
        $handle = curl_init($api);

        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLINFO_HEADER_OUT, true);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );

        $output = curl_exec($handle);
        // dd($api, $output);
        curl_close($handle);

        $candidate = json_decode($output);
        // dd($candidate);
        return response()->json([
            'candidate' => $candidate->data
        ]);
    }
    
}
