<?php

namespace App\Http\Controllers\Example;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function __construct()
    {
        // Tất cả các phương thức nằm trong controller sẽ bị middleware chi phối
        // $this->middleware('test.login');

        // Chỉ muốn middleware tác động vào 1 action nào đó
        // $this->middleware('test.login')->only('index');

        // Chỉ muốn middleware tác động vào nhiều action nào đó
        // $this->middleware('test.login')->only(['index', 'viewData']);

        // Loại trừ
        // $this->middleware('test.login')->except('demoData');
    }
    public function index()
    {
        return "This is " . __CLASS__ ;
    }

    public function viewData()
    {
        return "This is function " . __FUNCTION__;
    }

    public function demoData()
    {
        return "This is function " . __FUNCTION__;
    }
}
