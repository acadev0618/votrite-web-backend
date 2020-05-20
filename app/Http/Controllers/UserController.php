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

            return view('users')->with(['users' => $response->data, 'sliderAction' => 'users', 'subAction' => '']);
        } else {
            return redirect('/');
        }
    }

    public function createUser(Request $request) {
        $data = array(
            'user_name' => $request->user_name,
            'display_name' => $request->display_name,
            'user_email' => $request->user_email,
            'user_password' => $request->user_password,
            "user_avatar" => "https://cdn.vuetifyjs.com/images/lists/1.jpg"
        );
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
            'user_password' => $request->user_password,
            'user_avatar' => $request->user_avatar,
            'keys' => $user_id
        );
        $data = json_encode($data);
        $api = env('API').'/user/update';

        $BaseController = new BaseController;
        return $BaseController->updateData($data, $api);
    }
}
