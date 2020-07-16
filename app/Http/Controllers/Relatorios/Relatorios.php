<?php

namespace App\Http\Controllers\Relatorios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Logs\Log;
use App\Users\Ilha;
use App\Users\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Materials\Calculadoras;
use App\Http\Controllers\Materials\Circulares;
use App\Http\Controllers\Materials\Materiais;
use App\Http\Controllers\Materials\Roteiros;
use App\Http\Controllers\Materials\Videos;
use App\Http\Controllers\Users\Ilhas;
use App\Quiz\Quiz;
use App\Users\Cargo;

class Relatorios extends Controller
{
    // retorna view de relatório de clima
    public function clima(Request $request){
        //title da page
        $title = 'Relatórios de Clima';

        //dados para pesquisa
        $users =  User::all();
        $ilhas =  Ilha::all();

        return view('gerenciamento.reports.clima',compact('title','ilhas','users'));
    }

    //retorna view de relatório de quizzes
    public function quiz(Request $request)
    {
        //title ad page
        $title = 'Relatórios de Clima';

        //Quizzes
        $quizzes = Quiz::withTrashed()->orderBy('id')->get();

        //dados para pesquisa
        $users =  User::all();
        $ilhas =  Ilha::all();



        $filters = 0;

        return view('gerenciamento.reports.quiz',compact('title','ilhas','users','quizzes','filters'));
    }

    // retorna view de relatório de links
    public function linkTag()
    {
        $title = 'Relatório de Links e Tags';
        $log = Log::select('value')
                    ->distinct()
                    ->whereIn('action',['OPEN_LINK','OPEN_TAG'])
                    ->get();


        return view('reports.links',compact('log','title'));
    }

    public function getLinkTag(Request $request, $user)
    {
        $linkTag = $request->input('linkTag');

        $title = 'Relatório de Links e Tags';
        $log = Log::select('logs.created_at as linkTag','u.name','u.cpf')
                    ->leftJoin('book_usuarios.users as u','logs.user_id','u.id')
                    ->whereIn('logs.action',['OPEN_LINK','OPEN_TAG'])
                    ->where('logs.value',$linkTag)
                    ->latest('linkTag')
                    ->get();


        return $log;
    }

}