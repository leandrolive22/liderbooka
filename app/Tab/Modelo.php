<?php

namespace App\Tab;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modelo extends Model
{
    //use SoftDeletes;
    protected $connection = 'booktabulacao';
    protected $table = 'modelos';

    public function carteira() {
        return $this->belongsTo('App\Users\Carteira','carteira_id','id');
    }

    public function setores() {
        return $this->belongsTo('App\Users\Setor','carteira_id','id');
    }

    public function ilha() {
        return $this->belongsTo('App\Users\Ilha','ilha_id','id');
    }

    public function item()
    {
        return->$this->hasOne('App\Tab\Item','modelo_id','id');
    }
}
