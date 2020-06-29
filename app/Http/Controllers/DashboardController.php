<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class DashboardController extends Controller {
    
    public function index() {
        if(Session::get('display_name')) {

            $BallotController = new BallotController;
            $response = $BallotController->getActiveBallot();

            return view('dashboard')->with(
            	['ballots' => $response, 
            	'sliderAction' => 'dashboard', 
            	'subAction' => '']
            );
        } else {
            return redirect('admin/');
        }
    }
}
