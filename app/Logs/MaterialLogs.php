<?php

namespace App\Logs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialLogs extends Model
{
    protected $connection = 'bookrelatorios';

    public function user()
    {
        return $this->belongsTo('App\Users\User', 'user_id','id');
    }

    public function ilha()
    {
        return $this->belongsTo('App\Users\Ilha', 'ilha_id','id');
    }

    public function roteiro()
    {
        return $this->belongsTo('App\Materiais\Roteiro', 'roteiro_id','id');
    }

    public function circular()
    {
        return $this->belongsTo('App\Materiais\Circular', 'circular_id','id');
    }

    public function calculadora()
    {
        return $this->belongsTo('App\Materiais\Calculadora', 'calculadora_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo('App\Posts\Post', 'post_id', 'id');
    }
}
