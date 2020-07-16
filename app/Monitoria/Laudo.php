<?php

namespace App\Monitoria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laudo extends Model
{
    use softDeletes;
    protected $connection = 'bookmonitoria';
    protected $table = 'laudos_modelos';

    public function itens()
    {
        return $this->hasMany('App\Monitoria\Item', 'modelo_id','id')->withTrashed();
    }
}
