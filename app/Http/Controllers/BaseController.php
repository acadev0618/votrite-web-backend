<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller {

    public function deleteData(Request $request) {
        $api_url = $request->api;
        $target_id = $request->target_id;
        $id = $request->id;

        $data = array(
            $target_id => $id
        );
        $json = json_encode($data);

        $controller = new ApiController;
        $response = $controller->postApi($json, $api_url);

        if($response->state == "success") {
            $notification = array(
                'message' => 'Successfully deleted data.', 
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Whoops! Something went wrong.', 
                'alert-type' => 'error'
            );
        }
        return back()->with($notification);
    }

    public function mutiDeleteData(Request $request) {
        $target_id = $request->target_id;
        $ids = $request->ids;
        $ids = explode(',', $ids);

        for($i = 0; $i < count($ids); $i ++) {
            $data = array(
                $target_id => $ids[$i]
            );
            
            $json = json_encode($data);
            $api_url = $request->api;
            
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
            'message' => 'Successfully deleted data.', 
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

    public function pinDeleteData(Request $request) {
        $ballot_id = $request->ballot_id;
        $target_id = $request->target_id;
        $ids = $request->ids;
        $ids = explode(',', $ids);

        for($i = 0; $i < count($ids); $i ++) {
            $data = array(
                'ballot_id' => $ballot_id,
                $target_id => $ids[$i]
            );
            
            $json = json_encode($data);
            $api_url = $request->api;
            
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
            'message' => 'Successfully deleted data.', 
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

    public function createData($request, $api_url) {
        $Api = new ApiController;
        $response = $Api->postApi($request, $api_url);
        $ballotid = null;
        $request = json_decode($request, true);
        // dd($request);
        if(isset($request['ballot_id'])){
            $ballotid = $request['ballot_id'];
        }

        // var_dump($response);die();

        if($response->state == "success") {
            $notification = array(
                'message' => 'Successfully added data.', 
                'alert-type' => 'success',
                'ballot_id' => $ballotid
            );
        } else {
            $notification = array(
                'message' => 'Something went wrong! Try again.', 
                'alert-type' => 'error',
                'ballot_id' => $ballotid
            );
        }
        return back()->withInput($notification);
    }

    public function updateData($request, $api_url) {
        $Api = new ApiController;
        $response = $Api->postApi($request, $api_url);
        

        if($response->state == "success") {
            $notification = array(
                'message' => 'Successfully updated data.', 
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Whoops! Something went wrong.', 
                'alert-type' => 'error'
            );
        }
        return back()->with($notification);
    }

    public function fileUpload($photo, $directory) {
        $photo_name = $photo->getClientOriginalName();
        $photo->move(public_path('/uploads/'.$directory), $photo_name);
        $photo_link = (env('APP_URL').'/uploads/'.$directory).$photo_name;

        return $photo_link;
    }
}
