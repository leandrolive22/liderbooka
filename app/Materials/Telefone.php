<?php

namespace App\Materials;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telefone extends Model
{
    use SoftDeletes;

    protected $connection = 'bookmateriais';
    protected $table = 'telephones';

    public function setor(){
        return $this->belongsTo('App\Users\Setor', 'setor_id', 'id');
    }

}
