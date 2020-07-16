<?php

namespace App\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carteira extends Model
{
    //use SoftDeletes;
    protected $connection = 'mysql';

    public function carteira() {
        return $this->hasOne('App\Users\Carteira','carteira_id','id');
    }

    public function user() {
        return $this->hasOne('App\Users\Users','carteira_id','id');
    }

    public function setores() {
        return $this->hasOne('App\Users\Setor','carteira_id','id');
    }
}
