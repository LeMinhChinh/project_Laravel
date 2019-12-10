<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendController;

class HomeController extends FrontendController
{
    public function index(Posts $post)
    {
        $data = [];
        $lstPost = $post->getListPostByPublishDate();
        $data['paginate'] = $lstPost;

        $mailData = \json_decode(\json_encode($lstPost),true);
        $postDatas = $mailData['data'] ?? [];

        $slider = array_slice($postDatas,3,3);
        $lastest = array_slice($postDatas,4,8);
        $data['slider'] = $slider;
        $data['lastest'] = $lastest;

        return view('frontend.home.index',$data);
    }
}
