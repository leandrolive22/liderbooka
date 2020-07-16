<?php

namespace App\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setor extends Model
{
    //use SoftDeletes;
    protected $connection = 'mysql';
    
    protected $table = 'setores';
    
    public function setores() {
        return $this->hasOne('App\Users\Carteira','setor_id','id');
    }
}
