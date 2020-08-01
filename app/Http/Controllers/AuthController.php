<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class AuthController extends Controller {
    public function login() {
        if(Session::get('display_name')) {
            return redirect('/dashboard');
        } else {
            return view('auth.login');
        }
    }

    public function forgotPassword() {
        return view('auth.forgotPassword');
    }

    public function loginApi(Request $request) {
        $data = array(
            'user_email' => $request->user_email,
            'user_password' =>  $request->user_password
        );
        $json = json_encode($data);

        $handle = curl_init();
        $url = env('API').'/user/login';
        curl_setopt_array(
            $handle,
            array(
                CURLOPT_URL => $url,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $json,
                CURLOPT_RETURNTRANSFER => true,
            )
        );
        $output = curl_exec($handle);
        curl_close($handle);

        $response = json_decode($output);

        if(count((array)$response) == 0) {
            $message = "This user doesn't match with our record. Try again!";
            return back()->with('warning', $message);
        } else {
            $data = array(
                'display_name' => $response->data[0]->display_name,
                'user_avatar' => $response->data[0]->user_avatar,
                'user_id' => $response->data[0]->user_id
            );

            Session::put([
                'display_name' => $data['display_name'], 
                'avatar' => $data['user_avatar'], 
                'user_id' => $data['user_id']
            ]);
            $message = 'Welcome to '.$data['display_name'].' !';
            return redirect('/dashboard')->with(['message' => $message, 'data' => $data]);
        }
    }

    public function logout() {
        session()->forget('display_name', 'avatar', 'user_id');
        session()->flush();
        return redirect('admin/');
    }

    public function profile(Request $request, $id){

        return view('auth.profile')->with(['sliderAction' => 'dashboard', 'subAction' => '', 'userid' => $id]);
    }

    public function changepwd(Request $request, $id){

        return view('auth.changepwd')->with(['sliderAction' => 'dashboard', 'subAction' => '', 'userid' => $id]);
    }
}
