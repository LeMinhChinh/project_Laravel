<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Http\Controllers\FrontendController;

class SeachController extends FrontendController
{
    public function index(Request $request, Posts $post)
    {
        $keyword = $request->s;
        $keyword = trim($keyword);
        $data = [];

        $dataSearch = $post->searchDataPostByKey($keyword);
        $data['paginate'] = $dataSearch;

        $dataSearch = json_decode(json_encode($dataSearch),true);
        $listData = $dataSearch['data'] ?? [];
        $data['listData'] = $listData;
        $data['keyword'] = $keyword;

        return view('frontend.search.index',$data);
    }

    public function ajaxSearch(Request $request, Posts $post)
    {
        if($request->ajax()){
            $keyword = $request->key;
            $dataSearch = $post->searchDataPostByKey($keyword);
            $dataSearch = json_decode(json_encode($dataSearch),true);
            $listData = $dataSearch['data'] ?? [];
            $data['listData'] = $listData;

            return view('frontend.search.ajax',$data);
        }
    }
}
