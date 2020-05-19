<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class VoterController extends Controller {
    public function index() {
        if(Session::get('display_name')) {
            return view('voter')->with(['sliderAction' => 'manage', 'subAction' => 'voter']);
        } else {
            return redirect('/');
        }
    }
}
