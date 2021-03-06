<?php

namespace App\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $connection = 'bookposts';

    public function user(){
        return $this->belongsTo('App\Users\User', 'user_id', 'id');
    }

    public function post(){
        return $this->belongsTo('App\Posts\Post', 'post_id', 'id');
    }
}
