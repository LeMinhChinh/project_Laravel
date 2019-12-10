<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginPost as AdminRequest;
use App\Models\Admin;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $data['messages'] = $request->session()->get('errorLogin');
        // loadView
        return view('admin.login.index',$data);
    }

    public function handleLogin(AdminRequest $request,Admin $admin)
    {
        // dd($request->all());
        $email = $request->txtEmail;
        $password = $request->txtPass;

        $infoAdmin = $admin->checkAdminLogin($email, $password);
        if($infoAdmin){
            // Success
            // vao trang Dashboard
            $request->session()->put('idSession', $infoAdmin['id']);
            $request->session()->put('userSession', $infoAdmin['username']);
            $request->session()->put('emailSession', $infoAdmin['email']);
            $request->session()->put('roleSession', $infoAdmin['role']);

            return redirect()->route('admin.dashboard');
        }else{
            // quay lai trang login
            // luu session flash thong bao loi
            $request->session()->flash('errorLogin', 'Username or Password invaild');
            return redirect()->route('admin.login');
        }
    }

    public function handleLogout(Request $request)
    {
        // Xoa session
        $request->session()->forget('idSession');
        $request->session()->forget('userSession');
        $request->session()->forget('emailSession');
        $request->session()->forget('roleSession');
        return redirect()->route('admin.login');
    }
}
