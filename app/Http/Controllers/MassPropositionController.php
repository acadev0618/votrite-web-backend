<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class MassPropositionController extends Controller {
    public function index() {
        if(Session::get('display_name')) {
            $BallotController = new BallotController;
            $LanguageController = new LanguageController;
            $CountryController = new CountryController;

            $ballots = $BallotController->getActiveBallot();
            
            if(empty($ballots->data)) {
                $languages = trim(' ');
                $countries = trim(' ');
                $propositions = trim(' ');
            } else {
                $ballot_id = $ballots->data[0]->ballot_id;
                $prop_type = 'M';
                $languages = $LanguageController->getLangOfBallot($ballot_id);
                $countries = $CountryController->getCountryOfBallot($ballot_id);
                $propositions = $this->getMassPropOfBallot($ballot_id, $prop_type);
            }

            return view('mass_proposition')->with([
                'sliderAction' => 'manage', 
                'subAction' => 'mass_proposition',
                'ballots' => $ballots,
                'languages' => $languages,
                'countries' => $countries,
                'propositions' => $propositions
            ]);
        } else {
            return redirect('/');
        }
    }

    public function getMassPropOfBallot($ballot_id) {
        $Api = new ApiController;
        $api_url = env('API').'/proposition';
        $param = 'ballot_id='.$ballot_id.'&prop_type=M';

        $response = $Api->getParamApi($api_url, $param);
        return $response;
    }    
    
    public function getChangedMassProps(Request $request) {
        $BallotController = new BallotController;
        $LanguageController = new LanguageController;
        $CountryController = new CountryController;
        $PropositionController = new PropositionController;

        $ballots = $BallotController->getActiveBallot();

        if(empty($ballots->data)) {
            $languages = trim(' ');
            $countries = trim(' ');
            $propositions = trim(' ');
        } else {
            $ballot_id = $request->ballot_id;
            $prop_type = $request->prop_type;
            $languages = $LanguageController->getLangOfBallot($ballot_id);
            $countries = $CountryController->getCountryOfBallot($ballot_id);
            $propositions = $PropositionController->getPropOfBallot($ballot_id, $prop_type);
        }
        
        return view('massPropTable')->with([
            'ballots' => $ballots,
            'languages' => $languages,
            'countries' => $countries,
            'propositions' => $propositions
        ]);
    }
}
