<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class PartyController extends Controller {
    public function index() {
        if(Session::get('display_name')) {
            return view('party')->with(['sliderAction' => 'manage', 'subAction' => 'party']);
        } else {
            return redirect('/');
        }
    }
}
