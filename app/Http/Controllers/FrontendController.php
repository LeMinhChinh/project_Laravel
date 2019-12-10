<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Categories;
use App\Models\Category;
use App\Models\Posts;
use App\Models\Tags;
use Illuminate\Support\Facades\View;

class FrontendController extends Controller
{
    public function __construct(Category $cate, Posts $post, Tags $tag, Request $request)
    {
        $listCate = $cate->getAllDataCategories();
        $treeCate = Categories::buildTreeCategory($listCate);
        $popularPost = $post->popularPost();
        $popularPost = json_decode(json_encode($popularPost),true);
        $catePost = $cate->getCountCateByPost();
        $catePost = json_decode(json_encode($catePost),true);
        // Lay tat ca bai viet vao mang
        $dataCatePost = [];
        foreach ($catePost as $key => $value) {
            $value['list_post'] = [];
            $dataCatePost[$value['id']]['id_cate'] = $value['id'];
            $dataCatePost[$value['id']]['name_cate'] = $value['name_cate'];
            $dataCatePost[$value['id']]['list_post'][$value['post_id']] = $value['post_id'];
        }

        $lstTag = $tag->getDataTagsByPost();
        $lstTag = json_decode(json_encode($lstTag),true);
        $keyword = $request->s;
        $keyword = trim($keyword);

        View::share('view', [
            'treeCate' => $treeCate,
            'listCate' => $listCate,
            'popularPost' => $popularPost,
            'catePost' => $dataCatePost,
            'lstTag' => $lstTag,
            'keyword' => $keyword
        ]);
    }
}
