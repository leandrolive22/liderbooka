<?php

namespace App\Monitoria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MotivoContestar extends Model
{
	use SoftDeletes;
    protected $connection = 'bookmonitoria';
    protected $table = 'motivos_contestar';

    public function creator()
    {
    	return $this->belongsTo('App\User','creator_id');
    }

    public function contestacao()
    {
    	return $this->hasMany('App\Monitoria\Contestacao', 'motivo_id');
    }
}
