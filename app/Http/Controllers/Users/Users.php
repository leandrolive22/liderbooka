<?php

namespace App\Http\Controllers\Users;
use App\User AS UserDefault;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Materials\Calculadoras;
use App\Http\Controllers\Materials\Circulares;
use App\Http\Controllers\Materials\Materiais;
use App\Http\Controllers\Materials\Roteiros;
use App\Http\Controllers\Materials\SubLocais;
use App\Http\Controllers\Materials\Videos;
use App\Http\Controllers\Monitoria\Monitorias;
use App\Http\Controllers\Permissions\Permissions;
use App\Http\Controllers\Quizzes\Quizzes;
use App\Http\Controllers\Tools\Tools;
use App\Logs\Log;
use App\Users\User;
use App\Users\DeletedUser;
use App\Users\Filial;
use App\Users\Ilha;
use App\Users\Setor;
use App\Users\Carteira;
use App\Http\Controllers\Users\Ilhas;
use App\Http\Controllers\Users\Cargos;
use App\Http\Controllers\Users\Carteiras;
use App\Materials\Circular;
use App\Materials\Material;
use App\Materials\Roteiro;
use App\Materials\Video;

class Users extends Controller
{
    public function saveLogin($id)
    {
        $user = UserDefault::find($id);
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        $log = new Logs();
        @$log->log('ITS_LOGED',NULL,'LiderBook',$id,$user->ilha_id);
    }

    //rotas de direcionamento
    public function index(Request $request)
    {
        if(in_array($request->fullUrl(),['http://34.66.68.96/liderbook/public','http://34.66.68.96/liderbook/public/login','https://34.66.68.96/liderbook/public','https://34.66.68.96/liderbook/public/login'])) {
            return redirect('https://liderbook.liderancacobrancas.com.br/liderbook/public');
        }

        $title = 'Login';
        if(Auth::check()) {
            return redirect('home/page');
        }

        return view('LiderAuth.account.login', compact('title'));

    }

    //lgpd
    public function lgpd(Request $request)
    {
        $id = Auth::id();

        if(is_null($id) || in_array($id,[NULL, 0, '', ' '])) {
            return back()->with(['errorAlert','Usuário não encontrado']);
        }

        $user = UserDefault::find($id);

        if(is_null($user)) {
            Auth::logout();
            return redirect('/')->with(['errorAlert','Usuário não encontrado']);
        }

        $user->accept_lgpd = date('Y-m-d H:i:s');
        if($user->save()) {
            $log = new Logs();
            $log->log(strtoupper('accept_lgpd'), base64_encode('Eu, portador da Matrícula '.Auth::user()->matricula.' declaro que aceito a politica de privacidade'), $request->fullUrl(), Auth::id(), Auth::user()->ilha_id);

            return redirect('home/page');
        }

    }

    public function forgot()
    {

        return view('LiderAuth.account.forgot');
    }


    public function manager()
    {
        $title = 'Administrador';

        // Pega quizzes não vistos
        $q = new Quizzes();
        $quiz = $q->getQuizFromUser(Auth::user()->ilha_id, Auth::id());

        return view('gerenciamento.gerenciamento', compact('title','quiz'));
    }

    public function profile($id)
    {
        $title = 'Profile';
        $user = UserDefault::find(base64_decode($id));

        return view('profile.user', compact('title', 'user'));
    }

    //retorna insert de usuarios
    // public function registerUserView()
    // {
    //     // Gravas Setores em cache
    //     if(!is_null(Cache::get('getSetores')))
    //     {
    //         $setores = Cache::get('getSetores');
    //     } else {
    //         $s = new Setores();
    //         $setores = ($s->index());
    //         Cache::put('getSetores',$setores,720);
    //     }

    //     // grava cargos em cache
    //     if(!is_null(Cache::get('getCargos')))
    //     {
    //         $cargos = Cache::get('getCargos');
    //     } else {
    //         $c = new Cargos();
    //         $cargos = json_decode($c->selectCustom('id, description','description'));
    //         Cache::put('getCargos',$cargos,720);
    //     }

    //     // grava carteiras em cache
    //     if(!is_null(Cache::get('getCarteiras')))
    //     {
    //         $carteiras = Cache::get('getCarteiras');
    //     } else {
    //         $t = new Carteiras();
    //         $carteiras = json_decode($t->index());
    //         Cache::put('getCarteiras',$carteiras,720);
    //     }

    //     // grava carteiras em cache
    //     if(!is_null(Cache::get('getIlhas')))
    //     {
    //         $ilhas = Cache::get('getIlhas');
    //     } else {
    //         $i = new Ilhas();
    //         $ilhas = json_decode($i->index());
    //         Cache::put('getIlhas',$ilhas,720);
    //     }

    //     // grava superintendentes em cache
    //     if(!is_null(Cache::get('getSuperintendentes')))
    //     {
    //         $superintendentes = Cache::get('getSuperintendentes');
    //     } else {
    //         $superintendentes = $this->getSuperintendentes();
    //         Cache::put('getSuperintendentes',$superintendentes,720);
    //     }

    //     // grava gerentes em cache
    //     if(!is_null(Cache::get('getGerentes')))
    //     {
    //         $gerentes = Cache::get('getGerentes');
    //     } else {
    //         $gerentes = $this->getGerentes();
    //         Cache::put('getGerentes',$gerentes,720);
    //     }

    //     $title = 'Registrar Usuários';

    //     return view('gerenciamento.users.register', compact('title', 'gerentes', 'superintendentes', 'ilhas','setores', 'cargos', 'carteiras'));
    // }

    //pega todos os dados do usuários por id
    public function byId($id) {
        $user = User::select('users.*', 'supervisors.name as supervisor', 'coordenadors.name as coordenador', 'gerentes.name as gerente', 'superintendentes.name as superintendente', 'ilhas.name as segmento', 'cargos.description as cargo', 'carteiras.name as carteira', 'filiais.name as filial', 'setores.name as setor')
        ->leftJoin('users as supervisors', 'users.supervisor_id', 'supervisors.id')
        ->leftJoin('users as coordenadors', 'users.coordenador_id', 'coordenadors.id')
        ->leftJoin('users as gerentes', 'users.gerente_id', 'gerentes.id')
        ->leftJoin('users as superintendentes', 'users.superintendente_id', 'superintendentes.id')
        ->leftJoin('ilhas', 'ilhas.id', 'users.ilha_id')
        ->leftJoin('cargos', 'cargos.id', 'users.cargo_id')
        ->leftJoin('carteiras', 'carteiras.id', 'users.carteira_id')
        ->leftJoin('filiais', 'filiais.id', 'users.filial_id')
        ->leftJoin('setores', 'setores.id', 'users.setor_id')
        ->where('users.id',$id)
        ->get();

        return $user;
    }

    //pega todos os dados do usuários por id e retorna strong JSON
    public function jsonById($id)
    {
        $user = User::select('users.*', 'supervisors.name as supervisor', 'coordenadors.name as coordenador', 'gerentes.name as gerente', 'superintendentes.name as superintendente', 'ilhas.name as segmento', 'cargos.description as cargo', 'carteiras.name as carteira', 'filiais.name as filial', 'setores.name as setor')
        ->leftJoin('users as supervisors', 'users.supervisor_id', 'supervisors.id')
        ->leftJoin('users as coordenadors', 'users.coordenador_id', 'coordenadors.id')
        ->leftJoin('users as gerentes', 'users.gerente_id', 'gerentes.id')
        ->leftJoin('users as superintendentes', 'users.superintendente_id', 'superintendentes.id')
        ->leftJoin('ilhas', 'ilhas.id', 'users.ilha_id')
        ->leftJoin('cargos', 'cargos.id', 'users.cargo_id')
        ->leftJoin('carteiras', 'carteiras.id', 'users.carteira_id')
        ->leftJoin('filiais', 'filiais.id', 'users.filial_id')
        ->leftJoin('setores', 'setores.id', 'users.setor_id')
        ->where('users.id',$id)
        ->get();

        return $user->toJSON();
    }

    // retorna usuários deletados
    public function managerUserViewRestore()
    {
        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }

        $carteira = Auth::user()->carteira_id;
        if($carteira == NULL) {
            return back()->with(['errorAlert','Erro! usuário sem carteira registrada, contate o treinamento.']);
        }

        $users = User::select('id','name','username','matricula','ilha_id')
        ->when(!in_array($carteira,[1,2,9]),function($q,$carteira) {
            return $q->where('carteira_id',$carteira);
        })
        ->orderBy('name')
        ->onlyTrashed()
        ->paginate(15);

        $title = 'Restaurar Usuários';

        return view('gerenciamento.users.managerUser', compact('title', 'users'));
    }

    //retorna gerenciamento de usuarios
    public function managerUserView()
    {
        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }

        $carteira = Auth::user()->carteira_id;
        if($carteira == NULL) {
            return back()->with(['errorAlert','Erro! usuário sem carteira registrada, contate o treinamento.']);
        }

        // grava usuários em Cache
        $users = User::select('id','name','username','matricula','ilha_id')
        ->when(!in_array($carteira,[1,2,9]),function($q,$carteira) {
            return $q->where('carteira_id',$carteira);
        })
        ->orderBy('name')
        ->paginate(15);

        // grava cargos em cache
        if(!is_null(Cache::get('getCargos')))
        {
            $cargos = Cache::get('getCargos');
        } else {
            $c = new Cargos();
            $cargos = json_decode($c->selectCustom('id, description', 'description'));
            Cache::put('getCargos',$cargos,720);
        }

         // grava superintendentes em cache
        if(!is_null(Cache::get('getSuperintendentes')))
        {
            $superintendentes = Cache::get('getSuperintendentes');
        } else {
            $superintendentes = $this->getSuperintendentes();
            Cache::put('getSuperintendentes',$superintendentes,720);
        }

        // grava gerentes em cache
        if(!is_null(Cache::get('getGerentes')))
        {
            $gerentes = Cache::get('getGerentes');
        } else {
            $gerentes = $this->getGerentes();
            Cache::put('getGerentes',$gerentes,720);
        }

        // grava coordenadores em cache
        if(!is_null(Cache::get('getCoordenadores')))
        {
            $coordenadores = Cache::get('getCoordenadores');
        } else {
            $coordenadores = $this->getCoordenadores(0);
            Cache::put('getCoordenadores',$coordenadores,720);
        }

        // grava getSupervisores em cache
        if(!is_null(Cache::get('getSupervisores')))
        {
            $supervisores = Cache::get('getSupervisores');
        } else {
            $supervisores = $this->getSupervisores(0);
            Cache::put('getSupervisores',$supervisores,720);
        }

        // grava carteiras em cache
        if(!is_null(Cache::get('getCarteiras')))
        {
            $carteiras = Cache::get('getCarteiras');
        } else {
            $t = new Carteiras();
            $carteiras = json_decode($t->index());
            Cache::put('getCarteiras',$carteiras,720);
        }

        // Gravas Setores em cache
        if(!is_null(Cache::get('getSetores')))
        {
            $setores = Cache::get('getSetores');
        } else {
            $s = new Setores();
            $setores = ($s->index());
            Cache::put('getSetores',$setores,720);
        }

        // grava Ilhas em cache
        if(!is_null(Cache::get('getIlhas')))
        {
            $ilhas = Cache::get('getIlhas');
        } else {
            $i = new Ilhas();
            $ilhas = json_decode($i->index());
            Cache::put('getIlhas',$ilhas,720);
        }

        $filiais  = Filial::select('id','name')->orderBy('name')->get();

        $title = 'Gerenciar Usuário';
        return view('gerenciamento.users.managerUser', compact('title', 'users', 'cargos', 'gerentes', 'superintendentes', 'coordenadores', 'supervisores', 'filiais', 'carteiras', 'setores', 'ilhas'));
    }

    public function searchInTable(Request $request)
    {
        $str = $request->str;
        $input = $request->input;

        $data = User::when($input == 'name',function($q) use ($str) {
                        return $q->whereRaw("name LIKE '%$str%'");
                    })
                    ->when($input == 'username',function($q) use ($str) {
                        return $q->where("username",$str);
                    })
                    ->when($input == 'matricula',function($q) use ($str) {
                        return $q->where("matricula","=",$str);
                    })->when($request->deleted_at === 1 && !is_null($request->deleted_at), function($q) {
                        return $q->onlyTrashed();
                    })
                    ->get();

        return $data;
    }

    //retorna gerenciamento de materiais
    public function manageMaterials()
    {
        $title = 'Gerenciar Materiais';

        //pega Circulares
        $circular = new Circulares();
        $circulares = ($circular->allCirc());

        //pega Roteiros
        $roteiro = new Roteiros();
        $roteiros = ($roteiro->allScripts());

        //pega Materiais
        $material = new Materiais();
        $materiais = ($material->allMaterials());

        //pega Materiais
        $video = new Videos();
        $videos = ($video->allVideos());

        //pega Calculadoras
        $calculadora = new Calculadoras();
        $calculadoras = ($calculadora->allCalc());

        //pega subLocals
        $sub = new SubLocais();
        $subs = json_decode($sub->index());

        //pega ilhas
        $ilha = new Ilhas();
        $ilhas = json_decode($ilha->indexPost());

        //pega setores
        $setor = new Setores();
        $setores = $setor->index();

        // Pega quizzes não vistos
        $q = new Quizzes();
        $quiz = $q->getQuizFromUser(Auth::user()->ilha_id, Auth::id());


        return view('gerenciamento.materials.manage', compact('title', 'ilhas', 'setores', 'circulares', 'roteiros', 'calculadoras', 'materiais', 'videos', 'subs', 'quiz'));
    }

    //redireciona para wiki/lidos
    public function lidos($ilha)
    {
        $title = 'Lidos';
        $circulares = Circular::whereIn('ilha_id',[1,$ilha])->latest()->get();

        return view('wiki.lidos',compact('circulares','title'));
    }


    //retorna wiki
    public function wiki($ilha)
    {
        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }

        $title = 'Wiki';
        $videos = Video::whereIn('ilha_id',[1,$ilha])->get();

        $sublocal = new SubLocais();
        $segmentos = json_decode($sublocal->byIlha($ilha,'id, name',FALSE));

        // registra que usuário está online
        @$this->saveLogin(Auth::id());
        $p = new Permissions();
        $type = $p->wikiSearchType();


        if($type['tudo']) {
            $i = new Ilhas();
            $ilhas = json_decode($i->index());

        } else {
            $ilhas = NULL;
        }

        return view('wiki.wiki', compact('title','segmentos','ilhas'));
    }

    //conta quantos materias nãp foram lidos
    public function countAllMaterials($ilha)
    {
        $material = Material::where('ilha_id',$ilha)
        ->count();

        $script = Roteiro::where('ilha_id',$ilha)
        ->count();

        $video = Video::where('ilha_id',$ilha)
        ->count();

        $circular = Circular::where('ilha_id',$ilha)
        ->count();

        $materials = $material + $script + $video + $circular;

        $byType = [$material, $script, $video, $circular];

        $array = [$materials,$byType];


        return $array;
    }

    //rotas de dados
    public function userPost($user)
    {

        $username = User::where('id', $user)->get();


        return $username->toJSON();
    }

    //salvar estilo
    public function style(Request $request, $id)
    {
        $option = $request->input('option');

        $user = UserDefault::find($id);
        $user->css = $option;
        if ($user->save()) {

            return redirect("profile/" . base64_encode($id))->with('successAlert', 'Estilo Alterado');
        } else {

            return back()->with('errorAlert', 'Falha ao alterar estilo.');
        }
    }
    //salvar nome
    public function name(Request $request, $id)
    {
        $option = $request->input('name');

        $user = UserDefault::find($id);
        $user->name = $option;
        if ($user->save()) {

            return redirect("profile/" . base64_encode($id))->with('successAlert', 'Nome Alterado');
        } else {

            return back()->with('errorAlert', 'Falha ao alterar Nome.');
        }
    }

    //salvar username
    public function username(Request $request, $id)
    {
        $option = $request->input('username');

        $user = UserDefault::find($id);
        $user->username = $option;
        if ($user->save()) {

            return redirect("profile/" . base64_encode($id))->with('successAlert', 'Username Alterado');
        } else {

            return back()->with('errorAlert', 'Falha ao alterar Username.');
        }
    }

    //altera avatar do usuario
    public function setAvatar($id, $avatar)
    {

        $user = UserDefault::find($id);
        if(is_null($user)) {
            return back()->with(['errorAlert' => 'Erro ao alterar avatar, contate o suporte (#ISNULL).']);
        }
        $str = "storage/img/avatar/".strval($avatar).".png";
        $user->avatar = $str;
        if ($user->save()) {

            return redirect('profile/' . base64_encode($id))->with(['successAlert' => 'Avatar alterado com sucesso!']);
        } else {

            return back()->with(['errorAlert' => 'Erro ao alterar avatar, tente novamente mais tarde.']);
        }
    }

    //muda senha
    public function changePass(Request $request)
    {
        $pass = $request->input('password');
        $word = $request->input('confirmPass');
        $id = $request->input('id');

        if($pass == env("DEFAULT_PASSWORD")) {
            return response()->json(['errorAlert', 'Senha Padrão ('.env("DEFAULT_PASSWORD").') não permitida, altere a senha!'],422);
        } else if ($pass === $word) {
            $change = UserDefault::find($id);

            //
            if(is_null($change)) {
                return response()->json(['c', 'Usuário não encontrado'], 422);
            }

            $change->password = Hash::make($pass);
            if ($change->save()) {
                Session::put('pwIsDf',0);
                return response()->json(['successAlert', 'Senha Alterada com Sucesso!']);
            } else {

                return response()->json(['errorAlert', 'Senha não registrada!'],422);
            }
        } else {

            return response()->json(['errorAlert', 'As senhas são diferentes!',422]);
        }
    }

    //redefine senha para padrão
    public function resetPass($id, $u, $i)
    {
        $user = UserDefault::find($id);
        if(is_null($user)) {
            return back()->with('errorAlert', 'usuário não encontrado!');
        }

        $user->password = Hash::make('Book2020@lidera');
        if ($user->save()) {
            $log = new Logs();
            $log->log('RESET_PASSWORD_OF:', $id, asset('/manager/user'), $u, $i);


            return response()->json(['success' => TRUE], 200);
        } else {

            return back()->with('errorAlert', 'Erro ao redefinir senha!');
        }
    }

        //Pegar superiores
    public function superiores($ilha, $cargo)
    {
        $superiores = User::where('cargo_id', '>=', $cargo)
        ->where('ilha_id', '>=', $ilha)
        ->orderBy('name','ASC')
        ->get(['id', 'name']);


        return $superiores->toJSON();
    }

        //Salva humor (LOG)
    public function humour($n, $id, $ilha)
    {
        $log = new Log();
        $log->action = 'HUMOUR_REGIST';
        $log->value = $n;
        $log->page = asset("/") . "api/reaction/humour/" . $n . "/" . $id . "/" . $ilha;
        $log->user_id = $id;
        $log->ilha_id = $ilha;
        if ($log->save()) {

            $user = UserDefault::find($id);
            $user->have_humour = date('Y-m-d');
            $user->save();

            return response()->json(['success' => TRUE], 201);
        } else {

            return response()->json(['success' => FALSE, 'error' => 'Não foi possível salvar reação']);
        }
    }

    //numero de logs
    public function checkHumour($user)
    {
        $check = Log::where('action','HUMOUR_REGIST')
        ->where('user_id',$user)
        ->where('created_at','>',date('Y-m-d').' 00:00:00')
        ->count();

        return $check;
    }

        //Monta gráfico de Logs da equipe
    public function getHumourtToChart($id,$cargo,$ilha)
    {
        $campo = NULL; //campo de pesquisa

        /*is coordenator*/if($cargo == 7) {
            $campo .= 'coordenador_id';
        } else /*is manager*/if($cargo == 2) {
            $campo .= 'gerente_id';
        } else /*is superintendent*/if($cargo == 9) {
            $campo .= 'superintendente_id';
        } else /*is supervisor or another superior */{
            $campo .= 'supervisor_id';
        }

        // Pega registros do dia
        $search = Log::selectRaw("IF(logs.value = 1,'Insatisfeito',IF(logs.value = 2,'Indiferente','Satisfeito')) AS valTypes, COUNT(logs.`value`) AS humor")
                    ->leftJoin('book_usuarios.users AS u','u.id','logs.user_id')
                    ->where('logs.action','HUMOUR_REGIST')
                    ->where('logs.created_at','>',date('Y-m-d 00:00:00'))
                    ->where('u.'.$campo,$id)
                    ->groupBy('valTypes')
                    ->orderBy('valTypes')
                    ->get();

        // verifica se existe usuários subordinados registrados
        if($search->count() == 0) {
            return [];
        }

        return $search;
    }

    public function concatenateArray($array)
    {
        $str = NULL;
        foreach ($array as $data) {
            $str .= $data['user_id'].',';
        }


        return $str;
    }

    //trata resultados de pesquisa de humor básica
    public function separateHumours($array,$str)
    {
        $first = 0;
        $second = 0;
        $third = 0;

        foreach($array as $item) {
            if($item[$str] == 1) {
                $first++;
            } else if($item[$str] == 2) {
                $second++;
            } else if($item[$str] == 3) {
                $third++;
            }
        }


        return [$first,$second,$third];
    }

    //Gerenciamento de usuário
    //insert user
    public function store(Request $request)
    {
        $rules = [
            "name" => "required|min:3",
            "matricula" => "required|unique:users",
            "username" => "required|unique:users,username,NULL,id,deleted_at,NULL",
            "carteira_id" => "required|int",
            "cargo_id" => "required|int",
        ];
        $messages = [
            "required" => "Este campo não pode ser vazio",
            "min" => "Este campo deve ser maior do que 3 caracteres",
            "max" => "Este campo deve ser menor do que 14 caracteres",
            "username.unique" => "Nome de Usuário (Username) já registrado",
            "matricula.required" => "Matricula já registrada!"
        ];
        $request->validate($rules, $messages);


        // dados do form
        $name = $request->input("name");
        $id = $request->input('id');
        $cargo = $request->input("cargo_id");
        $matricula = $request->input("matricula");
        $ilha = $request->input("carteira_id");
        $username = $request->input("username");
        $supervisor = $request->input("superior_id");
        $coordenador = $request->input("coordenador_id");
        $gerente = $request->input("manager_id");
        $superintendente = $request->input("sup_id");
        $pass = Hash::make('Book2020@lidera');
        $another_config = NULL;

        // Pega setor_id e Carteira_id
        try {
            $setor_id = Ilha::find($ilha)->setor_id;
            $carteira_id = Setor::find($setor_id)->carteira_id;
        } catch (\Exception $e) {
            $this->forgetCache();
            return response()->json(['success' => FALSE, 'msg' => $e->getMessage()], 422);
        }

        // inclui infos adicionais
        if($cargo === 3) {
            $another_config .= '{"training": 1}';
        }
        if($cargo === 10) {
            $another_config .= '{"monitoring": '.$ilha.'}';
        }

        //Salva Usuário
        $insert = new User();
        $insert->name = $name;
        $insert->matricula = $matricula;
        $insert->username = $username;
        $insert->password = $pass;
        $insert->cargo_id = in_array($cargo, ['-',0,'',' ']) ? NULL : $cargo;
        $insert->ilha_id = in_array($ilha, ['-',0,'',' ']) ? NULL : $ilha;
        $insert->carteira_id = in_array($carteira_id, ['-',0,'',' ']) ? NULL : $carteira_id;
        $insert->setor_id = in_array($setor_id, ['-',0,'',' ']) ? NULL : $setor_id;
        $insert->supervisor_id = in_array($supervisor, ['-',0,'',' ']) ? NULL : $supervisor;
        $insert->coordenador_id = in_array($coordenador, ['-',0,'',' ']) ? NULL : $coordenador;
        $insert->gerente_id = in_array($gerente, ['-',0,'',' ']) ? NULL : $gerente;
        $insert->superintendente_id = in_array($superintendente, ['-',0,'',' ']) ? NULL : $superintendente;
        $insert->another_config;

        // salva e configura retornos
        if ($insert->save()) {
            $this->forgetCache();
            $log = new Log();
            $log->action = 'NEW_USER:';
            $log->value = $insert->id;
            $log->page = asset('/manager/user/register');
            $log->user_id = $id;
            $log->ilha_id = $insert->ilha_id;

            // GRava permissões padrão de acordo com cargo
            $permission = new Permissions();
            if(!$permission->savePermissionsByCargo($cargo, $insert->id)) {
                return response()->json(['success' => TRUE, 'msg' => 'permissões não configuradas']);
            }

            return response()->json(['success' => TRUE]);
        }

        return response()->json(['success' => FALSE],500);

    }

    public function restore($userAction, $user, Request $request)
    {
        try {
            if(User::withTrashed()->find($user)->restore()) {
                $log = new Logs();
                $log->log('RESTORE_ID->', $user, $request->fullUrl(), $userAction, 1);
                return redirect(url()->previous())->with('successAlert','Usuário restaurado com sucesso!');
            }

            return back()->with('errorAlert','Erro ao restaurar, recarregue a página e tente novamente');
        } catch (Exception $e) {
            return back()->with('errorAlert',$e->getMessage());
        }
    }

    /*
    * @param $user = User que solicitou alteração
    * @param Request $request = dados da Requisição
    * @return = JSON Response
    */
    function editSupervisor(Request $request, $user) {
        $id = $request->input('id');
        $sup = $request->input('supSelection');

	    $super = UserDefault::find($sup);
        $user = UserDefault::find($id);
        $user->supervisor_id = $super->id;
        if($user->save()) {
            $m = new Monitorias();
            $m->changeAllSupers($id,$sup);
            return response()->json(['success' => TRUE, 'msg' => 'Supervisor Alterado!', 'super' => $super->name], 201);
        }

        return response()->json(['success' => FALSE], 500);
    }

    /**
     * Altera usuário
     *
     * @param int $user = User que solicitou alteração
     * @param Illuminate\Http\Request $request = dados da Requisição
     * @return Illuminate\Http\Response
     */
    public function editUser(Request $request, $user)
    {
        //user data
        $id = $request->input('id'); //Usuário editado
        $name = $request->input('name');
        $username = $request->input('username');
        $matricula = $request->input('matricula');
        $cargo = $request->input('cargo_id');

        //Locals data
        $filial_id = $request->input('filial_id');
        $carteira_id = $request->input('carteira_id');
        $setor_id = $request->input('setor_id');
        $ilha = $request->input('ilha_id');

        //hierarquic data
        $superintendente_id = $request->input('superintendente_id');
        $gerente_id = $request->input('gerente_id');
        $coordenador_id = $request->input('coordenador_id');
        $supervisor_id = $request->input('supervisor_id');


        $update = UserDefault::find($id);

        if($update->count() == 0) {
            return response()->json(['success' => FALSE, 'msg' => 'Usuário não encontrado'], 404);
        }

        //user data
        $update->name = $name;
        $update->username = $username;
        $update->matricula = $matricula;
        $update->cargo_id = $cargo;
        //Locals data
        $update->filial_id = in_array($filial_id,['null','',' ',0]) ? NULL : $filial_id;
        $update->carteira_id = in_array($carteira_id,['null','',' ',0]) ? NULL : $carteira_id;
        $update->setor_id = in_array($setor_id,['null','',' ',0]) ? NULL : $setor_id;
        $update->ilha_id = in_array($ilha,['null','',' ',0]) ? NULL : $ilha;
        //Hierarquic data
        $update->superintendente_id = in_array($superintendente_id,['null','',' ',0]) ? NULL : $superintendente_id;
        $update->gerente_id = in_array($gerente_id,['null','',' ',0]) ? NULL : $gerente_id;
        $update->coordenador_id = in_array($coordenador_id,['null','',' ',0]) ? NULL : $coordenador_id;
        $update->supervisor_id = in_array($supervisor_id,['null','',' ',0]) ? NULL : $supervisor_id;

        if($update->save()) {
            $this->forgetCache();
            $m = new Monitorias();
            $m->changeAllSupers($id,in_array($supervisor_id,['null','',' ',0]) ? NULL : $supervisor_id);

            //Registra log
            $log = new Logs();
            $log->log('UPDATE_USER_ID->', $id, $request->fullUrl(), $user, $ilha);
            return response()->json(['success' => TRUE], 201);
        } else {
            return response()->json(['success' => FALSE], 422);
        }
    }

    public function editIlha($id, Request $request) {
        $user = UserDefault::find($id);
        $user->ilha_id = $request->ilha_id;
        if($user->save()) {
            return redirect(url()->previous());
        }

        return back()->with('errorAlert','Erro ao trocar ilha, tente novamente mais tarde');

    }

    //Deleta um usuário
    public function deleteUser(Request $request)
    {
        $id = $request->input('id');
        $userLog = $request->input('user');

        // pega usuario para ser deletado
        $user = User::withTrashed()->find($id);
        if(!is_null($user)) {
            $ilha = $user->ilha_id;

            $deleted = new DeletedUser();
            $deleted->user_id = $id;
            $deleted->deletor_id = $userLog;
            $deleted->name = $user->name;
            $deleted->cpf = $user->matricula;
            $deleted->username = $user->username;
            $deleted->save();

            if(!is_null($user->deleted_at)) {
                if($user->forceDelete()) {
                    //Registra log
                    $log = new Logs();
                    $log->log('FORCE_DELETE_USER_ID->', $id, route('PostUsersDeleteUser'), $userLog, $ilha);

                    return response()->json(['success' => TRUE]);
                } else {
                    return response()->json(['success' => FALSE]);
                }
            } else if($user->delete()) {
                //Registra log
                $log = new Logs();
                $log->log('DELETE_USER_ID->', $id, route('PostUsersDeleteUser'), $userLog, $ilha);

                return response()->json(['success' => TRUE]);
            } else {

                return response()->json(['success' => FALSE]);
            }
        }

        return response()->json(['success' => TRUE]);
    }

    public function getSupervisores($ilha, $json = 0)
    {

        $sup = User::select('id','name')
        ->where('cargo_id',4)
        ->when($ilha > 0, function($query) use ($ilha) {
            return $query->where('ilha_id',$ilha);
        })
        ->orderBy('name')
        ->get();

        if($json === 0) {
            return $sup;
        }

        return $sup->toJSON();
    }

    public function getSuperintendentes()
    {
        $superintendentes = User::select('id','name')
        ->where('cargo_id',9)
        ->orderBy('name')
        ->get();
        return $superintendentes;
    }

    public function getGerentes()
    {
        $gerentes = User::select('id','name')
        ->where('cargo_id',2)
        ->orderBy('name')
        ->get();
        return $gerentes;
    }

    public function getCoordenadores($setor)
    {

        $coordenadors = User::select('id','name')
        ->where('cargo_id',7)
        ->when($setor > 0, function($query) use ($setor) {
            return $query->where('setor_id',$setor);
        })
        ->orderBy('name')
        ->get();
        return $coordenadors;
    }

    public function forgetCache()
    {
        // Cache::forget('getSetores');
        // Cache::forget('getCargos');
        // Cache::forget('getCarteiras');
        // users cache
        Cache::forget('getSuperintendentes');
        Cache::forget('getGerentes');
        Cache::forget('getCoordenadores');
        Cache::forget('getSupervisores');
        Cache::forget('usersMonitoriaEscobs');
        Cache::forget('usersMonitoriaCallCenter');
    }

    /* DATA */
    /**
     *
     */
    public function getMonitors()
    {
        return User::where('cargo_id',15)
                    ->when(in_array(64,Session::get('permissionsIds')), function($q) {
                        return $q->whereRaw('NOT carteira_id = 1');
                    }) // Quando é escobs
                    ->when(!in_array(64,Session::get('permissionsIds')), function($q) {
                        return $q->where('carteira_id',1);
                    }) // Quando é CallCenter
                    ->get();
    }
}
