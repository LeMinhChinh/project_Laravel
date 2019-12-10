<?php

namespace App\Http\Controllers\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Firebase\JWT\JWT;
use App\Models\Admin;

class CreateTokenController extends Controller
{
    const API_KEY = 'lphp1903e';

    public function index()
    {
        //du lieu can ma hoa
        $token = array(
            "iss" => "php",
            "aud" => "lmc",
            "iat" => 1356999524, //thoi gian song cua token
            "nbf" => 1357000000
        );
        //ma hoa
        return JWT::encode($token, self::API_KEY);
    }
    public function decodeToken($token, $id)
    {
        $token = $request->header('Authorization');
        $decode = JWT::decode($token, self::API_KEY, array('HS256'));
        if($decode){
            $del = Admin::deleteDataByID($id);
            if($del){
                return \response()->json([
                    'mess' => 'success'
                ]);
            }else{
                return \response()->json([
                    'mess' => 'fail'
                ]);
            }
        }else{
            return response()->json([
                'mess' => 'token invalid'
            ]);
        }
    }
}
