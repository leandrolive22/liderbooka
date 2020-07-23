<?php

namespace App\Tools;

use App\Monitoria\RelatorioAnaliticoTrimestral;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class FromQueryExport implements FromQuery
{

    use Exportable;

    protected $field;
    protected $between;


    /**
     * Instancia objetos da Classe DataTableExport
     *
     * @param string $de = data no formato d/m/y
     * @param string $ate = data no formato d/m/y
     * @return void
     */
    public function __construct(string $field, array $between)
    {
        $this->field = $field;
        $this->between = $between;
    }

    public function query()
    {
        $select = RelatorioAnaliticoTrimestral::wherebetween($this->field,[$this->between])->orderBy('data_monitoria')->get();
        if($select->count() > 0) {
            return $select;
        }
        return back()->with('errorAlert','Nenhum dado encontrado');
    }
}
