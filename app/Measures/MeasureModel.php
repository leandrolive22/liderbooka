<?php

namespace App\Measures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeasureModel extends Model
{
    use SoftDeletes;

    protected $connection = 'bookrelatorios';
    protected $table = 'measures_models';

    public function user(){
        return $this->belongsTo('App\Users\User', 'user_id', 'id');
    }
}
