<?php

namespace App\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Correct extends Model
{
    use SoftDeletes;

    protected $connection = 'bookquiz';
    protected $table = 'correct';

    public function question() {
    	return $this->belongsToMany('App\Quiz\Question','option_id','id');
    }

    public function option() {
    	return $this->belongsToMany('App\Quiz\Option','option_id','id');
    }
}