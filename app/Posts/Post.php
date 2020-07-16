<?php

namespace App\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $connection = 'bookposts';

    public function ilha(){
        return $this->belongsTo('App\Users\ilha', 'ilha_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\Users\User');
    }
}
