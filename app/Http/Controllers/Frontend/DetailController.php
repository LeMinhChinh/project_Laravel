<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Posts;
use App\Models\Tags;
use App\Http\Controllers\FrontendController;

class DetailController extends FrontendController
{
    public function index($slug, Request $request,Posts $post,Tags $tag)
    {
        $infoPost = $post->getDataPostBySlug($slug);
        $infoPost = \json_decode(json_encode($infoPost),true);


        if($infoPost){
            $lstPTags = $tag->getDataTagsByIdPost($infoPost['id']);
            $lstPost = $post->getDataPostByCateId($infoPost['categories_id'], $infoPost['id']);
            $data = [];
            $data['info'] = $infoPost;
            $data['lstTags'] = $lstPTags;
            $data['related'] = $lstPost;

            return view('frontend.blog.detail',$data);
        }else{
            abort(404);
        }
    }

    public function updateCountView(Request $request,Posts $post)
    {
        $idPost = $request->id;
        $idPost = is_numeric($idPost) && $idPost > 0 ? $idPost : 0;
        $infoPost = $post->getInforDataPostById($idPost);
        // Lay ra luot view truoc khi update -> +1
        if($infoPost){
            $view = $infoPost['count_view'];
            $up = $post->updateCountView($idPost, $view);
            if($up){
                echo "OK";
            }else{
                echo "ERR";
            }
        }
    }
}
