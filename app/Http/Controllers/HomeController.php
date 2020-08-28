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
use App\Http\Controllers\Quizzes\Quizzes;
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
    public function index(Request $request)
    {
        // if(Auth::id() === 37) {
        //     return Session::all();
        // }
        //Verifica se usuário foi apagado
        if(!is_null(Auth::user()->deleted_at)) {
            Auth::logout();
            return redirect('/')->withErrors(['username' => 'Usuário não encontrado ou desativado.']);
        }

        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }

        //define variáveis à serem utilizadas na função
        $ilha = Auth::user()->ilha_id;
        $user = Auth::id();
        $lgpd = Auth::user()->accept_lgpd;
        $cargo = Auth::user()->cargo_id;

        // registra que usuário está online
        $users = new Users();
        @$users->saveLogin($user);

        // se pode publicar, carrega ilhas
        if(in_array(1,Session::get('permissionsIds')) || in_array(26,Session::get('permissionsIds'))) {
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

        // Pega quizzes não vistos
        $q = new Quizzes();
        $quiz = $q->getQuizFromUser($ilha, $user);

        //title da página
        $title = 'Home Page';
        return view('home',compact('title','ilhas','cargos','quiz'));

    }
}
