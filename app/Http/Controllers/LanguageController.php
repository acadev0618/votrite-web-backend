<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class LanguageController extends Controller {

    public function index(Request $request) {
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
                    $ballot_id = $request->old('ballot_id')==null?$ballots->data[0]->ballot_id:$request->old('ballot_id');
                    $old_lang_ballot_id = session::get('old_lang_ballot_id');
                    if(($old_lang_ballot_id != null) && ($old_lang_ballot_id != $ballot_id)) {
                        $ballot_id = $old_lang_ballot_id;
                    }
                    $ballot_languages = $this->getLangOfBallot($ballot_id);
                }
            }

            return view('language')->with([
                'sliderAction' => 'manage', 
                'subAction' => 'language',
                'ballots' => $ballots,
                'languages' => $languages,
                'ballot_languages' => $ballot_languages
            ]);
        } else {
            return redirect('admin/');
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

        session(['old_lang_ballot_id' => $request->ballot_id]);

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

        $data = array(
            'ballot_id' => $ballot_id,
            'lang_id' => $lang_id
        );
        $data = json_encode($data);

        if($avaliable == "true") {
            $api = env('API').'/ballot/language/create';
            $response = $Api->postApi($data, $api);
        } else if($avaliable == "false") {
            $api = env('API').'/ballot/language/delete';
            $response = $Api->postApi($data, $api);
        }

        return json_encode($response);
    }

    public function saveAllLang(Request $request) {
        $ballot_id = $request->ballot_id;
        $ids = $request->ids;

        $avaliable = $request->avaliable;
        if($avaliable == "false") {
            $response = $this->deleteAll($ballot_id);
            return $response;
        } else if($avaliable == "true") {
            $response = $this->saveAll($ballot_id, $ids);
            return $response;
        }
    }

    public function saveAll($ballot_id, $ids) {
        $ids = explode(',', $ids);
        $ballot_langs = $this->getLangOfBallot($ballot_id);
        if(empty($ballot_langs->data)) {
            for($i = 0; $i < count($ids); $i ++) {
                $data = array(
                    'ballot_id' => $ballot_id,
                    'lang_id' => $ids[$i]
                );
                $json = json_encode($data);
                $api_url = env('API').'/ballot/language/create';
                
                $controller = new ApiController;
                $response = $controller->postApi($json, $api_url);
            }
            return json_encode($response);
        } else if(count($ids) == count($ballot_langs->data)){
            $response = array(
                'state' => "success",
                'message'=> "-2"
            );
            return json_encode($response);
        } else {
            $selected = [];
            for($i = 0; $i < count($ids); $i ++) {
                $flag = 0;
                for($j = 0; $j < count($ballot_langs->data); $j ++) {
                    if($ids[$i] == $ballot_langs->data[$j]->lang_id) {
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
                    'lang_id' => $selected[$k]
                );
                $json = json_encode($data);
                $api_url = env('API').'/ballot/language/create';
                
                $controller = new ApiController;
                $response = $controller->postApi($json, $api_url);
            }
            return json_encode($response);
        } 
    }

    public function deleteAll($ballot_id) {
        $ballot_langs = $this->getLangOfBallot($ballot_id);

        if(empty($ballot_langs->data)) {
            $response = array(
                'state' => "success",
                'message'=> "-1"
            );
            return json_encode($response);
        } else {
            $ids = [];
            for($i = 0; $i < count($ballot_langs->data); $i ++) {
                array_push($ids, $ballot_langs->data[$i]->lang_id);
            }

            for($i = 0; $i < count($ids); $i ++) {
                $data = array(
                    'ballot_id' => $ballot_id,
                    'lang_id' => $ids[$i]
                );
                $json = json_encode($data);
                $api_url = env('API').'/ballot/language/delete';
                
                $controller = new ApiController;
                $response = $controller->postApi($json, $api_url);
            }
            return json_encode($response);
        }
    }
}
