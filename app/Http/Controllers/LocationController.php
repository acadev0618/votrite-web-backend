<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class LocationController extends Controller {
    
    public function index(Request $request) {
        if(Session::get('display_name')) {
            $CountyController = new CountyController;
            $states = $CountyController->getAllStates();

            if(empty($states->data)) {
                $counties = trim(' ');
            } else {
                $state_id = $request->old('old_state_id')==null?$states->data[0]->state_id:$request->old('old_state_id');
                $old_state_id = session::get('old_state_id');
                if(($old_state_id != null) && ($old_state_id != $state_id)) {
                    $state_id = $old_state_id;
                }

                $counties = $CountyController->getCountiesOfState($state_id);
            }

            return view('location')->with([
                'sliderAction' => 'manage', 
                'subAction' => 'location',
                'states' => $states,
                'counties' => $counties
            ]);
        } else {
            return redirect('admin/');
        }
    }

    public function createState(Request $request) {
        $data = array(
            "state_code" => $request->add_state_code
        );
        
        $data = json_encode($data);
        $api = env('API').'/location/state/create';

        $BaseController = new BaseController;
        return $BaseController->createData($data, $api);
    }

    public function updateState(Request $request) {
        $state_id = array('state_id' => $request->edit_state_id);
        $data = array(
            'state_code' => $request->edit_state_code,
            'keys' => $state_id
        );
        $data = json_encode($data);
        $api = env('API').'/location/state/update';

        $BaseController = new BaseController;
        return $BaseController->updateData($data, $api);
    }

    public function createCounty(Request $request) {
        $data = array(
            "state_id" => $request->add_state_id,
            "county_name" => $request->add_county_name
        );

        $data = json_encode($data);
        $api = env('API').'/location/county/create';

        $BaseController = new BaseController;
        return $BaseController->createData($data, $api);
    }

    public function updateCounty(Request $request) {
        $county_id = array('county_id' => $request->edit_county_id);
        $data = array(
            'county_name' => $request->edit_county_name,
            'keys' => $county_id
        );
        $data = json_encode($data);

        $api = env('API').'/location/county/update';

        $BaseController = new BaseController;
        return $BaseController->updateData($data, $api);
    }

    public function getChangedCountyOfState(Request $request) {
        $CountyController = new CountyController;
        $states = $CountyController->getAllStates();

        session(['old_state_id' => $request->state_id]);

        if(empty($states->data)) {
            $parties = trim(' ');
        } else {
            $state_id = $request->state_id;
            $counties = $CountyController->getCountiesOfState($state_id);
        }

        return view('locationTable')->with([
            'states' => $states,
            'counties' => $counties
        ]);
    }
}
