<?php

namespace App\Materials;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Circular extends Model
{
    use SoftDeletes;
    
    protected $connection = 'bookmateriais';
    protected $table = 'circulares';

    public function ilha(){
        return $this->belongsTo('App\Users\Ilha', 'ilha_id', 'id');
    }

    public function setor(){
        return $this->belongsTo('App\Users\Setor', 'setor_id', 'id');
    }

    public function subLocal(){
        return $this->belongsTo('App\Materials\SubLocal', 'segment', 'id');
    }

    public function materialLog(){
        return $this->hasMany('App\Logs\MaterialLogs', 'circular_id', 'id');
    }
}
