<?php

namespace App\Monitoria;

use Illuminate\Database\Eloquent\Model;

class RelatorioAnaliticoTrimestral extends Model
{
    protected $connection = 'bookmonitoria';
    protected $table = 'relatorio_analitico_trimestral';
}
