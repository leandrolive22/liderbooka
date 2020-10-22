<?php

namespace App\Materiais;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $connection = 'bookmateriais';
    protected $table = 'tags';

    public function material()
    {
    	return belongsTo('App\Materiais\Material');
    }
}
