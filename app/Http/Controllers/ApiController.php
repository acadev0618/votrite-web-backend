<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller {
    
    public function getApi($url) {
        $handle = curl_init();
        curl_setopt_array(
            $handle,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
            )
        );
        $output = curl_exec($handle);
        curl_close($handle);

        $response = json_decode($output);
        return $response;
    }
    
    public function getParamApi($url, $data) {
        $url = $url."?".$data;
        $handle = curl_init();
        curl_setopt_array(
            $handle,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
            )
        );
        $output = curl_exec($handle);
        curl_close($handle);

        $response = json_decode($output);
        return $response;
    }

    public function postApi($data, $url) {
        $handle = curl_init($url);

        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLINFO_HEADER_OUT, true);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );

        $output = curl_exec($handle);
        curl_close($handle);

        $response = json_decode($output);
        return $response;
    }
}
