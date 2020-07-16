<?php

namespace App\Monitoria;

use Illuminate\Database\Eloquent\Model;

class MonitoriaItem extends Model
{
    protected $connection = 'bookmonitoria';
    protected $table = 'monitoria_itens';

    public function laudo()
    {
        return $this->belongsTo('App\Monitoria\Item', 'id_laudo_item', 'id')->withTrashed();
    }
}
