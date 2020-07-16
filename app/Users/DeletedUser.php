<?php

namespace App\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeletedUser extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'deleted_users';
}
