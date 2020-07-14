<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class MassPropositionController extends Controller {
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
                $old_mprop_ballot_id = session::get('old_mprop_ballot_id');
                $ballot_id = $request->old('ballot_id')==null?$ballots->data[0]->ballot_id:$request->old('ballot_id');
                if(($old_mprop_ballot_id != null) && ($old_mprop_ballot_id != $ballot_id)) {
                    $ballot_id = $old_mprop_ballot_id;
                }
                $prop_type = 'M';
                $languages = $LanguageController->getLangOfBallot($ballot_id);
                $counties = $CountyController->getCountyOfBallot($ballot_id);
                $propositions = $this->getMassPropOfBallot($ballot_id, $prop_type);
            }

            return view('mass_proposition')->with([
                'sliderAction' => 'manage', 
                'subAction' => 'mass_proposition',
                'ballots' => $ballots,
                'languages' => $languages,
                'counties' => $counties,
                'propositions' => $propositions
            ]);
        } else {
            return redirect('admin/');
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
        $CountyController = new CountyController;
        $PropositionController = new PropositionController;

        $ballots = $BallotController->getActiveBallot();

        session(['old_mprop_ballot_id' => $request->ballot_id]);

        if(empty($ballots->data)) {
            $languages = trim(' ');
            $counties = trim(' ');
            $propositions = trim(' ');
        } else {
            $ballot_id = $request->ballot_id;
            $prop_type = $request->prop_type;
            $languages = $LanguageController->getLangOfBallot($ballot_id);
            $counties = $CountyController->getCountyOfBallot($ballot_id);
            $propositions = $PropositionController->getPropOfBallot($ballot_id, $prop_type);
        }
        
        return view('massPropTable')->with([
            'ballots' => $ballots,
            'languages' => $languages,
            'counties' => $counties,
            'propositions' => $propositions
        ]);
    }
}
