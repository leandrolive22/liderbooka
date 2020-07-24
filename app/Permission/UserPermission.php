<?php

namespace App\Permission;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPermission extends Model
{
    use SoftDeletes;
    
    protected $table = 'user_permissions';

    public function user(){
        return $this->belongsTo('App\Users\User');
    }

    public function permission(){
        return $this->belongsTo('App\Permission\Permission');
    }
}

