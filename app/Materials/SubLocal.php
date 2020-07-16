<?php

namespace App\Materials;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubLocal extends Model
{
    use SoftDeletes;

    protected $table = 'sub_locais';
    protected $connection = 'bookmateriais';

    public function ilha(){
        return $this->belongsTo('App\Users\Ilha', 'ilha_id', 'id');
    }

    public function material()
    {
        return $this->hasMany('App\Materials\Material', 'sub_local_id', 'id');
    }

    public function video()
    {
        return $this->hasMany('App\Materials\Video', 'sub_local_id', 'id');
    }

    public function telefone()
    {
        return $this->hasMany('App\Materials\Telefone', 'sub_local_id', 'id');
    }

    public function cicular()
    {
        return $this->hasMany('App\Materials\Circular', 'sub_local_id', 'id');
    }

}
