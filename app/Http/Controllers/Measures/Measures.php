<?php

namespace App\Http\Controllers\Measures;
use PDF;
use App\Http\Controllers\Controller;
use App\Measures\Measure;
use App\Measures\MeasureModel as Model;
use App\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Measures extends Controller
{
    // tráz linha do tempo de medidas
    public function index()
    {
    	$id = Auth::id();
    	$cargo = Auth::user()->cargo_id;
    	
        // Medidas
        $measures = Measure::select('id','title','creator_id','accept_user','user_obs')
                            ->orderBy('id','DESC')
                            ->get();
        
        // Modelos
        $models = Model::select('id','title','creator_id')
                        ->orderBy('used','DESC')
                        ->orderBy('id','DESC') 
                        ->get();

        $title = 'Medidas Disciplinares';

        return view('gerenciamento.measures.manager',compact('title','measures','models'));
    }

    // Cria view para salvar medida
    public function create(Request $request, $m)
    {
        //Dados do usuário
        $cargo = Auth::user()->cargo_id;
        $setor_id = Auth::user()->setor_id;

        //Verifica cargo para personalizar busca
        $users = User::select('id','name')
                    ->orderBy('id','DESC')
                    ->get();

        // Pesquisa modelo
        $model = NULL;
        if($m > 0) {
            $model = Model::find($m);
        }

        //titulo da página
        $title = 'Medidas Disciplinares';

        //retorna view de criação de usuários
        return view('gerenciamento.measures.create',compact('title','users','model'));
    }

    // Salva Medida
    /*
    * 
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response   
    */
    public function store(Request $request, $id)
    {
        //Dados do form
        $user_id = $request->input('user');
        $creator_id = base64_decode($id);
        $title = $request->input('title');
        $description = $request->input('description');
        $obs = $request->input('obs');
        $hasModel = $request->input('icheck');
        $isModel = $request->input('modelId');

        $measure = new Measure();
        $measure->title = $title;
        $measure->description = $description;
        $measure->obs = $obs;
        $measure->creator_id = $creator_id;
        $measure->user_id  = $user_id;
        if($measure->save()) {
            $modelAlert = NULL;

            // Checa se usuário quis criar modelo e o salva em caso de verdadeiro
            if($hasModel === 1) {
                $model = new Model();
                $model->creator_id = $creator_id;
                $model->title = $title;
                $model->description = $description;
                $model->obs = $obs;    
                $model->save();
                $modelAlert = 'e Modelo';
            }

            // verifica se é um modelo e o marca como usado
            if($isModel > 0) {
                $mark = Model::find($isModel);
                $mark->user++;
                $mark->save();
            }

            return response()->json(['success' => TRUE],201);
        } else {
            return response()->json(['errorAlert' => $measure->errors()->all()],422);
        }
    }

    // exibe medida em modal
    public function view($id)
    {
        $measure = Measure::where('user_id',$id)
                ->whereRaw('accept_timestamp is NULL')
                ->limit(1)
                ->get();
        if(is_null($measure)) {
            return 'vazio';
        }

        return $measure;
    }

    /* Salva resposta do Usuário
    *
    * @param    Illuminate\Http\Request $equest
    * @param    INT $id
    * @return    Illuminate\Http\Response   
    */
    public function saveResp(Request $request, $id)
    {
        // Coloca variáveis com parâmetros vindos do form
        $n = $request->input('n');
        $user_obs = $request->input('user_obs');
        $ip_client = $request->input('ip_client');
        $mId = $request->input('mId');

        // Retorna resposta de erro
        if(is_null($n) || !in_array($n,[0,1]) || is_null($ip_client) || is_null($mId)) {
            return response()->json(['error' => 'Preencha os dados corretamente'],422);
        }

        // Salva resposta
        $resp = Measure::find($mId);
        $resp->accept_user = $n;
        $resp->aceite_hash = md5("USER_ACCEPT_".$resp->user_id).date("Ymd");
        $resp->accept_timestamp = date('Y-m-d H:i:s');
        $resp->ip_client = $ip_client;
        $resp->user_obs = $user_obs;

        // resposta
        if($resp->save()) {
            return response()->json(['success' => TRUE], 201);
        }

        return response()->json(['error' => $resp->errors()->all()], 422);
    }

    public function export($id, Request $request) {
        $show = Measure::select('measures.*','s.name as setor')->leftJoin('book_usuarios.users AS u','u.id','measures.user_id')->leftJoin('book_usuarios.setores as s','s.id','u.setor_id')->where('measures.id',$id)->first();
        $title = 'Exportar';
        $lgpd = TRUE;
        return view('gerenciamento.measures.components.export', compact('show','title','lgpd'));
    
    }
}