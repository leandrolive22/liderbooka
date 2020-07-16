<?php

namespace App\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filial extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'filiais';
}
