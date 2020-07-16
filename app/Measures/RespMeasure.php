<?php

namespace App\Measures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RespMeasure extends Model
{
    use SoftDeletes;

    protected $connection = 'bookrelatorios';

    public function user(){
        return $this->belongsTo('App\Users\User', 'user_id', 'id');
    }

    public function measure(){
        return $this->belongsTo('App\Measures\Measure', 'measure_id', 'id');
    }

}
