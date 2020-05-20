<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class CountryController extends Controller {

    public function index() {
        if(Session::get('display_name')) {
            return view('country')->with(['sliderAction' => 'manage', 'subAction' => 'country']);
        } else {
            return redirect('/');
        }
    }
    
    public function getCountryOfBallot($ballot_id) {
        $Api = new ApiController;
        $api_url = env('API').'/ballot/country';
        $param = 'ballot_id='.$ballot_id;

        $response = $Api->getParamApi($api_url, $param);
        return $response;
    }
}
