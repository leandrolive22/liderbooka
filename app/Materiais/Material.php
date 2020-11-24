<?php

namespace App\Materiais;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Material extends Model
{
    use SoftDeletes;

    protected $connection = 'bookmateriais';
    protected $table = 'materiais_apoio';

    public function tipo()
    {
    	return $this->belongsTo('App\Materiais\Tipo','tipo_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\Users\User');
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

    public function logs()
    {
    	return $this->hasMany('App\Logs\MaterialLogs','id_material');
    }
}
