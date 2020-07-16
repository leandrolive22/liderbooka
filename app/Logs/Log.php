<?php

namespace App\Logs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    protected $connection = 'bookrelatorios';

    public function userData()
    {
        return $this->belongsTo('App\Users\User', 'user_id', 'id')->withTrashed();
    }

    public function ilha()
    {
        return $this->belongsTo('App\Users\Ilha', 'ilha_id', 'id');
    }

}
