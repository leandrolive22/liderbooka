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
            $rawData = json_decode($request->data,TRUE);
        } else {
            return $rawData = json_decode(json_encode($raw), TRUE);
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

    public function analyticMonitoria(array $data, array $columns)
    {
        // Define data atual
        $date = date('YmdHis');

        try {
            // Transforma dado em Excel
            $export = new DataTableExport($data, $columns);

            // Força download
            return Excel::download($export, "liderbook_export_monitoring.xlsx");
        } catch (Exception $e) {
            throw new Exception("Error Processing Request".$e->getMessage(), 1);
        }
        
    }
}
