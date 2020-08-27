<?php

namespace App\MOnitoria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contestacao extends Model
{
    use SoftDeletes;
    protected $connection = 'bookmonitoria';
    protected $table = 'contestacoes';

    public function motivo()
    {
    	return $this->belongsTo('App\Monitoria\MotivoContestar', 'motivo_id');
    }

    public function monitoria()
    {
    	return $this->belongsTo('App\Monitoria\Monitoria', 'monitoria_id');
    }
}
