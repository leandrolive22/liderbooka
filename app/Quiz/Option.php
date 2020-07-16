<?php

namespace App\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use SoftDeletes;

    protected $connection = 'bookquiz';
    protected $table = 'options';

    public function option() {
    	return $this->belongsTo('App\Quiz\Question','question_id','id');
    }

    public function answer() {
    	return $this->hasOne('App\Quiz\Answer','option_id','id');
    }

    public function correct() {
    	return $this->hasMany('App\Quiz\Correct','option_id','id');
    }
}
