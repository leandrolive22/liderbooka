<?php

namespace App\Chats;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;
    protected $connection = 'bookchats';

    public function message() {
        return $this->hasOne('App\Chats\Message');
    }
}

