<?php

namespace App\Permission;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $table = 'user_permissions';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;


    public function user(){
        return $this->belongsTo('App\Users\User');
    }

    public function permission(){
        return $this->belongsTo('App\Permission\Permission');
    }
}

