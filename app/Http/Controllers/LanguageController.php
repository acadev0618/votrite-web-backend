<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class LanguageController extends Controller {

    public function index() {
        if(Session::get('display_name')) {
            $BallotController = new BallotController;
            $ballots = $BallotController->getActiveBallot();

            if(empty($ballots->data)) {
                $languages = trim(' ');
                $ballot_languages = trim(' ');
            } else {
                $languages = $this->getAllLang();
                if(empty($languages)) {
                    $ballot_languages = trim(' ');
                } else {
                    $ballot_id = $ballots->data[0]->ballot_id;
                    $ballot_languages = trim(' ');
                }
            }

            // var_dump($ballot_languages);die();

            return view('language')->with([
                'sliderAction' => 'manage', 
                'subAction' => 'language',
                'ballots' => $ballots,
                'languages' => $languages,
                'ballot_languages' => $ballot_languages
            ]);
        } else {
            return redirect('/');
        }
    }

    public function getLangOfBallot($ballot_id) {
        $Api = new ApiController;
        $api_url = env('API').'/ballot/language';
        $param = 'ballot_id='.$ballot_id;

        $response = $Api->getParamApi($api_url, $param);
        return $response;
    }

    public function getAllLang() {
        $Api = new ApiController;
        $api_url = env('API').'/language';

        $response = $Api->getApi($api_url);

        return $response;
    }

    public function getChangedLangs(Request $request) {
        $BallotController = new BallotController;
        $ballots = $BallotController->getActiveBallot();

        if(empty($ballots->data)) {
            $languages = trim(' ');
            $ballot_languages = trim(' ');
        } else {
            $languages = $this->getAllLang();
            if(empty($languages)) {
                $ballot_languages = trim(' ');
            } else {
                $ballot_id = $request->ballot_id;
                $ballot_languages = $this->getLangOfBallot($ballot_id);
            }
        }

        return view('languageTable')->with([
            'ballots' => $ballots,
            'languages' => $languages,
            'ballot_languages' => $ballot_languages
        ]);
    }

    public function setAvalBallotLang(Request $request) {
        $ballot_id = $request->ballot_id;
        $lang_id = $request->lang_id;
        $avaliable = $request->avaliable;

        $Api = new ApiController;

        if($avaliable == "true") {
            $data = array(
                'ballot_id' => $ballot_id,
                'lang_id' => $lang_id
            );
            $data = json_encode($data);
            $api = env('API').'/ballot/language/create';
            $response = $Api->postApi($data, $api);
        } else  {
            $data = array(
                'ballot_id' => $ballot_id,
                'ballot_lang_id' => $ballot_lang_id
            );
            $data = json_encode($data);
            $api = env('API').'/ballot/language/delete';
            $response = $Api->postApi($data, $api);
            $response = $Api->postApi($data, $api);
        }

        return json_encode($response);
    }
}
