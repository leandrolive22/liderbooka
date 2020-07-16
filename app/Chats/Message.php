<?php

namespace App\Chats;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    protected $connection = 'bookchats';
    protected $table = 'messages';

    public function group() {
        return $this->belongsTo('App\Chats\Group');
    }

    public function user()
    {
        return $this->belongsToMany('App\Users\User', 'messages', 'speaker_id', 'interlocutor_id');
    }
}
