<?php

namespace App\Http\Controllers\Monitoria;

use App\Http\Controllers\Controller;
use App\Monitoria\Laudo;
use App\Monitoria\Monitoria;
use App\Monitoria\MonitoriaItem;
use App\Monitoria\MotivoContestar AS Motivo;
use App\Monitoria\Contestacoes;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Tools\Tools;
use App\Http\Controllers\Users\Users;
use App\Users\Ilha;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Cache;
use DateTime;
use Illuminate\Support\Facades\Hash;

class Monitorias extends Controller
{
    /**
     * Retorna view principal de monitorias
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Cache::flush();
            if(Session::get('pwIsDf') == 1) {
                return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
            }

            $cargo = Auth::user()->cargo_id;
            $id = Auth::id();
            if(is_null($cargo) || is_null($id)) {
                return back()->withErrors(['errorAlert' => 'Você pode não ter permissão para acessar essa página']);
            }

            // registra que usuário está online
            $users = new Users();
            @$users->saveLogin($id);

            $title = 'Monitoria';

            // Permissões
            $permissions = Session::get('permissionsIds');
            $webMaster = in_array(1, $permissions);
            $criarLaudo = in_array(18, $permissions);
            $excluirLaudo = in_array(22, $permissions);
            $isMonitor = in_array(25, $permissions);
            $isMonitor = in_array(25, $permissions);
            $dash = in_array(47,$permissions);
            $aplicarLaudo = in_array(50, $permissions);
            $export = in_array(51,$permissions);
            $isSupervisor = in_array(52, $permissions);
            $editarLaudo = in_array(53, $permissions);
            $editarMonitoria = in_array(54, $permissions);
            $excluirMonitoria = in_array(55, $permissions);
            $seeAll = in_array(61, $permissions);
            $motivosContestar = in_array(65, $permissions);
            $gestorMonitoria = in_array(66, $permissions);

            //permissões de consulta
            $all = in_array(24, $permissions);
            $carteira = in_array(23, $permissions);
            $escobs = in_array(64, $permissions);

            // Verifica nome de caches de usuários
            if($escobs) {
                $usersCacheName = 'usersMonitoriaEscobs';
                $laudosCacheName = 'modelosMonitoriaEscobs';
            } else {
                $usersCacheName = 'usersMonitoriaCallCenter';
                $laudosCacheName = 'modelosMonitoriaCallCenter';
            }

            // Verifica se usuário é monitor ou dev
            if($isMonitor || $webMaster) {
                // Carrega modelos de monitoria
                $models = $this->carregaModelos($aplicarLaudo, $editarLaudo, $webMaster, $all, $escobs, $carteira, $laudosCacheName, Auth::user()->carteira_id);

                // Carrega Monitorias
                $monitorias = $this->carregarMonitorias($gestorMonitoria, $seeAll, $all, $carteira, $escobs, $id, Auth::user()->carteira_id, Auth::user()->cargo_id);

                // Carrega usuários
                $usersFiltering = $this->carregarUsuarios($usersCacheName, $escobs, $all, $carteira, Auth::user()->carteira_id);

            } else {// Senão, é supervisor
                return $this->indexSup($id);
            }

            $motivos = Motivo::all();

            $compact = compact('title', 'escobs', 'models', 'monitorias', 'usersFiltering', 'permissions', 'webMaster', 'dash', 'export', 'criarLaudo', 'excluirLaudo', 'editarMonitoria', 'excluirMonitoria', 'aplicarLaudo', 'editarLaudo', 'isMonitor', 'isSupervisor', 'motivos', 'motivosContestar', 'gestorMonitoria');
            return view('monitoring.manager',$compact);
        } catch (\Exception $e) {
            return back()->with('errorAlert','Erro de Rede, tente novamente');
        }
    }

    /**
     * Carrega usuários para aplicar monitoria
     *
     * @param string $usersCacheName
     * @param bool $escobs
     * @param bool $all
     * @param bool $carteira
     * @param int $carteira_id
     * @return Cache|App\User
     */
    public function carregarUsuarios(string $usersCacheName, bool $escobs, bool $all, bool $carteira, int $carteira_id)
    {
        // verifica qual carteira o monitor tem visualização
        if($escobs) {
            $searchCarteira = 'NOT users.carteira_id = 1';
        } else if($all) {
            $searchCarteira = '1';
        } else if($carteira) {
            $searchCarteira = 'users.carteira_id = '.$carteira_id;
        } else {
            $searchCarteira = 'users.carteira_id = '.$carteira_id;
        }

        // verifica se os usuários carregados serão escobs ou callcenter
        if($escobs) {
            // verifica se existe cache ou carrega os dados do banco
            if(!is_null(Cache::get($usersCacheName))) {
                $usersFiltering = Cache::get($usersCacheName);
            } else {
                $usersFiltering = User::selectRaw('users.id, users.username, users.name, users.matricula')->whereRaw('NOT carteira_id = 1 AND cargo_id IN (5,13)')->get();
                Cache::put($usersCacheName,$usersFiltering,720);
            }
        } else {
            // verifica se existe cache ou carrega os dados do banco (FALSE para controle)
            if(!is_null(Cache::get($usersCacheName)) && FALSE) {
                $usersFiltering = Cache::get($usersCacheName);
            } else {
                $usersFiltering = DB::select('SELECT users.id, users.username, users.name, users.matricula, (SELECT COUNT(monitorias.id) FROM book_monitoria.monitorias WHERE created_at >= "'.date("Y-m-01 00:00:00").'" AND operador_id = users.id AND deleted_at IS NULL) AS ocorrencias FROM book_usuarios.users LEFT JOIN book_monitoria.monitorias ON users.id = monitorias.operador_id WHERE '.$searchCarteira.' AND users.cargo_id = 5 AND ISNULL(users.deleted_at) GROUP BY users.id, users.name , users.username, users.matricula ORDER BY ocorrencias, name;');
                Cache::put($usersCacheName,$usersFiltering,720);
            }
        }

        return $usersFiltering;
    }

    /**
     * Carrega monitorias de acordo com o perfil do usuário
     *
     * @param bool $gestorMonitoria
     * @param bool $seeAll
     * @param bool $all
     * @param bool $carteira
     * @param bool $escobs
     * @param int $id
     * @param int $carteira_id
     * @param int $cargo
     * @return App\Monitoria\Monitoria
     */
    public function carregarMonitorias(bool $gestorMonitoria, bool $seeAll, bool $all, bool $carteira, bool $escobs, int $id, int $carteira_id, int $cargo)
    {
       return Monitoria::selectRaw('monitorias.*, users.name')
                                            ->leftJoin('book_usuarios.users','users.id','monitorias.operador_id')
                                            ->when(!$seeAll, function($q) use($id, $all, $carteira, $escobs, $carteira_id, $cargo) {
                                                // Se o usuário não tem permissão para ver tudo
                                                if(!$all || $gestorMonitoria) {
                                                    // Se o usuário só tem perimssão para ver a carteira dele
                                                    if($carteira) {
                                                        $q->where('users.carteira_id',$carteira_id);
                                                    // Se o usuário é um Monitor Escobs
                                                    } else if($escobs) {
                                                        $q->whereRaw('NOT users.carteira_id = 1');
                                                    }

                                                    // Se é monitor, só vê suas prórpias monitorias
                                                    if($cargo === 15) {
                                                        $q->where('monitorias.monitor_id',$id);
                                                    }
                                                }

                                                return $q;
                                            })
                                            ->where('monitorias.created_at','>=',date('Y-m-d H:i:s', strtotime('-45 Days')))
                                            ->orderBy('monitorias.created_at','DESC')
                                            ->orderBy('users.name') //ASC
                                            ->paginate(env('PAGINATE_NUMBER'));
    }

    /**
     * Verifica se o usuário tem permissão de ver cache
     *
     * @param bool $aplicarLaudo
     * @param bool $editarLaudo
     * @param bool $webMaster
     * @param bool $all
     * @param bool $escobs
     * @param bool $carteira
     * @param bool $laudosCacheName
     * @param int $carteira_id
     * @return array|Cache|App\Monitoria\Laudo
     */
    public function carregaModelos(bool $aplicarLaudo, bool $editarLaudo, bool $webMaster, bool $all, bool $escobs, bool $carteira, bool $laudosCacheName, int $carteira_id)
    {
        // Verifica se o usuário póssui permissão de aplicar laudo
        if($aplicarLaudo || $editarLaudo || $webMaster) {
            // Verifica se existe cache de laudos
            if(!is_null(Cache::get($laudosCacheName)) && FALSE) {
                $models = Cache::get($laudosCacheName);
            } else {
                $models = Laudo::select('titulo','id','updated_at')
                                ->orderBy('utilizacoes','DESC')
                                ->orderBy('id','DESC')
                                ->when(($carteira || $escobs), function($q) use($all, $escobs, $carteira_id){
                                    if($all) {
                                        return $q;
                                    } else if($escobs) {
                                        return $q->whereRaw('NOT carteira_id = 1');
                                    }
                                    return $q->where('carteira_id',$carteira_id);
                                })
                                ->get();
                Cache::put($laudosCacheName, $models, 720);
            }
        } else {
            $models = [];
        }
        return $models;
    }

    /**
     * Carrega Tela de Monitoria do Supervisor
     *
     * @param int $id
     * @return Illuminate\Http\Request
     */
    public function indexSup(int $id)
    {
        $title = 'Monitoria / Supervisor';

        $media = Monitoria::selectRaw("CAST(AVG(media) AS DECIMAL(5,2)) AS media")
                        ->where('supervisor_id', $id)
                        ->where('created_at','>=',DB::raw('DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 30 DAY)'))
                        ->get()[0]->media;


        $monitorias = Monitoria::where('supervisor_id',$id)
                                ->orderBy(DB::Raw('case WHEN ISNULL(feedback_supervisor) THEN 0 ELSE 1 end')) //ASC
                                ->orderBy('created_at','DESC')
                                ->paginate(25);

        $motivos = Motivo::all();

        $compact = compact(
            'monitorias',
            'motivos',
            'media',
            'title'
        );

        return view('monitoring.managerSuper', $compact);
    }


    // Adiciona motivo de Contestação
    public function addContest(Request $request)
    {
        try {
            $request->validate(['name' => 'required|max:255'],['name.required' => 'Digite o motivo', 'max.required' => 'Máximo de 255 caracteres!']);
            $motivo = new Motivo();
            $motivo->name = $request->name;
            $motivo->creator_id = Auth::id();
            if($motivo->save()) {
                return redirect(url()->previous())->with('successAlert','Inserido com sucesso!');
            }

            return back()->with('errorAlert','Erro');
        } catch (\Exception $e) {
            return back()->with('errorAlert',$e->getMessage());
        }
    }

    // Deleta motivo de contestação
    public function deleteContest($id)
    {
        try {
            if(is_null($id)) {
                return back()->with('errorAlert','ID inválido, recarregue e tente novamente');
            }

            $motivo = Motivo::find($id);

            if(is_null($motivo)) {
                return back()->with('errorAlert','Motivo inxistente, recarregue a página para atualizar');
            }

            if($motivo->delete()) {
                return back()->with('successAlert','Excluído com sucesso!');
            }

            return back()->with('errorAlert','Erro ao excluir, Contate o suporte e pass o código: '.date('YmdHis').$id);

        } catch (\Exception $e) {
            return back()->with('errorAlert',$e->getMessage());
        }
    }

    public function searchInTable(Request $request)
    {
        $str = $request->str;
        $searchData = Tools::ajustarBusca($str);

        $data = Monitoria::select('monitorias.*','op.name AS operador','sp.name AS supervisor','mo.name AS monitor')
                        ->leftJoin('book_usuarios.users AS op','op.id','monitorias.operador_id')
                        ->leftJoin('book_usuarios.users AS mo','mo.id','monitorias.monitor_id')
                        ->leftJoin('book_usuarios.users AS sp','sp.id','monitorias.supervisor_id')
                        ->when(true,function($q) use ($searchData) {
                        $orderBy = ' case ';
                        foreach(explode('.+',$searchData) as $item) {
                            $q->orWhereRaw('op.name REGEXP  "'.$item.'"');
                            $q->orWhereRaw('mo.name  REGEXP  "'.$item.'"');
                            $q->orWhereRaw('sp.name REGEXP  "'.$item.'"');
                            $q->orWhereRaw('monitorias.id_audio REGEXP  "'.$item.'"');
                            $q->orWhereRaw('monitorias.usuario_cliente REGEXP  "'.$item.'"');
                            $q->orWhereRaw('monitorias.cpf_cliente REGEXP  "'.$item.'"');

                            $orderBy .= 'when operador REGEXP  "'.$item.'" then 1  ';
                            $orderBy .= 'when operador REGEXP  "'.$item.'" AND monitor  REGEXP  "'.$item.'" then 2  ';
                            $orderBy .= 'when operador REGEXP  "'.$item.'" AND monitor  REGEXP  "'.$item.'" AND supervisor REGEXP  "'.$item.'" then 3  ';
                            $orderBy .= 'when operador REGEXP  "'.$item.'" AND monitor  REGEXP  "'.$item.'" AND supervisor REGEXP  "'.$item.'" AND monitorias.id_audio REGEXP  "'.$item.'" then 4  ';
                            $orderBy .= 'when operador REGEXP  "'.$item.'" AND monitor  REGEXP  "'.$item.'" AND supervisor REGEXP  "'.$item.'" AND monitorias.id_audio REGEXP  "'.$item.'" AND monitorias.usuario_cliente REGEXP  "'.$item.'" then 4  ';
                            $orderBy .= 'when operador REGEXP  "'.$item.'" AND monitor  REGEXP  "'.$item.'" AND supervisor REGEXP  "'.$item.'" AND monitorias.id_audio REGEXP  "'.$item.'" AND monitorias.usuario_cliente REGEXP  "'.$item.'" AND monitorias.cpf_cliente REGEXP  "'.$item.'" then 6  ';
                        }

                        $orderBy .= ' else 0 end DESC';

                        $q->orderByRaw($orderBy);

                        return $q;
                    })->get();

        return $data;
    }

    public function store(Request $request, $user)
    {
        $rules = [
            'operador' => 'required',
            'hr_call' => 'required',
            'hr_tp_call' => 'required',
            'tp_call' => 'required',
            'hash' => 'required',
            'modelo_id' => 'required',
            'dt_call' => 'required',
            'media' => 'required',
            'conf' => 'required',
            'nConf' => 'required',
            'nAv' => 'required',
        ];

        $request->validate($rules,['required' => 'O campo :attribute não pode ser vazio']);

        // itens da monitoria
        $MonitoriaItem = [];

        // trata variáveis para salvar
        $operador = $request->input('operador');
        $supervisor = User::select('supervisor_id')->where('id',$operador)->first('supervisor_id')['supervisor_id'];

        // Dados do Monitor
        $monitor = User::find($user);
        if(is_null($monitor)) {
            return response()->json(['msg' => 'Erro de dados do Monitor, contate o suporte!'], 422);
        }

        $ncg = 0;

        $horaCall = $request->input('hr_call');
        $tpCall = $request->input('hr_tp_call');
        $dtCall = $request->input('dt_call');

        // dados do form
        $modelo = $request->input('modelo_id');
        $media = $request->input('media');
        $conf = $request->input('conf');
        $nConf = $request->input('nConf');
        $nAv = $request->input('nAv');
        $ncg = $request->input('ncg');
        $id_audio = $request->input('id_audio');
        $hash = $request->input('hash');

        // verifica duplicidade
        $check = Monitoria::where('id_audio',$id_audio)
                            ->where('monitor_id',$user)
                            ->where('operador_id',$operador)
                            ->where('hash_monitoria',$hash)
                            ->where('created_at', '>=', date('Y-m-d H:i:s',strtotime('-2 Minutes')))
                            ->count();

        if($check > 0) {
            return response()->json(['msg' => 'Monitoria em duplicidade!'], 422);
        }

        // Verifica se media está correta e verifica NCG
        if($ncg > 0) {
            unset($media);
            $media = 0;
        }

        if($monitor->carteira_id == 1) {
            // Calcula quartil
            if($media >= 93) {
                $quartil = 'Q1';
            } else if($media >= 80) {
                $quartil = 'Q2';
            } else if ($media >= 50) {
                $quartil = 'Q3';
            } else {
                $quartil = 'Q4';
            }
        } else {
            if($media >= 95) {
                $quartil = 'Q1';
            } else if($media >= 90) {
                $quartil = 'Q2';
            } else if ($media >= 86) {
                $quartil = 'Q3';
            } else {
                $quartil = 'Q4';
            }
        }

        // grava monitoria
        $monitoria = new Monitoria();
        $monitoria->quartil = $quartil;
        $monitoria->monitor_id = $user;
        $monitoria->operador_id = $operador;
        $monitoria->supervisor_id = $supervisor;
        $monitoria->usuario_cliente = $request->input('userCli');
        $monitoria->produto = $request->input('produto');
        $monitoria->cliente = $request->input('nome_cliente');
        $monitoria->tipo_ligacao = $request->input('tp_call');
        $monitoria->cpf_cliente = $request->input('cpf_cliente');
        $monitoria->data_ligacao = $dtCall;
        $monitoria->hora_ligacao = $horaCall;
        $monitoria->id_audio = $id_audio;
        $monitoria->tempo_ligacao = $tpCall;
        $monitoria->pontos_positivos = $request->input('pt_pos');
        $monitoria->pontos_desenvolver	 = $request->input('pt_dev');
        $monitoria->pontos_atencao = $request->input('pt_att');
        $monitoria->hash_monitoria = $hash;
        $monitoria->media = $media;
        $monitoria->conf = $conf;
        $monitoria->nConf = $nConf;
        $monitoria->nAv = $nAv;
        $monitoria->ncg = $ncg;
        $monitoria->feedback_monitor = $request->input('feedback');
        $monitoria->modelo_id = $modelo;
        if($monitor->carteira_id > 1) {
            $monitoria->supervisor_at = date('Y-m-d H:i:s');
            $monitoria->feedback_supervisor = $request->input('feedback');
        }

        if($monitoria->save()) {
            //id da monitoria e tratamento de laudos
            $monitoria_id = $monitoria->id;
            $laudosData = explode('_____',substr($request->input('laudos'),0,-5));

            // laudos de monitoria
            foreach ($laudosData as $itens) {
                $i = explode('|||||',$itens);
                if(isset($i[1])) {
                    $MonitoriaItem[] = [
                        'value' => $i[1],
                        'id_laudo_item' => $i[0],
                        'monitoria_id' => $monitoria_id,
                        'ncg' => $i[2],
                        'value_pct'=> $i[3],
                        'obs' => $i[4],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }

            }

            // grava laudos
            if($monitoriaLaudos = MonitoriaItem::insert($MonitoriaItem)) {
                // Checa se foi inserido corretamente
                if(MonitoriaItem::where('monitoria_id',$monitoria_id)->count() === 0) {
                    MonitoriaItem::where('monitoria_id',$monitoria_id)->delete();
                    Monitoria::find($monitoria_id)->delete();

                    return response()->json(['success' => FALSE, 'msg' => 'Erro ao salvar Itens da Monitoria!<br>contate o suporte e passe o seguinte código: <b>#'.$monitoria_id.'</b>'], 500);
                }
                // marca modelo como usado
                $marcaLaudoModelo = Laudo::find($modelo);
                $marcaLaudoModelo->utilizacoes++;
                $marcaLaudoModelo->save();

                return response()->json(['success' => TRUE, 'msg' => 'Monitoria Salva!'], 201);
            } else {
                Monitoria::find($monitoria_id)->delete();
                MonitoriaItem::where('monitoria_id',$monitoria_id)->delete();
                return response()->json($monitoriaLaudos->errors()->all(), 500);
            }
        }

        return response()->json($monitoria->errors()->all(), 500);

    }

    public function findmonitoringByOperator(){
        return view('reports.monitoring.findOperator');
    }

    // Mostra resultados da monitoria
    public function view($id) {
        $monitoria = DB::select('SELECT DISTINCT
                                moni.name AS moniName, sup.name supName, i.numero, i.questao, i.sinalizacao, mi.value, o.name as operador, m.*
                                FROM book_monitoria.monitorias as m
                                LEFT JOIN book_usuarios.ilhas as ilhas /*ilha*/
                                ON m.produto = ilhas.id
                                LEFT JOIN book_usuarios.users as o /*Operador*/
                                ON o.id = m.operador_id
                                LEFT JOIN book_usuarios.users as sup /*Supervisor*/
                                ON sup.id = m.supervisor_id
                                LEFT JOIN book_usuarios.users as moni /*Monitor*/
                                ON moni.id = m.monitor_id
                                LEFT JOIN book_monitoria.laudos_modelos as model /*modelo de monitoria*/
                                ON model.id = m.modelo_id
                                LEFT JOIN book_monitoria.laudos_itens as i  /*itens de monitoria*/
                                ON i.modelo_id = model.id
                                INNER JOIN book_monitoria.monitoria_itens as mi  /*resposta do operador*/
                                ON mi.id_laudo_item = i.id AND mi.monitoria_id = m.id
                                WHERE m.id = ?;',
                                [$id]
        );

        return $monitoria;
    }

    //edita monitoria
    public function edit($id, Request $request)
    {
        $title = 'Editar Monitoria';
        $monitoria = Monitoria::find($id);

        $users = User::select('id','name','supervisor_id')
                    ->whereIn('cargo_id',[5])
                    ->orderBy('name')
                    ->get();

        $supers = User::select('id','name')
                    ->whereIn('cargo_id',[4])
                    ->orderBy('name')
                    ->get();

        $ilhas = Ilha::select('id','name')
                    ->orderBy('name')
                    ->get();

        $itens = MonitoriaItem::where('monitoria_id',$id)
                                ->orderBy('id_laudo_item')
                                ->get();

        $laudo = Laudo::withTrashed()->where('id',$monitoria->modelo_id)->get();

        $operador = User::selectRaw('users.id, users.name, s.name AS supervisor')
                ->join('book_usuarios.users AS s', 's.id', 'users.supervisor_id')
                ->where('users.id',@$request->userToApply)
                ->get();

        if($operador->count() > 0) {
            return view('monitoring.makeMonitoria',compact('itens', 'laudo' ,'monitoria', 'supers', 'ilhas', 'users', 'title', 'id', 'operador'));
        }

        return view('monitoring.makeMonitoria',compact('itens', 'laudo' ,'monitoria', 'supers', 'ilhas', 'users', 'title', 'id'));
    }

    //registra edição
    public function update(Request $request, $id, $user) {
        $rules = [
            'operador' => 'required',
            'hr_call' => 'required',
            'hr_tp_call' => 'required',
            'userCli' => 'required',
            'nome_cliente' => 'required',
            'tp_call' => 'required',
            'id_audio' => 'required',
            'pt_pos' => 'required',
            'pt_dev' => 'required',
            'pt_att' => 'required',
            'hash' => 'required',
            'modelo_id' => 'required',
            'dt_call' => 'required',
            'media' => 'required',
            'conf' => 'required',
            'nConf' => 'required',
            'nAv' => 'required',
        ];
        // itens da monitoria
        $MonitoriaItem = [];

        $request->validate($rules,['required' => 'O campo :attribute não pode ser vazio']);

        // trata variáveis para salvar
        $operador = $request->input('operador');
        $supervisor = User::select('supervisor_id')->where('id',$operador)->first('supervisor_id')['supervisor_id'];

        // Dados do Monitor
        $monitor = User::find($user);
        if(is_null($monitor)) {
            return response()->json(['msg' => 'Erro de dados do Monitor, contate o suporte!'], 422);
        }

        $ncg = 0;

        $horaCall = $request->input('hr_call');
        $tpCall = $request->input('hr_tp_call');
        $dtCall = $request->input('dt_call');

        // dados do form
        $modelo = $request->input('modelo_id');
        $media = $request->input('media');
        $conf = $request->input('conf');
        $nConf = $request->input('nConf');
        $nAv = $request->input('nAv');
        $ncg = $request->input('ncg');
        $id_audio = $request->input('id_audio');
        $hash = $request->input('hash');

        // verifica duplicidade
        $check = Monitoria::where('id_audio',$id_audio)
                            ->where('monitor_id',$user)
                            ->where('operador_id',$operador)
                            ->where('hash_monitoria',$hash)
                            ->where('created_at', '>=', date('Y-m-d H:i:s',strtotime('-2 Minutes')))
                            ->count();

        if($check > 0) {
            return response()->json(['msg' => 'Monitoria já registrada'], 201);
        }

        // Verifica se media está correta e verifica NCG
        if($ncg > 0) {
            unset($media);
            $media = 0;
        }

        // Calcula quartil
        if($monitor->carteira_id == 1) {
            // Calcula quartil
            if($media >= 93) {
                $quartil = 'Q1';
            } else if($media >= 80) {
                $quartil = 'Q2';
            } else if ($media >= 50) {
                $quartil = 'Q3';
            } else {
                $quartil = 'Q4';
            }
        } else {
            if($media >= 95) {
                $quartil = 'Q1';
            } else if($media >= 90) {
                $quartil = 'Q2';
            } else if ($media >= 86) {
                $quartil = 'Q3';
            } else {
                $quartil = 'Q4';
            }
        }

        // grava monitoria
        $monitoria = Monitoria::find($id);
        $monitoria->quartil = $quartil;
        $monitoria->monitor_id = $user;
        $monitoria->operador_id = $operador;
        $monitoria->supervisor_id = $supervisor;
        $monitoria->usuario_cliente = $request->input('userCli');
        $monitoria->produto = $request->input('produto');
        $monitoria->cliente = $request->input('nome_cliente');
        $monitoria->tipo_ligacao = $request->input('tp_call');
        $monitoria->cpf_cliente = $request->input('cpf_cliente');
        $monitoria->data_ligacao = $dtCall;
        $monitoria->hora_ligacao = $horaCall;
        $monitoria->id_audio = $id_audio;
        $monitoria->tempo_ligacao = $tpCall;
        $monitoria->pontos_positivos = $request->input('pt_pos');
        $monitoria->pontos_desenvolver	 = $request->input('pt_dev');
        $monitoria->pontos_atencao = $request->input('pt_att');
        $monitoria->hash_monitoria = $hash;
        $monitoria->media = $media;
        $monitoria->conf = $conf;
        $monitoria->nConf = $nConf;
        $monitoria->nAv = $nAv;
        $monitoria->ncg = $ncg;
        $monitoria->feedback_monitor = $request->input('feedback');
        $monitoria->modelo_id = $modelo;
        if($monitoria->save()) {
            //id da monitoria e tratamento de laudos
            $monitoria_id = $monitoria->id;
            $laudosData = explode('_____',substr($request->input('laudos'),0,-5));

            $monitoriaLaudos = MonitoriaItem::where('monitoria_id', $id)->get();

            // configura itens de monitoria para edição
            foreach ($laudosData as $itens) {
                $i = explode('|||||',$itens);
                if(isset($i[1])) {
                    $MonitoriaItem[] = [
                        'value' => $i[1],
                        'ncg' => $i[2],
                        'value_pct'=> $i[3],
                        'obs'=> $i[4],
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }

            }

            $n=0;
            $error = 0;
            // Edita os dados
            foreach($monitoriaLaudos as $laudo) {
                $laudo->value = $MonitoriaItem[$n]['value'];
                $laudo->ncg = $MonitoriaItem[$n]['ncg'];
                $laudo->value_pct = $MonitoriaItem[$n]['value_pct'];
                $laudo->obs = $MonitoriaItem[$n]['obs'];
                $laudo->updated_at = $MonitoriaItem[$n]['updated_at'];
                if(!$laudo->save()) {
                    $error++;
                }
                $n++;
            }

            // grava laudos
            if($error === 0) {
                $log = new Logs();
                $log->log("INSERT_MONITORIA", NULL, 'INSERT_MONITORIA', $user, '1');
                return response()->json(['success' => TRUE, 'msg' => 'Monitoria Alterada!'], 201);
            } else {
                return response()->json($monitoriaLaudos->errors()->all(), 500);
                Monitoria::where($monitoria_id)->delete();
            }
        }

        return response()->json($monitoria->errors()->all(), 500);
    }

    // Exclui monitoria
    public function delete($user,$id) {
        if($delete = Monitoria::find($id)->delete()) {
            // regitra log
            $log = new Logs();
            $log->log("DELETE_MONITORIA", $id, 'delete_monitoria', $user, intval(@User::find($user)->ilha_id));

            if(MonitoriaItem::where('monitoria_id',$id)->delete()) {
                return response()->json(['success' => TRUE, 'msg' => 'Monitoria e Itens Excluídos com sucesso!'], 200);
            }
            return response()->json(['success' => TRUE, 'msg' => 'Monitoria Excluída com sucesso!<br>Entre em contato com o desenvolvimento para excluir os itens da monitoria'], 200);
        }

        return response()->json($delete->errors()->all(), 500);
    }

    // monta itens de navBar monitoria para Supervisores
    public function navSuper($id) {
        $monitorias = Monitoria::select('monitorias.id', 'monitorias.created_at', 'u.name')
                                ->leftJoin('book_usuarios.users AS u','monitorias.operador_id','u.id')
                                ->where('monitorias.supervisor_id',$id)
                                ->whereRaw('monitorias.feedback_supervisor IS NULL AND monitorias.deleted_at IS NULL')
                                ->count();
        return $monitorias;
    }

    public function navOpe($id) {
            $monitoria = DB::select('SELECT DISTINCT
                    i.numero, i.questao, i.sinalizacao, mi.value, o.name as operador, m.*
                    FROM book_monitoria.monitorias as m
                    LEFT JOIN book_usuarios.ilhas as ilhas /*ilha*/
                    ON m.produto = ilhas.id
                    LEFT JOIN book_usuarios.users as o /*Operador*/
                    ON o.id = m.operador_id
                    LEFT JOIN book_monitoria.laudos_modelos as model /*modelo de monitoria*/
                    ON model.id = m.modelo_id
                    LEFT JOIN book_monitoria.laudos_itens as i  /*itens de monitoria*/
                    ON i.modelo_id = model.id
                    INNER JOIN book_monitoria.monitoria_itens as mi  /*resposta itens conforme, nC, nA*/
                    ON mi.id_laudo_item = i.id AND mi.monitoria_id = m.id
                    WHERE m.operador_id = ?
                    AND m.hash_operator IS NULL
                    AND NOT m.feedback_supervisor IS NULL
                    AND m.deleted_at IS NULL
                    LIMIT 1;',[$id]);

        return $monitoria;
    }

    function operatorFeedback($id, $option, Request $request) {
        $hash = $request->input('hash');
        $feedback = $request->input('feedback');

        $fb = Monitoria::find($id);
        $fb->hash_operator = $hash;
        $fb->feedback_operador = $feedback;
        $fb->resp_operador = $option;
        $fb->operador_at = date('Y-m-d H:i:s');
        if($fb->save()) {
            return response()->json(['msg' => 'Feedback salvo!'], 201);
        }

        return response()->json($fb->errors()->all(), 500);
    }

    function supervisorFeedback($id, Request $request) {
        $feedback = $request->input('feedback');

        $fb = Monitoria::find($id);
        $fb->feedback_supervisor = $feedback;
        $fb->supervisor_at = date('Y-m-d H:i:s');
        if($fb->save()) {
            return response()->json(['msg' => 'Feedback salvo!'], 201);
        }

        return response()->json($fb->errors()->all(), 500);
    }

    //Altera supervisor nas monitorias do operador $id
    public function changeAllSupers($id, $sup)
    {
        Monitoria::where('operador_id',$id)
                ->update(['supervisor_id' => $sup]);
    }

    /**
     * Filtra monitorias
     *
     * @param mixed $campo
     * @param mixed $valor
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response|App\Monitoria\Monitoria
     */
    public function pesquisar($campo, $valor, Request $request) {
        // dados do usuário
        $id = Auth::id();
        $cargo = Auth::user()->cargo_id;

        // dados da requisição (form)
        $feedback = $request->feedback;
        $periodo = $request->periodo;
        $datain = $request->datain;
        $datafin = $request->datafi;

        // permissões
        $gestorMonitoria = in_array(66, Session::get('permissionsIds'));

        // verifica se data inicial é maior do que a final
        if($datain > $datafin) {
            return response()->json(['errorAlert' => 'Data inicial não pode ser maior do que a data final!']);
        }

        //  Filrta intervalo de meses na data a fim de evitar que os resultados da query fiquem muito grandes
        $data1 = new DateTime($datain);
        $data2 = new DateTime($datafin);

        $intervalo = $data1->diff($data2);
        if($intervalo->m > 3) {
            return response()->json(['errorAlert' => 'Diferença entre datas não pode ser maior do que 3 meses!']);
        }

        // Atualizando no banco de dados
        return Monitoria::selectRaw('monitorias.id AS monitoria, monitorias.data_ligacao AS dataligacao,monitorias.id_audio AS audio, monitorias.media AS media, o.name AS operador, s.name AS supervisor, m.name AS monitor, monitorias.feedback_supervisor')
                        ->leftJoin('book_usuarios.users AS o','o.id','monitorias.operador_id')
                        ->leftJoin('book_usuarios.users AS m','m.id','monitorias.monitor_id')
                        ->leftJoin('book_usuarios.users AS s','s.id','monitorias.supervisor_id')
                        ->when(1, function($q) use ($campo, $valor) {
                            switch ($campo) {
                                case 'monitoria':
                                    return $q->where('monitorias.id', '=', $valor);
                                    break;

                                case 'operador':
                                    return $q->whereRaw("o.name LIKE '%$valor%'");
                                    break;

                                case 'supervisor':
                                    return $q->whereRaw("s.name LIKE '%$valor%'");
                                    break;

                                case 'monitor':
                                    return $q->whereRaw("m.name LIKE '%$valor%'");
                                    break;

                                case 'usuariocliente':
                                    return $q->where('monitorias.usuario_cliente', '=', $valor);
                                    break;

                                case 'matricula':
                                    return $q->where('o.matricula', '=', $valor);
                                    break;

                                case 'periodo':
                                        return $q->whereRaw('created_at BETWEEN '.$valor);
                                        break;

                                default:
                                    return $q->whereBetween($campo, $valor);
                                    break;
                            }
                        })
                        // quando o filtro for apenas de feedbacks aplicados
                        ->when(1,  function($q) use ($feedback) {
                            if($feedback == 'true') {
                                return $q->whereRaw('NOT ISNULL(feedback_supervisor)');
                            } else {
                                return $q->whereRaw('ISNULL(feedback_supervisor)');
                            }

                        })
                        // quando pfor selecionada a pesquisa por período
                        ->when($periodo == 'periodo',  function($q) use ($datain, $datafin) {
                            return $q->whereBetween('created_at', [$datain.' 00:00:00', $datafin.' 23:59:59']);
                        })
                        // Quando cargo_id do usuário for 4 (supervisor)
                        ->when($cargo == 4, function($q) use($id){
                            return $q->where('supervisor_id',$id);
                        })
                        // Quando cargo_id do usuário for 15 (monitor)
                        ->when($cargo == 15, function($q) use($id, $gestorMonitoria){
                            if($gestorMonitoria) {
                                return $q;
                            }
                            return $q->where('monitor_id',$id);
                        })
                        ->get();
    }

    /**
     * Grava feedback escobs, com o monitor junto ao operador
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function feedbackEscobs(int $id, Request $request) {
        // Validação de formulário
        $rules = [
            'feedback' => 'required',
            'passwd' => 'required',
            'monitoria_id' => 'required',
        ];

        $msgs = [
            'feedback.required' => 'Preencha corretamente o campo feedback',
            'passwd.required' => 'Preencha o campo senha!',
            'monitoria_id.required' => 'Monitoria inválida!',
        ];

        $request->validate($rules, $msgs);

        // Dados do form
        $feedback = $request->feedback;
        // $hash = $request->hash;
        $id = $request->monitoria_id;
        // $option = $request->option;
        $passwd = $request->passwd;

        // Checa SE monitoria existe (não é nula)
        $monitoria = Monitoria::find($id);
        if(is_null($monitoria)) {
            $data = ['errorAlert' => 'Monitoria apagada ou inválida, contate o suporte'];
            $status = 422;
        } else {
            // variável de controle de erros
            $error = 0;

            // Monitor e Operador
            $monitor_id = Auth::id();
            $operador_id = $monitoria->operador_id;


            // busca operador para checar senha
            $operador = User::find($operador_id);
            $monitor = User::find($monitor_id);

            // Checa se operador existe
            if(is_null($operador)) {
                $error++;
                $data = ['errorAlert' => 'Operador inválido, contate o treinamento!'];
                $status = 422;
            }

            // Checa se monitor existe
            if(is_null($monitor)) {
                $error++;
                $data = ['errorAlert' => 'Monitor inválido, contate o suporte!'];
                $status = 422;
            }

            if($error === 0) {
                // checa se senha é igual a do operador
                if(!Hash::check($passwd, $operador->password)) {
                    // checa se senha é igual a do monitor
                    if(!Hash::check($passwd, $monitor->password)) {
                        $error++;
                        $data = ['errorAlert' => 'Senhas não conferem!'];
                        $status = 422;
                    }
                    $resp_operador = 0;
                } else {
                    $resp_operador = 1;
                }

                // Se não há erros, feedback monitoria
                if($error === 0) {
                    $monitoria->feedback_operador = $feedback;
                    $monitoria->resp_operador = $resp_operador;
                    if($monitoria->save()) {
                        $data = ['successAlert' => 'Feedback Registrado!'];
                        $status = 201;
                    } else {
                        $data = ['errorAlert' => 'Erro ao registrar feedback, contate o suporte!'];
                        $status = 422;
                    }
                }
            }

        }

        return response()->json($data, $status);
    }
}
