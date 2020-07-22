<?php

namespace App\Monitoria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonitoriaItem extends Model
{
	use SoftDeletes;
	
    protected $connection = 'bookmonitoria';
    protected $table = 'monitoria_itens';

    public function laudo()
    {
        return $this->belongsTo('App\Monitoria\Item', 'id_laudo_item', 'id')->withTrashed();
    }
}
