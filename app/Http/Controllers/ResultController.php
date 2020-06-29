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
    
}
