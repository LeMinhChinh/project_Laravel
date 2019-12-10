<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $table = 'Categories';

    // Tao 1 ham dinh nghia mqh voi table Post
    public function posts()
    {
        return $this->hasMany('App\Models\Posts');
    }

    public function getAllDataCategories()
    {
        $data = [];
        $cate = Category::all();
        if($cate){
            $data = $cate->toArray();
        }
        return $data;
    }

    public function getCountCateByPost()
    {
        // Lay 5 bai viet co view nhieu nhat
        $data = DB::table('categories as c')
                    ->select('c.*','p.id as post_id')
                    ->join('posts as p','p.categories_id','=','c.id')
                    ->get();
        return $data;
    }

    public function getDataCatePaginate($id)
    {
        $today = date('Y-m-d H:i:s');
        $data = DB::table('posts AS p')
                    ->select('c.*','p.title','p.id AS post_id','p.slug','a.fullname','p.count_view','p.avatar','p.publish_date')
                    ->join('categories AS c','c.id','=','p.categories_id')
                    ->join('admins AS a','a.id','=','p.admins_id')
                    ->where('p.categories_id', $id)
                    ->where('p.publish_date','<=',$today)
                    ->where('p.status',1)
                    ->paginate(8);
        return $data;
    }
}
