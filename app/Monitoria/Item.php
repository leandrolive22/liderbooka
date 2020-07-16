<?php

namespace App\Monitoria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use softDeletes;
    protected $connection = 'bookmonitoria';
    protected $table = 'laudos_itens';

    public function laudo()
    {
        return $this->belongsToMany('App\Monitoria\Laudo', 'modelo_id','id')->withTrashed();
    }

    public function item()
    {
        return $this->hasMany('App\Monitoria\MonitoriaItem', 'id_laudo_item', 'id')->withTrashed();
    }
}
