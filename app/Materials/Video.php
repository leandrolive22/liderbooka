<?php

namespace App\Materials;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;

    protected $connection = 'bookmateriais';
    protected $table = 'videos';

    public function ilha(){
        return $this->belongsTo('App\Users\Ilha', 'ilha_id', 'id');
    }

    public function subLocal(){
        return $this->belongsTo('App\Materials\SubLocal', 'sub_local_id', 'id');
    }

    public function setor(){
        return $this->belongsTo('App\Users\Setor', 'sector', 'id');
    }

    public function user(){
        return $this->belongsTo('App\Users\User', 'user_id', 'id');
    }

    public function materialLog(){
        return $this->hasMany('App\Logs\MaterialLogs', 'video_id', 'id');
    }
}
