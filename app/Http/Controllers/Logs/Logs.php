<?php

namespace App\Http\Controllers\Logs;

use App\Logs\Log;
use App\Logs\Chat;
use App\Logs\Quiz;
use App\Logs\MaterialLogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Users\Users;
use Auth;
use Storage;


class Logs extends Controller
{
    public function logFileDay($log) : bool
    {
        try {
            Storage::disk('local')->put('logs'.DIRECTORY_SEPARATOR.'logFileDay'.date('Ymd').'.txt',$log);
            Storage::disk('local')->put('logs'.DIRECTORY_SEPARATOR.'logFileDay'.date('Ymd').'.txt',"\n\r");
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        }
    }

    //registra que usuário clicou em um link externo
    public function clickLink(Request $request)
    {
        $log = new Log();
        $log->action= 'OPEN_LINK';
        $log->value = $request->input('url');
        $log->page = $request->input('page');
        $log->user_id = $request->input('user');
        $log->ilha_id = $request->input('ilha');
        if( $log->save() ) {
            return response()->json(['success' => TRUE], 201);

        }

        return response()->json(['success' => FALSE], 500);

    }

    //registra que usuário clicou em uma hashtag
    public function clickTag(Request $request)
    {
        $log = new Log();
        $log->action= 'CLICK_TAG';
        $log->value = $request->input('url');
        $log->page = $request->input('page');
        $log->user_id = $request->input('user');
        $log->ilha_id = $request->input('ilha');
        if( $log->save() ) {
            return response()->json(['success' => TRUE], 201);

        }

        return response()->json(['success' => FALSE], 500);
    }

    //Logs em geral
    public function log($action, $value = NULL, $page, $user, $ilha) : bool {
        $log = new Log();
        $log->action= $action;
        $log->value = $value;
        $log->page = $page;
        $log->user_id = $user;
        $log->ilha_id = $ilha;
        if( $log->save() ) {
            return TRUE;
        }

        return FALSE;
    }

    // Verificar depois quem usa essa função e apagar pois não gravamos mais isso 
    public function page($page, $user, $ilha, $ip = NULL) : bool {
        return TRUE;
    }

    //Login, LogOUT
    public function login($user, $ilha, $ip) : bool {
        $log = new Log();
        $log->action= "LOGIN";
        $log->value = 'IP_CLIENT: '.$ip;
        $log->page = asset('/home');
        $log->user_id = $user;
        $log->ilha_id = $ilha;
        if( $log->save() ) {
            return TRUE;
        }

        return FALSE;
    }

    public function logout($user, $ilha, Request $request)  {
        $log = new Log();
        $log->action= "LOGOUT";
        $log->value = 'IP_CLIENT: '.$request->ip();
        $log->page = $request->input('page');
        $log->user_id = $user;
        $log->ilha_id = $ilha;
        if( $log->save() ) {
            Auth::logout();
            return redirect('/');
        }

        return FALSE;
    }

    public function firstLogin($id)
    {
        $log = Log::where('action','LOGIN')
                ->where('user_id',$id)
                ->count();

        return $log;
    }

    // MaterialLogs //

    //salva assinatura digital
    public function signature($hash = NULL, $user, $ilha, $id, $type) : bool
    {
        //Salva visualização de wiki
        $log = new MaterialLogs();
        $log->action = "VIEW_".$type;
        $log->value = $hash;
        if($type === 'VIDEO') {
            $log->video_id = $id;
        } else if($type === 'MATERIAL') {
            $log->material_id = $id;
        } else if($type === 'CIRCULAR') {
            $log->circular_id = $id;
        } else if($type === 'SCRIPT') {
            $log->roteiro_id = $id;
        }
        $log->user_id = $user;
        $log->ilha_id = $ilha;

        if($log->save()) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    public function signCirc($hash,$user,$ilha,$id, Request $request)
    {
        $log = new MaterialLogs();
        $log->value = $request->input('text');
        $log->action = "CIRC_SIGN_".$hash;
        $log->circular_id = $id;
        $log->user_id = $user;
        $log->ilha_id = $ilha;
        if($log->save()) {
            return response()->json(['success' => TRUE], 201);
        } else {
            return response()->json(['success' => FALSE, 'errors' => $log->errors()->all()], 500);
        }
    }

    // checa assinatura de material individualmente e retorna um JSON
    public function checkSign($user, $ilha, $id, $type)
    {
        $hash = date('H').md5(date('Y-m-d').'_'.$user.'_').'$'.date('i').md5($id.'_'.$type).date('s');
        if($type === 'VIDEO') {
            $check = MaterialLogs::select('id','value as hash','action')
                                ->where('action','VIEW_' . $type)
                                ->where('video_id',$id)
                                ->where('user_id',$user)
                                ->get();
        } else if($type === 'MATERIAL') {
            $check = MaterialLogs::select('id','value as hash','action')
                                ->where('action','VIEW_' . $type)
                                ->where('material_id',$id)
                                ->where('user_id',$user)
                                ->get();
        } else if($type === 'CIRCULAR') {
            $check = MaterialLogs::select('id','action','value as hash')
                                ->where('action','VIEW_' . $type)
                                ->where('circular_id',$id)
                                ->where('user_id',$user)
                                ->get();

        } else if($type === 'SCRIPT') {
            $check = MaterialLogs::select('id','value as hash','action')
                                ->where('action','VIEW_' . $type)
                                ->where('roteiro_id',$id)
                                ->where('user_id',$user)
                                ->get();
        } else {
            $check = [];
        }

        // Checa se não existe log
        if($check->count() == 0) {

            // Grava log de visualização
            $log = $this->signature($hash,$user,$ilha,$id,$type);
            if($log) {
                return json_encode([0 => ["hash" => $hash, "action" => "undefined", "id" => 0]]);
            }

            // erro
            return 0;
        }

        // Caso exista log, retorna ele 
        return $check->toJSON();
    }

    // Não entendi essa função
    public function checkAllMaterials($user,$id,$type)
    {
        return 0;
        if($type === 'VIDEO') {
            $check = MaterialLogs::select('action','value')
                                ->where('action','VIEW_' . $type)
                                ->where('video_id',$id)
                                ->where('user_id',$user)
                                ->get();
        } else if($type === 'MATERIAL') {
            $check = MaterialLogs::select('action','value')
                                ->where('action','VIEW_' . $type)
                                ->where('material_id',$id)
                                ->where('user_id',$user)
                                ->get();
        } else if($type === 'CIRCULAR') {
            $check = MaterialLogs::select('action','value')
                                ->where('action','VIEW_' . $type)
                                ->where('circular_id',$id)
                                ->where('user_id',$user)
                                ->get();
        } else if($type === 'SCRIPT') {
            $check = MaterialLogs::select('action','value')
                                ->where('action','VIEW_' . $type)
                                ->where('roteiro_id',$id)
                                ->where('user_id',$user)
                                ->get();
        } else {
            $check = [];
        }
        return $check;
    }

    public function checkRead($user,$type)
    {
        return 0;
        $check = Log::whereIn('action',['VIEW_SCRIPT','VIEW_CIRCULAR','VIEW_VIDEO','VIEW_MATERIAL'])
                    ->where('')
                    ->where('user_id',$user)
                    ->get(['action']);

        foreach($check as $c) {
            $string .= array_reverse(explode('_',$c['action']))[0] . ',';
        }

        return ($check);
    }

    //Conta materiais não lidos
    public function countNotRead($user,$ilha) 
    {
        return 0;
        $check = Log::whereRaw('action LIKE "%ACCEPT_TERMS_MATERIALS_%"')
                    ->where('user_id',$user)
                    ->count();

        $materials = new Users();
        $count = $materials->countAllMaterials($ilha);

        return [$count[0]-$check,$count[1]];
    }

    // Registra log de salvamento de telefones
    public function telephone($user,$id,$ilha,$action = 'REGISTER_TELEPHONE')
    {
        $log = new MaterialLogs();
        $log->action = $action;
        $log->phone_id = $id;
        $log->user_id = $user;
        $log->ilha_id = $ilha;
        $log->save();
    }

    public function post($id, $ilha, $user, $action = 'NEW_POST') : bool {
        $log = new MaterialLogs();
        $log->post_id = $id;
        $log->action= $action;
        $log->ilha_id = $ilha;
        $log->user_id = $user;
        if( $log->save() ) {
            return TRUE;
        }

        return FALSE;
    }

    public function circular($circular_id, $ilha, $user, $action = 'NEW_CIRCULAR') : bool {
        $log = new MaterialLogs();
        $log->circular_id = $circular_id;
        $log->action= $action;
        $log->ilha_id = $ilha;
        $log->user_id = $user;
        if( $log->save() ) {
            return TRUE;
        }

        return FALSE;
    }

    public function script($id, $ilha, $user, $action = 'NEW_SCRIPT') : bool {
        $log = new MaterialLogs();
        $log->roteiro_id = $id;
        $log->action = $action;
        $log->ilha_id = $ilha;
        $log->user_id = $user;
        if( $log->save() ) {
            return TRUE;
        }

        return FALSE;
    }

    public function material($id, $ilha, $user, $action = 'NEW_SCRIPT') : bool {
        $log = new MaterialLogs();
        $log->roteiro_id = $id;
        $log->action = $action;
        $log->ilha_id = $ilha;
        $log->user_id = $user;
        if( $log->save() ) {
            return TRUE;
        }

        return FALSE;
    }

    public function video($id, $ilha, $user, $action = 'NEW_SCRIPT') : bool {
        $log = new MaterialLogs();
        $log->material_id = $id;
        $log->action = $action;
        $log->ilha_id = $ilha;
        $log->user_id = $user;
        if( $log->save() ) {
            return TRUE;
        }

        return FALSE;
    }
    public function calculator($id, $ilha, $user, $action = 'NEW_CALCULATOR') : bool {
        $log = new MaterialLogs();
        $log->calculadora_id = $id;
        $log->action = $action;
        $log->ilha_id = $ilha;
        $log->user_id = $user;
        if( $log->save() ) {
            return TRUE;
        }

        return FALSE;
    }

    //Chat Logs
    public function createGroup($user,$group ) : bool
    {
        return TRUE;
    }

    public function deleteGroup($user,$group) : bool {
        return TRUE;
    }

    public function sendMsg($user, $id = NULL,$group = NULL) : bool {
        return TRUE;
    }

    public function readGroup($id,$group,$user) {
        return TRUE;
    }

    public function addUserToIlha($ilha,$user,$id) : bool {
        return TRUE;
    }

    //quiz
    public function deleteQuiz($user,$quiz) : BOOL
    {
        return TRUE;
    }

    public function createQuiz($user,$quiz) : BOOL
    {
        return TRUE;
    }

    public function updateQuiz($user,$quiz) : BOOL
    {
        return TRUE;
    }

    public function awnswerQuiz($user,$quiz,$action = "ANSWER_QUIZ") : BOOL
    {
        $log = new Log();
        $log->action= $action;
        $log->value = $quiz;
        $log->page = 'public/quiz/view';base64_encode($quiz);
        $log->user_id = $user;
        $log->ilha_id = 1;    
        if($log->save()) {
            return TRUE;
        }
        return FALSE;
    }

}
