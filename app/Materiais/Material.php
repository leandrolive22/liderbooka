<?php

namespace App\Materiais;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $connection = 'bookmateriais';
    protected $table = 'materiais_apoio';

    public function tipo()
    {
    	return belongsTo('App\Materiais\Tipo','tipo_id');
    }

    public function user()
    {
    	return belongsTo('App\Users\User');
    }

    public function ilhas()
    {
    	return $this->hasMany('App\Materiais\Ilha');
    }

    public function cargos()
    {
        return $this->hasMany('App\Materiais\Cargo');
    }

    public function tags()
    {
    	return $this->hasMany('App\Materiais\Tag');
    }
}
