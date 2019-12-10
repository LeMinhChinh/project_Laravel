<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Posts extends Model
{
    protected $table = 'posts';

    public function categories()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function post_tag()
    {
        return $this->hasMany('App\Models\PostTag');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tags');
    }

    public function post_content()
    {
        return $this->hasOne('App\Models\PostContent');
    }

    public function insertDataPost($data)
    {
        DB::table('posts')->insert($data);
        $id = DB::getPdo()->lastInsertId();
        return $id;
    }

    public function getAllDataPosts()
    {
        $data = DB::table('posts as p')
                        ->select('p.*','c.name_cate','a.fullname')
                        ->join('categories AS c','p.categories_id','=','c.id')
                        ->join('admins AS a','p.admins_id','=','a.id')
                        ->paginate(5);
        return $data;
    }

    public function deletePostById($id)
    {
        $del = DB::table('posts')
                    ->where('id', $id)
                    ->delete();
        return $del;
    }

    public function getInforDataPostById($id)
    {
        $data = DB::table('posts AS p')
                    ->select('p.*','pc.content_web')
                    ->join('post_content AS pc','pc.post_id','=','p.id')
                    ->where('p.id',$id)
                    ->first();
        $data = json_decode(json_encode($data),true);
        return $data;
    }

    public function updateDataPost($data, $id)
    {
        $up = DB::table('posts')
                    ->where('id', $id)
                    ->update($data);
        return $up;
    }

    public function getListPostByPublishDate()
    {
        $today = date('Y-m-d H:i:s');

        $data = DB::table('posts AS p')
                    ->select('p.*','c.name_cate','ad.fullname')
                    ->join('categories AS c','c.id','=','p.categories_id')
                    ->join('admins AS ad','ad.id','=','p.admins_id')
                    ->where('p.publish_date','<=',$today)
                    ->where('p.status',1)
                    ->orderBy('p.publish_date','DESC')
                    ->paginate(11);
        return $data;
    }

    public function popularPost()
    {
        $today = date('Y-m-d H:i:s');

        $data = DB::table('posts AS p')
                    ->select('p.*')
                    ->where('p.publish_date','<=',$today)
                    ->orwhere('p.status',1)
                    ->orderBy('p.count_view','DESC')
                    ->limit(3)
                    ->get();
        return $data;
    }

    public function getDataPostBySlug($slug)
    {
        $today = date('Y-m-d H:i:s');
        $data = DB::table('posts AS p')
                    ->select('p.*','pc.content_web','c.name_cate','a.fullname')
                    ->join('post_content AS pc','pc.post_id','=','p.id')
                    ->join('categories AS c','c.id','=','p.categories_id')
                    ->join('admins AS a','a.id','=','p.admins_id')
                    ->where('p.publish_date','<=',$today)
                    ->where('p.status',1)
                    ->where('p.slug',$slug)
                    ->first();
        return $data;
    }

    public function getDataPostByCateId($cateId, $postId)
    {
        $today = date('Y-m-d H:i:s');
        $data = DB::table('posts AS p')
                    ->select('p.*','c.name_cate','a.fullname')
                    ->join('categories AS c','c.id','=','p.categories_id')
                    ->join('admins AS a','a.id','=','p.admins_id')
                    ->where('p.publish_date','<=',$today)
                    ->where('p.status',1)
                    ->where('p.categories_id',$cateId)
                    ->where('p.id','<>',$postId)
                    ->limit(3)
                    ->get();
        $data = json_decode(json_encode($data),true);
        // dd($data);
        return $data;
    }

    public function updateCountView($id, $view)
    {
        $count =  $view + 1;
        $up = DB::table('posts AS p')
                ->where('p.id',$id)
                ->update(['p.count_view' => $count]);
        return $up;
    }

    public function searchDataPostByKey($keyword)
    {
        $today = date('Y-m-d H:i:s');
        $data = DB::table('posts AS p')
                    ->select('p.*','c.name_cate','a.fullname')
                    ->join('categories AS c','c.id','=','p.categories_id')
                    ->join('admins AS a','a.id','=','p.admins_id')
                    ->where(function($query) use ($keyword){
                        $query->where('p.title','LIKE','%'.$keyword.'%')
                              ->orwhere('p.sapo','LIKE','%'.$keyword.'%')
                              ->orwhere('p.slug','LIKE','%'.$keyword.'%');
                    })
                    ->where('p.publish_date','<=',$today)
                    ->where('p.status',1)
                    ->orderBy('p.publish_date','DESC')
                    ->paginate(8);
        return $data;
    }
}
