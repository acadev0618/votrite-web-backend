<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class BallotController extends Controller {

    public function index() {
        if(Session::get('display_name')) {
            $response = $this->getActiveBallot();

            return view('ballot')->with(['ballots' => $response, 'sliderAction' => 'manage', 'subAction' => 'ballot']);
        } else {
            return redirect('/');
        }
    }

    public function getActiveBallot() {
        $data = "is_delete=false";
        $api_url = env('API').'/ballot';

        $Api = new ApiController;
        $response = $Api->getParamApi($api_url, $data);

        return $response;
    }

    public function createBallot(Request $request) {
        $start_date = $request->start_date.':00+00:00';
        $end_date = $request->end_date.':00+00:00';

        $data = array(
            'client' => $request->client,
            'election' => $request->election,
            'address' => $request->address,
            'board' => $request->board,
            "start_date" => $start_date,
            "end_date" => $end_date
        );
        $data = json_encode($data);
        $api = env('API').'/ballot/create';

        $BaseController = new BaseController;
        return $BaseController->createData($data, $api);
    }    

    public function updateBallot(Request $request) {
        $ballot_id = array('ballot_id' => $request->ballot_id);
        $start = $request->start_date.':00+00:00';
        $end = $request->end_date.':00+00:00';
        $data = array(
            'client' => $request->client,
            'election' => $request->election,
            'address' => $request->address,
            'board' => $request->board,
            'start_date' => $start,
            'end_date' => $end,
            'keys' => $ballot_id
        );
        $data = json_encode($data);
        $api = env('API').'/ballot/update';

        $BaseController = new BaseController;
        return $BaseController->updateData($data, $api);
    }
    
    public function deleteBallot(Request $request) {
        $ballot_id = array(
            'ballot_id' => $request->ballot_id
        );
        $data = array(
            'is_delete' => true,
            'keys' => $ballot_id
        );
        
        $json = json_encode($data);
        $api_url = env('API').'/ballot/delete';
        
        $controller = new ApiController;
        $response = $controller->postApi($json, $api_url);

        if($response->state == "success") {
            $notification = array(
                'message' => 'Successfully deleted ballot.', 
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Whoops! Something went wrong.', 
                'alert-type' => 'warning'
            );
        }
        return back()->with($notification);
    }

    public function deleteBallots(Request $request) {
        $ids = $request->ids;
        $ids = explode(',', $ids);

        for($i = 0; $i < count($ids); $i ++) {
            $ballot_id = array(
                'ballot_id' => $ids[$i]
            );
            $data = array(
                'is_delete' => true,
                'keys' => $ballot_id
            );
            
            $json = json_encode($data);
            $api_url = env('API').'/ballot/delete';
            
            $controller = new ApiController;
            $response = $controller->postApi($json, $api_url);

            if($response->state != 'success') {
                $notification = array(
                    'message' => 'Whoops! Something went wrong.', 
                    'alert-type' => 'warning'
                );
            }
        }

        $notification = array(
            'message' => 'Successfully deleted ballots.', 
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
