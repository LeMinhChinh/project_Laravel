<?php

namespace App\Http\Controllers\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use \Firebase\JWT\JWT;

class DemoController extends Controller
{
    const API_KEY = 'lphp1903e';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \response()->json([
            'name' => 'LMC',
            'age' => 20
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return \response()->json([
            'id' => 1,
            'money' => 123
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return \response()->json([
            'id' => $id,
            'info' => [
                'name' => 'Lmc',
                'age' => 20
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $arrData = \json_decode(json_encode($data),true);

        return \response()->json([
            'id' => $id,
            'info' => $arrData
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $token = $request->header('Authorization');
        $decode = JWT::decode($token, self::API_KEY, array('HS256'));
        // return response()->json($decode);
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
    }
}
