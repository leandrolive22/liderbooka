<?php

namespace App\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use SoftDeletes;

    protected $connection = 'bookquiz';
    protected $table = 'quizzes';

    public function user()
    {
        return $this->belongsTo('App\Users\User', 'creator_id', 'id');
    }

    public function question()
    {
        return $this->hasMany('App\Quiz\Question', 'quiz_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany('App\Logs\Log', 'value', 'id');
    }
}
