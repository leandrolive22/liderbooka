<?php

namespace App\Tab;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tabulacao extends Model
{
    //use SoftDeletes;
    protected $connection = 'booktabulacao';
    protected $table = 'tabulacoes';

    public function modelo() {
        return $this->belongsTo('App\Tab\Modelo','modelo_id','id');
    }

    public function user() {
        return $this->belongsTo('App\User\User');
    }

    public function supervisor() {
        return $this->belongsTo('App\User\User','supervisor_id');
    }

    public function registro() {
        return $this->hasMany('App\Tab\Registro','tabulacao_id');
    }
}
