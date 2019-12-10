<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    protected $table = 'post_tag';

    public function posts()
    {
        return $this->belongsTo('App\Models\Posts');
    }

    public function tags()
    {
        return $this->belongsTo('App\Models\Tags');
    }
}

