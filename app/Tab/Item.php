<?php

namespace App\Tab;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    //use SoftDeletes;
    protected $connection = 'booktabulacao';
    protected $table = 'modelo_itens';

    public function modelo() {
        return $this->belongsTo('App\Tab\Modelo','modelo_id','id');
    }
}
