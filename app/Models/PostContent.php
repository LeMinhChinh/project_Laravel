<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostContent extends Model
{
    protected $table = 'post_content';

    public function posts()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function insertDataContentPost($data)
    {
        $insert = DB::table('post_content')->insert($data);
        if($insert){
            return true;
        }else{
            return false;
        }
    }
    public function updateDataContentPostById($data, $id)
    {
        $up = DB::table('post_content')
                    ->where('post_id', $id)
                    ->update($data);
        return $up;
    }
}
