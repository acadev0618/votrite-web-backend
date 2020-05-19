<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class PropositionController extends Controller {
    public function index() {
        if(Session::get('display_name')) {
            return view('proposition')->with(['sliderAction' => 'manage', 'subAction' => 'proposition']);
        } else {
            return redirect('/');
        }
    }
}
