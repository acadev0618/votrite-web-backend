<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class LanguageController extends Controller {
    public function index() {
        
        if(Session::get('display_name')) {
            return view('language')->with(['sliderAction' => 'manage', 'subAction' => 'language']);
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
}
