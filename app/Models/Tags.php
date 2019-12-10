<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tags extends Model
{
    protected $table = 'tags';

    public function post_tag()
    {
        return $this->hasMany('App\Models\PostTag');
    }

    public function posts()
    {
        return $this->belongsToMany('App\Models\Posts');
    }

    public function getAllDataTags()
    {
        $data = [];
        $tags = Tags::all();
        if($tags){
            $data = $tags->toArray();
        }
        return $data;
    }

    public function getDataTagsByPost()
    {
        $data = DB::table('tags AS t')
                    ->select('t.*','pt.post_id as post_id')
                    ->join('post_tag AS pt','t.id','=','pt.tag_id')
                    ->get();
        $data = json_decode(json_encode($data),true);
        return $data;
    }

    public function getDataTagsByIdPost($id)
    {
        $data = DB::table('tags AS t')
                    ->select('t.*','pt.post_id')
                    ->join('post_tag AS pt','t.id','=','pt.tag_id')
                    ->where('pt.post_id',$id)
                    ->get();
        $data = json_decode(json_encode($data),true);
        return $data;
    }
}
