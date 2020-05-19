<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class CandidateController extends Controller {
    public function index() {
        if(Session::get('display_name')) {
            return view('candidate')->with(['sliderAction' => 'manage', 'subAction' => 'candidate']);
        } else {
            return redirect('/');
        }
    }
}
