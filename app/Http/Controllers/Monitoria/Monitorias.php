<?php

namespace App\Http\Controllers\Monitoria;

use App\Http\Controllers\Controller;
use App\Monitoria\Laudo;
use App\Monitoria\Monitoria;
use App\Monitoria\MonitoriaItem;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Users\Users;
use App\Users\Ilha;
use App\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Monitorias extends Controller
{
    public function index()
    {
        try {
            $cargo = Auth::user()->cargo_id;
            $id = Auth::id();
            if(is_null($cargo) || is_null($id)) {
                return back()->withErrors(['errorAlert' => 'Você pode não ter permissão para acessar essa página']);
            }

            // registra que usuário está online
            $users = new Users();
            @$users->saveLogin($id);

            $title = 'Monitoria';

            $qualCargo = in_array($cargo,[15,1]);

            if($qualCargo) {
                $dataArray = [];
                $lastMonth = date('Y-m-1 00:00:00');

                // Laudos
                $models = Laudo::select('titulo','id')
                                ->orderBy('utilizacoes','DESC')
                                ->orderBy('id','DESC')
                                // ->where('carteira_id',Auth::user()->carteira_id)
                                ->get();

                //Tabela
                $monitorias = Monitoria::selectRaw('monitorias.*, users.name AS filtro')
                                        ->where('monitorias.created_at', '>=', date("Y-m-01 00:00:00",strtotime('-2 Months')))
                                        ->leftJoin('book_usuarios.users','users.id','monitorias.operador_id')
                                        ->where('users.carteira_id',Auth::user()->carteira_id)
                                        ->where('monitorias.created_at','>=',date('Y-m-d 00:00:00',strtotime('-20 Days')))// Pega monitorias dos ultimos 2 mese
                                        ->orderBy('users.name') //ASC
                                        ->orderBy('id','DESC')
                                        ->paginate(10);

                // dados do Cards
                $media = round(Monitoria::selectRaw('AVG(media) as media')->where('created_at','>=',$lastMonth)->first()['media'],2);

                $usersFiltering = DB::select('SELECT users.id, users.username, users.cpf, users.name, (SELECT COUNT(monitorias.id) FROM book_monitoria.monitorias WHERE created_at >= "'.date("Y-m-01 00:00:00").'" AND operador_id = users.id) AS ocorrencias FROM book_usuarios.users LEFT JOIN book_monitoria.monitorias ON users.id = monitorias.operador_id WHERE users.carteira_id = '.Auth::user()->carteira_id.' AND users.cargo_id = 5 AND ISNULL(users.deleted_at) GROUP BY users.id, users.name , users.username, users.cpf ORDER BY ocorrencias, name;');

            } else {
                $ncgs = 0;
                $models = [];
                $usersFiltering = 0;
                $monitorias = Monitoria::where('supervisor_id',$id)
                                        ->orWhere('supervisor_at','IS','NULL')
                                        ->orWhere('supervisor_at','<=',date('Y-m-d H:i:s',strtotime('-1 Months')))
                                        ->orderBy('supervisor_at') //ASC
                                        ->get();
            }
            return view('monitoring.manager',compact('title','qualCargo','models','monitorias','media','lastMonth', 'usersFiltering'));
        } catch (Exception $e) {
            return back()->with('errorAlert','Erro de Rede, tente novamente');
        }
    }

    public function create()
    {
        $title = 'Criar Modelo/Laudo';
        $users = User::select('id','name')
                    ->get();

        return view('monitoring.makeModels',compact('title','users'));
    }

    public function store(Request $request, $user)
    {
        $rules = [
            'operador' => 'required',
            'hr_call' => 'required',
            // 'min_call' => 'required',
            // 'seg_call' => 'required',
            'hr_tp_call' => 'required',
            // 'min_tp_call' => 'required',
            // 'seg_tp_call' => 'required',
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

        $request->validate($rules,['required' => 'O campo :attribute não pode ser vazio']);

        // itens da monitoria
        $MonitoriaItem = [];

        // trata variáveis para salvar
        $operador = $request->input('operador');
        $supervisor = User::select('supervisor_id')->where('id',$operador)->first('supervisor_id')['supervisor_id'];

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
        if(isset($_POST['ncg'])) {
            $ncg += 1;
            unset($media);
            $media = 0;
        } else if(round((($conf/($conf+$nConf))*100),2) !== $media) {
            $media = round((($conf/($conf+$nConf))*100),2);
        }

        // Calcula quartil
        if($media >= 88) {
            $quartil = 'Q1';
        } else if($media >= 75) {
            $quartil = 'Q2';
        } else if ($media >= 50) {
            $quartil = 'Q3';
        } else {
            $quartil = 'Q4';
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
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }

            }

            // grava laudos
            if($monitoriaLaudos = MonitoriaItem::insert($MonitoriaItem)) {
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
            // 'min_call' => 'required',
            // 'seg_call' => 'required',
            'hr_tp_call' => 'required',
            // 'min_tp_call' => 'required',
            // 'seg_tp_call' => 'required',
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
        if(isset($_POST['ncg'])) {
            $ncg += 1;
            unset($media);
            $media = 0;
        } else if(round((($conf/($conf+$nConf))*100),2) !== $media) {
            $media = round((($conf/($conf+$nConf))*100),2);
        }

        // Calcula quartil
        if($media >= 88) {
            $quartil = 'Q1';
        } else if($media >= 75) {
            $quartil = 'Q2';
        } else if ($media >= 50) {
            $quartil = 'Q3';
        } else {
            $quartil = 'Q4';
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

            // laudos de monitoria
            foreach ($laudosData as $itens) {
                $i = explode('|||||',$itens);
                if(isset($i[1])) {
                    $MonitoriaItem[] = [
                        'value' => $i[1],
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }

            }

            $n=0;
            foreach($monitoriaLaudos as $laudo) {
                $laudo->value = $MonitoriaItem[$n]['value'];
                $laudo->updated_at = $MonitoriaItem[$n]['updated_at'];
                $laudo->save();
                $n++;
            }

            // grava laudos
            if(TRUE) {
                return response()->json(['success' => TRUE, 'msg' => 'Monitoria Alterada!<br>Redirecionando...'], 201);
            } else {
                return response()->json($monitoriaLaudos->errors()->all(), 500);
                Monitoria::delete($monitoria_id);
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
                                ->whereRaw('monitorias.supervisor_at IS NULL AND monitorias.deleted_at IS NULL')
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
                    AND NOT m.supervisor_at IS NULL
                    AND m.deleted_at IS NULL;',[$id]);

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

}
