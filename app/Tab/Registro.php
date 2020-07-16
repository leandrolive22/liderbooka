<?php

namespace App\Tab;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registro extends Model
{
    //use SoftDeletes;
    protected $connection = 'booktabulacao';
    protected $table = 'registros';

    public function modelo() {
        return $this->belongsTo('App\Tab\Modelo','modelo_id','id');
    }

    public function tabulacao() {
        return $this->belongsTo('App\Tab\tabulacao','tabulacao_id');
    }
}
