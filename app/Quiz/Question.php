<?php

namespace App\Quiz;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $connection = 'bookquiz';
    protected $table = 'questions';

    public function option() {
    	return $this->hasMany('App\Quiz\Option','question_id','id');
    }

    public function quiz() {
    	return $this->belongsTo('App\Quiz\Quiz','quiz_id','id');
    }

    public function correct() {
    	return $this->hasMany('App\Quiz\Correct','option_id','id');
    }
}
