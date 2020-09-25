<?php

namespace App\Posts;

use Illuminate\Database\Eloquent\Model;

class ReportPost extends Model
{
	protected $connection = 'bookrelatorios';
    protected $table = 'relatorio_posts';
}
