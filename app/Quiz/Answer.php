<?php

namespace App\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use SoftDeletes;

    protected $connection = 'bookquiz';
    protected $table = 'answers';

    public function question() {
    	return $this->belongsTo('App\Quiz\Question','option_id','id');
    }

}
