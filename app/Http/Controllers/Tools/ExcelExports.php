<?php

namespace App\Http\Controllers\Tools;

use App\Tools\DataTableExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Excel;

class ExcelExports extends Controller
{
    public function basicDatatable(int $id, int $ilha, $raw = FALSE, Request $request)
    {
        // Verifica se existe dado bruto de exportação
        if(!$raw) {
            (array) $rawData = json_decode($request->data,TRUE);
        } else {
            (array) $rawData = json_decode(json_encode($raw), TRUE);
        }

        // Pega dado
        if(isset($rawData["items"])) {
            $data = $rawData['items'];
            $column = array_keys($data[0]);
        } else {
            $data = $rawData;
            $column = array_keys($data[0]);
        }

        // Define data
        $date = date('YmdHis');

        // Transforma dado em Excel
        $export = new DataTableExport($data, $column);

        // Força download
        return Excel::download($export, "liderbook_export_$date.xlsx");
    }
}
