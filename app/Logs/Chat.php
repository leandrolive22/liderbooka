<?php

namespace App\Logs;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $connection = 'bookrelatorios';
    protected $table = 'chat_logs';

    public function group()
    {
        return $this->belongsTo('App\Chats\Group', 'group_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Users\Users', 'user_id', 'id');
    }
}
