<?php

namespace App\Http\Controllers\Relatorios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Logs\Log;
use App\Users\Ilha;
use App\Users\User;


class Clima extends Controller
{
    /* functions to export excel */
    public function environment(Request $request, $i)
    {
        $dateIn = $request->input('DataIn');
        $dateFin = $request->input('DataFin');

        //title ad page
        $title = 'Relatórios de Clima';

        $ilhas = explode(',',$i);

        $log = Log::where('action','HUMOUR_REGIST')
                ->whereIn('ilha_id',$ilhas)
                ->whereBetween ('created_at',[$dateIn,$dateFin])
                ->get(['user_id','ilha_id','created_at','value']);

        $count = $log->count();

        //dados para pesquisa
        $users =  User::all();
        $ilhas =  Ilha::all();

        return view('gerenciamento.reports.clima',compact('title','ilhas','users','log','count'));
    }
    /* ./functions to export excel */
}
