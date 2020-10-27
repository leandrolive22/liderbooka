<?php

namespace App\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ilha extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';

    public function user() {
        return $this->hasOne('App\Users\User','ilha_id','id');
    }

    public function post() {
        return $this->hasOne('App\Posts\post','post_id','id');
    }

    public function setor() {
        return $this->belongsTo('App\Users\Setor','setor_id','id');
    }

    public function filtroMateriais()
    {
        return hasMany('App\Materiais\Ilha');
    }
}
