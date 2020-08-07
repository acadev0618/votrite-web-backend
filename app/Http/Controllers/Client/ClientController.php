<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BallotController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\PropositionController;
use App\Http\Controllers\CandidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;

class ClientController extends Controller {
    

    public function welcome(Request $request) {
        return view('client.welcome');
    }

    public function ballot(Request $request) {
        $BallotController = new BallotController;
        $response = $BallotController->getActiveBallot();
        return view('client.ballot')->with(['ballots' => $response]);
    }

    public function index(Request $request) {
        return view('client.index')->with(['ballot' => $request->radio]);
    }

    public function sendpincode(Request $request) {
        $Api = new ApiController;
        $api_url = env('API').'/pincode';
        $param = 'ballot_id='.$request->ballot_id.'&pin='.$request->pincode;

        $response = $Api->getParamApi($api_url, $param);
        if(!property_exists($response, "data")){
            return back()->withErrors(['Incorrect PinCode.']);
        }
        if($response->data[0]->is_used){
            return back()->withErrors(['Used PinCode.']);
        }
        if($response->data[0]->is_used){
            return back()->withErrors(['Used PinCode.']);
        }
        if(strtotime('today') > strtotime($response->data[0]->expiration_time)){
            return back()->withErrors(['Expired PinCode.']);
        }

        session(['pin' => $request->pincode]);
        session(['races' => []]);
        session(['props' => []]);
        session(['mass' => []]);
        session(['raceresult' => []]);
        session(['propresult' => []]);
        session(['massresult' => []]);
        session(['lastrace' => []]);
        session(['current' => 0]);
        session(['showreview'=> false]);
        
        if(count(get_object_vars($response)) != 0){
            return  redirect()->route('client.viewcand', ['ballot_id'=>$request->ballot_id]);
        }else{
            return back()->withErrors(['msg', 'error']);
        }
    }

    public function lang(Request $request) {
        $LanguageController = new LanguageController;
        $languages = $LanguageController->getLangOfBallot($request->ballot_id);
        if(count(get_object_vars($languages)) != 0){
            return view('client.lang')->with(['languages' => $languages,'ballot_id'=>$request->ballot_id]);
        }else{
            return view('client.lang')->with(['languages' => null,'ballot_id'=>$request->ballot_id]);
        }
    }

    public function viewcand(Request $request) {
        $ballot_id = $request->ballot_id;
        
        $BallotController = new BallotController;
        $RaceController = new RaceController;
        $PropositionController = new PropositionController;
        $CandidateController = new CandidateController;

        if($request->radio == null){
            $races = $RaceController->getRaceOfBallot($ballot_id);
        }else{
            $races = $RaceController->getRaceOfBallot($ballot_id);
        }
        $propositions = $PropositionController->getPropOfBallot($ballot_id, 'P');
        $massitions = $PropositionController->getPropOfBallot($ballot_id, 'M');

        $rcnt = 0;
        $pcnt = 0;
        $mcnt = 0;
        
        if(count(get_object_vars($races)) != 0){
            $rcnt = count($races->data);
            session([ 'races' => $races->data ]);
        }
        if(count(get_object_vars($propositions)) != 0){
            $pcnt = 1;
            session([ 'props' => $propositions->data ]);
        }
        if(count(get_object_vars($massitions)) != 0){
            $mcnt = 1;
            session([ 'mass' => $massitions->data ]);
        }
        $candidates = $CandidateController->getCandidateOfRace($races->data[0]->race_id);
        $totalcnt = $rcnt + $pcnt + $mcnt;
        
        $Api = new ApiController;
        $api_url = env('API').'/ballot';
        $param = 'ballot_id='.$ballot_id;
        
        $response = $Api->getParamApi($api_url, $param);
        
        session([ 'ballots' => $response, 'totalcnt'=>$totalcnt ]);

        return view('client.race')->with(['ballots' => $response, 'races' => session('races'), 'candidates' => $candidates]);
    }
    
    public function racecount(Request $request) {

        $CandidateController = new CandidateController;
        
        $raceresult = session('raceresult');
        $raceresult[$request->only('race_id')['race_id']] = $request->except('_token', 'ballot_id', 'race_id');
        session(['reviewcnt'=> null]);
        session(['raceresult'=> $raceresult]);
        
        $races = session('races');
        $lastrace = session('lastrace');
        $race = array_shift($races);
        array_push($lastrace, $race);
        session(['lastrace'=> $lastrace]);
        session(['races'=> $races]);
        
        $current = session('current');
        session(['current'=> $current+1]);
        if(count($races) == 0){
            return  redirect()->route('client.prop', ['ballot_id'=>$request->ballot_id]);
        }

        $candidates = $CandidateController->getCandidateOfRace($races[0]->race_id);
        return view('client.race')->with(['ballots' => session('ballots'), 'races' => $races, 'candidates' => $candidates]);
    }

    public function review(Request $request) {
        session(['showreview'=> true]);
        if(session('reviewcnt') != null){
            $reviewcnt = session('reviewcnt');
            $races = session('races');
            $lastrace = session('lastrace');
            do {
                $race = array_shift($races);
                array_push($lastrace, $race);
                $reviewcnt--;
            }while($reviewcnt > 0);        
            session(['lastrace'=> $lastrace]);
            session(['races'=> $races]);
            session(['current'=> session('totalcnt')]);
        }
        session(['current'=> session('totalcnt')]);
        
        $totalrace = [];
        $ballot = session('ballots');
        $CandidateController = new CandidateController;
        $RaceController = new RaceController;
        $races = $RaceController->getRaceOfBallot($ballot->data[0]->ballot_id);
        foreach($races->data as $race){
            foreach(session('raceresult') as $key => $raceresult){
                if($key == $race->race_id){
                    $mergerace = array_merge((array)$race, array('candidates'=>$raceresult));
                    array_push($totalrace, $mergerace);
                }
            }
        }

        return view('client.review')->with(['ballots' => session('ballots'), 'totalrace' => $totalrace]);
    }

    public function updaterace(Request $request) {

        $raceresult = session('raceresult');
        $raceresult[$request->only('race_id')['race_id']] = $request->except('_token', 'ballot_id', 'race_id');
        session(['raceresult'=> $raceresult]);
        return response()->json(['result' => 'success']);
    }

    public function racedecount(Request $request) {

        $CandidateController = new CandidateController;

        session(['reviewcnt'=> null]);
        
        $races = session('races');
        $lastrace = session('lastrace');
        $race = array_pop($lastrace);
        array_unshift($races, $race);
        session(['lastrace'=> $lastrace]);
        session(['races'=> $races]);
        $current = session('current');
        // session(['current'=> $current-1]);
        // var_dump($current);die();
        if($current == 0){
            return  redirect()->route('client.ballot');
        }
        
        if($race == null){
            return  redirect()->route('client.prop', ['ballot_id'=>$request->ballot_id]);
        }
        $candidates = $CandidateController->getCandidateOfRace($races[0]->race_id);

        return view('client.race')->with(['ballots' => session('ballots'), 'races' => $races, 'candidates' => $candidates]);
    }

    public function prop(Request $request) {
        $props = session('props');
        session(['current'=> session('totalcnt')-1]);
        if(count(session('props')) == 0){
            return  redirect()->route('client.mass', ['ballot_id'=>$request->ballot_id]);
        }
        return view('client.prop')->with(['ballots' => session('ballots')]);
    }

    public function propcount(Request $request) {
        session(['propresult'=> $request->except('_token', 'ballot_id')]);
        $current = session('current');
        session(['current'=> $current+1]);
        return  redirect()->route('client.mass', ['ballot_id'=>$request->ballot_id]);
    }

    public function updateprops(Request $request) {
        session(['propresult'=> $request->except('_token', 'ballot_id')]);
        return response()->json(['result' => 'success']);
    }

    public function mass(Request $request) {
        session(['current'=> session('totalcnt')]);
        if(count(session('mass')) == 0){
            return  redirect()->route('client.review', ['ballot_id'=>$request->ballot_id]);
        }
        return view('client.mass')->with(['ballots' => session('ballots')]);
    }

    public function masscount(Request $request) {
        session(['massresult'=> $request->except('_token', 'ballot_id')]);
        $current = session('current');
        session(['current'=> $current+1]);
        return  redirect()->route('client.review', ['ballot_id'=>$request->ballot_id]);
    }

    public function updatemass(Request $request) {
        session(['massresult'=> $request->except('_token', 'ballot_id')]);
        return response()->json(['result' => 'success']);
    }

    public function backrace(Request $request, $id) {

        $CandidateController = new CandidateController;
        session(['current'=> $id]);
        $races = session('races');
        $lastrace = session('lastrace');
        $cnt = count(session('lastrace'));
        session(['reviewcnt'=> $cnt - $id]);
        do {
            $id++;
            $race = array_pop($lastrace);
            array_unshift($races, $race);
        } while ($id < $cnt);
        session(['lastrace'=> $lastrace]);
        session(['races'=> $races]);
        if(count($races) == 0){
            return  redirect()->route('client.ballot');
        }
        $candidates = $CandidateController->getCandidateOfRace($races[0]->race_id);

        return view('client.race')->with(['ballots' => session('ballots'), 'races' => $races, 'candidates' => $candidates]);
    }

    public function back(Request $request, $id) {
        if(count(session('mass')) != 0){
            return view('client.mass')->with(['ballots' => session('ballots')]);
        }

        if(count(session('props')) != 0){
            return view('client.prop')->with(['ballots' => session('ballots')]);
        }

        $CandidateController = new CandidateController;
        session(['current'=> $id]);
        $races = session('races');
        $lastrace = session('lastrace');
        $cnt = count(session('lastrace'));
        session(['reviewcnt'=> $cnt - $id]);
        do {
            $id++;
            $race = array_pop($lastrace);
            array_unshift($races, $race);
        } while ($id < $cnt);
        session(['lastrace'=> $lastrace]);
        session(['races'=> $races]);
        if(count($races) == 0){
            return  redirect()->route('client.ballot');
        }
        $candidates = $CandidateController->getCandidateOfRace($races[0]->race_id);

        return view('client.race')->with(['ballots' => session('ballots'), 'races' => $races, 'candidates' => $candidates]);
    }

    public function cast(Request $request) {
        $result = [];
        $data = null;
        $ballot_id = session('ballots')->data[0]->ballot_id;
        if(session('raceresult') != null && count(session('raceresult')) != 0){
            foreach(session('raceresult') as $key => $raceresult){
                if(count($raceresult) != 0){
                    foreach($raceresult as $candkey => $candidates){
                        if(strstr($candkey, "-")){
                            $data = array(
                                "ballot_id" => $ballot_id,
                                "race_id" => $key,
                                "candidate_id" => explode('-', $candkey)[0],
                                "cast_value" => $candidates,
                                "pincode" => session('pin')
                            );
                        }else{
                            $data = array(
                                "ballot_id" => $ballot_id,
                                "race_id" => $key,
                                "candidate_id" => $candkey,
                                "cast_value" => 0,
                                "pincode" => session('pin')
                            );
                        }
                        $data = json_encode($data);
                        $api = env('API').'/counter/candidate/create';
                        $Api = new ApiController;
                        $response = $Api->postApi($data, $api);
                        array_push($result, $response);
                    }
                }          
            }
        }
        if(session('propresult') != null && count(session('propresult')) != 0){
            $castyes = 0;
            $castno = 0;
            foreach(session('propresult') as $key => $propresult){
                if($propresult == 'yes' || $propresult == 'for'){
                    $castyes++;
                }else{
                    $castno++;
                }
                $data = array(
                    "ballot_id" => $ballot_id,
                    "race_id" => $key,
                    "proposition_id" => $key,
                    "cast_yes" => $castyes,
                    "cast_no" => $castno,
                    "pincode" => session('pin')
                );
                $data = json_encode($data);
                $api = env('API').'/counter/proposition/create';
                $Api = new ApiController;
                $response = $Api->postApi($data, $api);
                array_push($result, $response);
            }               
        }
        if(session('massresult') != null && count(session('massresult')) != 0){
            $castyes = 0;
            $castno = 0;
            foreach(session('massresult') as $key => $massresult){
                if($massresult == 'yes' || $massresult == 'for'){
                    $castyes++;
                }else{
                    $castno++;
                }
                $data = array(
                    "ballot_id" => $ballot_id,
                    "race_id" => $key,
                    "proposition_id" => $key,
                    "cast_yes" => $castyes,
                    "cast_no" => $castno,
                    "pincode" => session('pin')
                );
                $data = json_encode($data);
                $api = env('API').'/counter/proposition/create';
                $Api = new ApiController;
                $response = $Api->postApi($data, $api);
                array_push($result, $response);
            }               
        }
        $data = array(
            "is_used" => true,
            "keys" => array(
                "ballot_id" => $ballot_id,
                "pin" => session('pin')
            )
        );
        $data = json_encode($data);
        $api = env('API').'/pincode/update';
        $Api = new ApiController;
        $response = $Api->postApi($data, $api);

        session(['showreview'=> false]);

        return view('client.cast')->with(['ballots' => session('ballots'), 'result'=>$result]);
    }
}
