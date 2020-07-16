<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Posts\Posts;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Users\Ilhas;
use App\Http\Controllers\Users\Cargos;
use App\Http\Controllers\Users\Users;
use App\Users\User;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $n)
    {
        //Verifica se usuário foi apagado
        if(!is_null(Auth::user()->deleted_at)) {
            Auth::logout();
            return redirect('/')->withErrors(['username' => 'Usuário não encontrado ou desativado.']);
        }

        //deine variáveis à serem utilizadas na função
        $ilha = Auth::user()->ilha_id;
        $user = Auth::id();
        $lgpd = Auth::user()->accept_lgpd;
        $cargo = Auth::user()->cargo_id;

        // registra que usuário está online
        $users = new Users();
        @$users->saveLogin($user);

        //Registra Login
        $log = new Logs();

        if($n == 1) {
            $log->login($user, $ilha, $request->ip());
        }

        // retorna view de registro aceite de LGPD
        if($lgpd == NULL) {
            $title = 'Termo de aceitação de Politica de Privacidade - LiderBook';
            $lgpd = TRUE;
            return view('lgpd',compact('title','lgpd'));
        }

        //Verifica se o usuário já fez login anteriormente
        $firstLogin = $log->firstLogin($user);
        if($firstLogin === 0) {
            return redirect('profile/'.base64_encode($user));
        }

        if(!in_array($cargo, [4,5])) {
            //pega Ilhas
            $i = new Ilhas();
            $ilhas = json_decode($i->index('id, name'));

            //pega cargos
            $c = new Cargos();
            $cargos = $c->selectCustom('id, description as name');
        } else {
            $ilhas = NULL;
            $cargos = NULL;
        }


        //title da página
        $title = 'Home Page';

        //materiais não lidos
        $countMat = $log->countNotRead($user,$ilha);
        if($countMat !== 0) {
            Session::put('countMaterials',$countMat[0]);
            Session::put('countVideo',$countMat[1][2]);
        }

        return view('home',compact('title','ilhas','cargos'));

    }
}
