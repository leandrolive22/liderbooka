<?php

namespace App\Materiais;

use Illuminate\Database\Eloquent\Model;

class Ilha extends Model
{
    protected $connection = 'bookmateriais';
    protected $table = 'filtros_ilhas';

    public function material()
    {
    	return belongsTo('App\Materiais\Material');
    }

    public function ilha()
    {
    	return belongsTo('App\Users\Ilha');
    }
}
