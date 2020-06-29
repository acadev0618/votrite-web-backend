<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Controllers\ApiController;

class UserController extends Controller {
    
    public function index() {
        if(Session::get('display_name')) {
            $api_url = env('API').'/user';

            $controller = new ApiController;
            $response = $controller->getApi($api_url);

            return view('users')->with(['users' => $response, 'sliderAction' => 'users', 'subAction' => '']);
        } else {
            return redirect('admin/');
        }
    }

    public function createUser(Request $request) {
        $data = array(
            'user_name' => $request->user_name,
            'display_name' => $request->display_name,
            'user_email' => $request->user_email,
            'user_password' => $request->user_password,
        );

        $BaseController = new BaseController;
        $directory = "user/";
        $photo = $request->file('user_avatar');
        if($photo) {
            $photo_link = $BaseController->fileUpload($photo, $directory);
            $data += [ "user_avatar" => $photo_link ];
        }
        
        $data = json_encode($data);
        $api = env('API').'/user/create';

        $BaseController = new BaseController;
        return $BaseController->createData($data, $api);
    }

    public function updateUser(Request $request) {
        $user_id = array('user_id' => $request->user_id);
        $data = array(
            'user_name' => $request->user_name,
            'display_name' => $request->display_name,
            'user_email' => $request->user_email,
            'keys' => $user_id
        );

        $BaseController = new BaseController;
        $directory = "user/";
        $photo = $request->file('user_avatar');
        if($photo) {
            $photo_link = $BaseController->fileUpload($photo, $directory);
            $data += [ "user_avatar" => $photo_link ];
        }
        
        $data = json_encode($data);
        $api = env('API').'/user/update';

        $BaseController = new BaseController;
        return $BaseController->updateData($data, $api);
    }

    public function getOneUser(Request $request) {
        $user_id = $request->user_id;
        $Api = new ApiController;
        $api_url = env('API').'/user';
        $param = 'user_id='.$user_id;

        $party = $Api->getParamApi($api_url, $param);
        $party = json_encode($party);

        return $party;
    }
}
