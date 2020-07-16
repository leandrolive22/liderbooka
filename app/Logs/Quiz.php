<?php

namespace App\Logs;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $connection = 'bookrelatorios';
    protected $table = 'quiz_logs';

    public function user()
    {
        return $this->belongsTo('App\Users\User', 'user_id', 'id');
    }

    public function ilha()
    {
        return $this->belongsTo('App\Users\Ilha', 'ilha_id', 'id');
    }
}
