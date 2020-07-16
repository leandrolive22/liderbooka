<?php

namespace App\Monitoria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeedBack extends Model
{
    use softDeletes;
    protected $connection = 'feedbacks';
}
