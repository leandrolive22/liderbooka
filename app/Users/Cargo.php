<?php

namespace App\Users;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Cargo extends Model
{
    protected $connection = 'mysql';
    
    public function user() {
        return $this->hasOne('App\Users\User','cargo_id','id');
    }
}
