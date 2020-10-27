<?php

namespace App\Materiais;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $connection = 'bookmateriais';
    protected $table = 'filtros_cargos';

    public function material()
    {
    	return belongsTo('App\Materiais\Material');
    }

    public function cargo()
    {
    	return belongsTo('App\Users\Cargo');
    }
}
