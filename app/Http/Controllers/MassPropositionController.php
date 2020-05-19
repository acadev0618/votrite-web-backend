<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class MassPropositionController extends Controller {
    public function index() {
        if(Session::get('display_name')) {
            return view('mass_proposition')->with(['sliderAction' => 'manage', 'subAction' => 'mass_proposition']);
        } else {
            return redirect('/');
        }
    }
}
