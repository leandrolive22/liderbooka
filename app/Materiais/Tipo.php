<?php

namespace App\Materiais;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $connection = 'bookmateriais';
    protected $table = 'tipos_materiais';

    public function materiais()
    {
    	return $this->hasMany('App\Materiais\Material','tipo_id');
    }
}
