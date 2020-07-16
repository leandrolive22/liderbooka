<?php

namespace App\Monitoria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Monitoria extends Model
{
    use softDeletes;
    protected $connection = 'bookmonitoria';
    protected $table = 'monitorias';

    public function ilha()
    {
        return $this->belongsTo('App\Users\Ilha', 'produto', 'id')->withTrashed();
    }

    public function operador()
    {
        return $this->belongsTo('App\Users\User', 'operador_id', 'id')->withTrashed();
    } 
    
    public function supervisor()
    {
        return $this->belongsTo('App\Users\User', 'supervisor_id', 'id')->withTrashed();
    }
    
    public function monitor()
    {
        return $this->belongsTo('App\Users\User', 'monitor_id', 'id')->withTrashed();
    }

    public function itens()
    {
        return $this->hasMany('App\Monitoria\MonitoriaItem', 'monitoria_id', 'id')->withTrashed();
    }
}
