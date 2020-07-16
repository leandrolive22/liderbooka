<?php

namespace App\Measures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Measure extends Model
{
    use SoftDeletes;

    protected $connection = 'bookrelatorios';

    public function creator(){
        return $this->belongsTo('App\Users\User', 'creator_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\Users\User', 'creator_id', 'id');
    }

    public function resp(){
        return $this->hasOne('App\Measures\RespMeasure', 'measure_id', 'id');
    }

}