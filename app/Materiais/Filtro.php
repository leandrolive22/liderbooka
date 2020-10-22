<?php

namespace App\Materiais;

use Illuminate\Database\Eloquent\Model;

class Filtro extends Model
{
    protected $connection = 'bookmateriais';
    protected $table = 'filtros_materiais';

    public function material()
    {
    	return belongsTo('App\Materiais\Material');
    }

    public function ilha()
    {
    	return belongsTo('App\Users\Ilha');
    }

    public function cargo()
    {
    	return belongsTo('App\Users\Cargo');
    }
}
