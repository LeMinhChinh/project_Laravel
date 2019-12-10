<?php

namespace App\Http\Controllers\Example;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    public function index()
    {
        return "This is Group " . __CLASS__;
    }

    public function demo($idPd, $myAge, $money, $add = null, Request $request)
    {
        // $myMoney = $request->money;
        // $t = $request->t;
        // $t = $request->input('t','abc');
        $t = $request->query('id');
        // $u = $request->u;
        $u = $request->input('u','ABC');
        $all = $request->all();
        dd($idPd, $myAge, $add, $money,$t, $u, $all);
    }

    public function login()
    {
        return view('test_login');
    }

    public function handleLogin(Request $request)
    {
        // $data = $request->all();
        $user = $request->input('username'); //$_POST['user']
        // $user = $request->username;

        $pass = $request->input('password');

        // $pass = $request->password;
        dd($user, $pass);
    }
}
