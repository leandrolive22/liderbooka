<?php

namespace App\Users;

use Illuminate\Database\Eloquent\Model;

class Superior extends Model
{
    protected $connection = 'mysql';
	protected $table = 'superiors';
    
    public function user()
    {
        return $this->belongsToMany('App\Users\User', 'user_id', 'id');
    }

    public function superior()
    {
        return $this->belongsToMany('App\Users\User', 'superior_id', 'id');
    }
}
