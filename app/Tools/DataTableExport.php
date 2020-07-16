<?php

namespace App\Tools;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DataTableExport implements FromView
{
    protected $data;
    protected $column;

    /**
     * Instancia objetos da Classe DataTableExport
     *
     * @param array  $data = dados da tabela
     * @param array  $column = cabeçalho
     * @return void
     */
    public function __construct(array $data, array $column)
    {
        $this->data = $data;
        $this->column = $column;
    }

    public function view(): View
    {
        $data = $this->data;
        $column = $this->column;
        $count = count($column); // monta colunas da tabela

        return view('tools.exportTable', compact('data','column','count'));
    }
}
