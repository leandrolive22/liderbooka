<?php

namespace App\Http\Controllers\Chats;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Chats\Message;
use App\Chats\Group;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Users\Users;
use App\Users\User; 
use App\Users\Superior;
use Illuminate\Support\Facades\Validator;
use Session;

class Chats extends Controller
{
    //notifica msgs recebidas de contatos
    public function notifyMsg($id) {        

        //pega as mensagens
        $distinct = Message::select('speaker_id','group_id')
            ->where('interlocutor_id',$id)
            ->where('readed',0)
            ->distinct()
            ->get();

        $array = ['n' => $distinct->count(), 'ids' => $distinct];
        return $array;
    }

    //notifica msgs recebidas

    // public function notifyAllMsg($id) {
    //     $ids = NULL;
    //     $i = 0;

    //     $n = User::find($id);
    //     if($n->have_msg == 0) {
    //         $array = ['msg' => 0, 'n' => 0, 'ids' => []];
    //         return $array;
    //     }

    //     $distinct = Message::where('interlocutor_id',$id)
    //         ->where('readed',0)
    //         ->distinct()
    //         ->select('speaker_id')
    //         ->get();


    //     foreach($distinct as $select) {
    //         $ids .= Message::where('speaker_id',$select['speaker_id'])
    //                 ->where('interlocutor_id',$id)
    //                 ->where('readed',0)
    //                 ->where('group_id', NULL)
    //                 ->get('speaker_id')[0]['speaker_id'];

    //         $i++;
    //     }

    //     $array = ['msg' => $distinct, 'n' => $n->have_msg, 'ids' => [$ids]];
    //     return $array;
    // }

    //salva msg
    public function storeMsg($user, $id = NULL, Request $request) {

        $rules =
        [
            'content' => 'required',
        ];
        $msg =
        [
            'required' => 'Não é possível enviar mensagem vazia'
        ];

        $validator = Validator::make($request->all(), $rules, $msg);
        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        //id do grupo
        $group = $request->input('groupInput');

        //Retira valor de $id caso seja um grupo
        if( $group > 0 && !is_null($group) ) {
            unset($id);
            $id = NULL;
        } else {
            unset($group);
            $group = NULL;
        }

        $msg = new Message();
        $msg->content = $request->input('content');
        $msg->interlocutor_id = $id;
        $msg->speaker_id = $user;
        $msg->group_id = $group;
        $msg->readed = 0;
        if($msg->save()) {
            if ($id != NULL) {
                $noty = User::find($id);
                $noty->have_msg++;
                $noty->save();
            }

            return response()->json(['success' => TRUE]);

        } else {
            return response()->json(['errors' => 'Falha ao enviar mensagem, recarregue a página']);
        }

    }

    /*pega msgs para exibição
    *
    * @params $id = contato da msg, $user = usuário que está lendo as msgs
    * @return JSON 
    */
    public function receiveMsg($id, $user, $group = NULL) {
        $search = Message::select('created_at','speaker_id','content','id')
                            ->whereIn('interlocutor_id',[$id,$user])
                            ->whereIn('speaker_id',[$id,$user])
                            ->where('group_id',$group)
                            ->orderBy('id','DESC')
                            ->limit(20)
                            ->get();

        $messages = [];
        foreach ($search as $key) {
            $messages[] = $key;
        }

        // Marca mensagem como lida
        if($group === NULL && $search->count() > 0)
        {
            $readed = 0;
            $ids = NULL;

            //pega ids
            foreach($search as $m) {
                if($user !== $m->speaker_id) {
                    $ids .= $m->id.',';
                    $readed++;
                }
            }
            // marca como lidas 
            $this->read($user);
            $u = User::find($user);
            if($u->have_msg > 0 ) {
                $u->have_msg -= $readed;
                $u->save();        
                
            }

        }



        return json_encode(array_reverse($messages));
    }

    //marca msgs como lidas
    public function read($id) {
        $msg = Message::where('interlocutor_id',$id)
            ->where('group_id',NULL)
            ->update(['readed' => 1]);
    }

    //
    public function lastMsg($id,$user) {
        $last = Message::where('speaker_id',$id)
                        ->where('interlocutor_id',$user)
                        ->first();

        return $last;
    }

    public function numberMsg($id,$user) {
        $last = Message::select('id')
                        ->where('speaker_id',$id)
                        ->where('interlocutor_id',$user)
                        ->where('group_id',NULL)
                        ->where('readed',0)
                        ->oldest()
                        ->count();

        return json_encode($last);
    }

########################### Grupos ###########################

    //notifica msgs recebidas de grupos
    public function notifyGroup($id){
        $count = Message::select('id')
                        ->where('readed',0)
                        ->where('group_id',$id)
                        ->count();
        return json_encode($count);
    }

    //pega msgs dos grupos
    public function receiveGroupMsg($id, $user) {
        $messages = Message::where('group_id',$id)
                            // ->limit(100)
                            ->get();


        // Marca mensagem como lida
        foreach($messages as $m) {
            $this->readGroup($m->id,$m->group_id,$user);
        }

        return json_encode($messages);
    }

    public function readGroup($id,$group,$user) {
        $log = new Logs();
        $log->readGroup($id,$group,$user);
    }

    public function createGroup($id,$data, Request $request) {

        $group = new Group();
        $group->conversation_title = $request->input('conversation_title');
        $group->interlocutors_ids = $data;
        $group->speaker_id = $id;
        if($group->save()) {
            $log = new Logs();
            $log->createGroup($id,$group->id);

            return response()->json(['success' => TRUE]);
        }

    }

    public function deleteGroup($id,$data)
    {
        $group = explode(',',$data);

        for ($i = 0; $i < count($group)-1; $i++) {

            $log = new Logs();
            $log->deleteGroup($id,$group[$i]);

            $delete = Group::find($group[$i]);
            $delete->delete();


        }


    }

    //cria grupo por ilha
    public function GroupIlha($id,$ilha,$name) {
        $group = new Group();
        $group->conversation_title = $name;
        $group->speaker_id = $id;
        $group->ilha_id = $ilha;
        if($group->save()) {
            $log = new Logs();
            $log->createGroup($id,$group->id);

            return response()->json(['success' => TRUE]);
        }
    }

    //cria grupo com mais de uma ilha
    public function groupByIlha($id,$ilhas,$name)
    {
        $data = NULL;

        $users = User::whereIn('ilha_id',$ilhas)->get();
        foreach($users as $user) {
            $data .= $user->id.',';
        }

        $group = new Group();
        $group->conversation_title = $name;
        $group->interlocutors_ids = $data;
        $group->speaker_id = $id;
        if($group->save()) {
            $log = new Logs();
            $log->createGroup($id,$group->id);

            return response()->json(['success' => TRUE]);
        }

    }

    //insere user em grupo da ilha assim que o acesso é criado
    public function addUserToIlha($ilha,$user,$id)
    {
        $group = Group::where('ilha_id',$ilha)->get();
        $data = $group->interlocutors_ids;
        $group->interlocutors_ids = $data.",$user";
        if($group->save()) {

            return response()->json(['success' => TRUE]);
        }
    }

    /******************************* ROTAS DE CHAT *******************************/
    //Pega grupos que o usuário está inserido
    public function getGroupsByUser($id)
    {
        $groups = Group::leftJoin('book_usuarios.ilhas as ilhas','ilhas.id', 'groups.ilha_id')
                        ->where('interlocutors_ids','like', "%$id%")
                        ->orWhere('speaker_id',$id)
                        ->get(['groups.id','groups.conversation_title','ilhas.name']);

        return $groups;
    }

    //Pega contatos
    public function getContacts($id,$ids) {
        $users = User::selectRaw('users.id, cargos.description as cargo, users.name, users.avatar, count(messages.id) as numberMsg, users.deleted_at')
                    ->distinct()
                    ->join('cargos', 'cargos.id', 'users.cargo_id')
                    ->leftJoin('book_chats.messages','messages.speaker_id','users.id')
                    ->whereRaw('speaker_id NOT IN ('.$ids.')')
                    ->where('interlocutor_id',$id)
                    ->groupBy('messages.id')
                    ->orderBy('users.name','ASC')
                    ->withTrashed()
                    ->get();

        return $users->toJSON();
    }

    //msg de Superintendente, gerentes,
    public function msgAdm()
    {
        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }
        $id = Auth::id();
        $cargo = Auth::user()->cargo_id;
        $title = 'ChatBook';
        $superintendente_id = Auth::user()->superintendente_id;
        $gerente_id = Auth::user()->gerente_id;

        $contacts = User::select('users.id','users.last_login','users.deleted_at', 'cargos.description as cargo', 'users.name', 'users.avatar')
                        ->distinct()
                        ->leftJoin('book_chats.messages','messages.speaker_id','users.id')
                        ->leftjoin('book_usuarios.cargos as cargos', 'cargos.id', 'users.cargo_id')
                        ->where('messages.interlocutor_id',$id)
                        ->orWhere('users.cargo_id', $cargo)
                        ->orWhere('users.supervisor_id',$id)
                        ->orWhere('users.coordenador_id',$id)
                        ->orWhere('users.gerente_id',$id)
                        ->orWhere('users.superintendente_id',$id)
                        ->orWhereIn('users.id',[$superintendente_id,$gerente_id,1])
                        ->orderBy('users.deleted_at', 'ASC')
                        ->orderBy('users.name','ASC')
                        ->withTrashed()
                        ->get();

        $groups = $this->getGroupsByUser($id);

        // Permissões
        $permissions = Session::get('permissionsIds');
        $webMaster = in_array(1, $permissions);
        $createGroup = in_array(6, $permissions);
        $deleteGroup = in_array(7, $permissions);
        $compact = compact('title', 'contacts','groups', 'permissions', 'webMaster', 'createGroup', 'deleteGroup');

        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }

        return view('chats.chat', $compact);
    }

    //msgMonitoria
    public function msgMonitor() {
        // id
        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }
        $id = Auth::id();

        // superiores
        $sups = [1,Auth::user()->coordenador_id, Auth::user()->supervisor_id,Auth::user()->gerente_id, Auth::user()->superintendente_id];

        // title
        $title = 'ChatBook';

        // Filtra contatos
        $contacts = User::select('users.id','users.deleted_at', 'cargos.description as cargo', 'users.name', 'users.avatar')
                        ->distinct()
                        ->join('cargos', 'cargos.id', 'users.cargo_id')
                        ->leftJoin('book_chats.messages','messages.speaker_id','users.id')
                        ->where('messages.interlocutor_id',$id)
                        ->orWhereIn('users.cargo_id',[4,5])
                        ->orWhereIn('users.id', $sups)
                        ->orderBy('users.deleted_at', 'ASC')
                        ->orderBy('users.name','ASC')
                        ->withTrashed()
                        ->get();

        // Pega grupos
        $groups = $this->getGroupsByUser($id);

        // Permissões
        $permissions = Session::get('permissionsIds');
        $webMaster = in_array(1, $permissions);
        $createGroup = in_array(6, $permissions);
        $deleteGroup = in_array(7, $permissions);
        $compact = compact('title', 'contacts','groups', 'permissions', 'webMaster', 'createGroup', 'deleteGroup');

        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }

        return view('chats.chat', $compact);
    }

    //msgOperator
    public function msgOperador()
    {
        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }
        $id = Auth::id();
        $sups = [1,Auth::user()->coordenador_id, Auth::user()->supervisor_id,Auth::user()->gerente_id, Auth::user()->superintendente_id];

        $title = 'ChatBook';

        $contacts = User::select('users.id','users.deleted_at', 'cargos.description as cargo', 'users.name', 'users.avatar')
                        ->distinct()
                        ->join('cargos', 'cargos.id', 'users.cargo_id')
                        ->leftJoin('book_chats.messages','messages.speaker_id','users.id')
                        ->where('messages.interlocutor_id',$id)
                        ->orWhereIn('users.id', $sups)
                        ->orderBy('users.deleted_at', 'ASC')
                        ->orderBy('users.name','ASC')
                        ->withTrashed()
                        ->get();

        $groups = $this->getGroupsByUser($id);
        // P// Permissões
        $permissions = Session::get('permissionsIds');
        $webMaster = in_array(1, $permissions);
        $createGroup = in_array(6, $permissions);
        $deleteGroup = in_array(7, $permissions);
        $compact = compact('title', 'contacts','groups', 'permissions', 'webMaster', 'createGroup', 'deleteGroup');

        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }

        return view('chats.chat', $compact);
    }

    //msg para analistas, técnicos, operadores que não sejam de cobrança
    public function msgOperadorAdm()
    {
        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }
        $id = Auth::id();
        $sups = [Auth::user()->coordenador_id, Auth::user()->supervisor_id,Auth::user()->gerente_id, Auth::user()->superintendente_id];

        $title = 'ChatBook';

        $contacts = User::select('users.id','users.deleted_at', 'cargos.description as cargo', 'users.name', 'users.avatar')
                        ->distinct()
                        ->join('cargos', 'cargos.id', 'users.cargo_id')
                        ->leftJoin('book_chats.messages','messages.speaker_id','users.id')
                        ->where('messages.interlocutor_id',$id)
                        ->orWhereIn('users.id', $sups)
                        ->orderBy('users.deleted_at', 'ASC')
                        ->orderBy('users.name','ASC')
                        ->withTrashed()
                        ->get();

        $groups = $this->getGroupsByUser($id);

        // P// Permissões
        $permissions = Session::get('permissionsIds');
        $webMaster = in_array(1, $permissions);
        $createGroup = in_array(6, $permissions);
        $deleteGroup = in_array(7, $permissions);
        $compact = compact('title', 'contacts','groups', 'permissions', 'webMaster', 'createGroup', 'deleteGroup');

        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }

        return view('chats.chat', $compact);
    }

    //msgSupervisor MSG
    public function msgSupervisor()
    {
        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }
        $id = Auth::id();
        $idSup = [Auth::user()->gerente_id,Auth::user()->coordenador_id, Auth::user()->superintendente_id, 1];
        $title = 'ChatBook';

        $contacts = User::select('users.id','users.deleted_at', 'cargos.description as cargo', 'users.name', 'users.avatar')
                        ->distinct()
                        ->join('cargos', 'cargos.id', 'users.cargo_id')
                        ->leftJoin('book_chats.messages','messages.speaker_id','users.id')
                        ->where('messages.interlocutor_id',$id)
                        ->orWhere('users.supervisor_id', $id)
                        ->orWhere('users.cargo_id', 3)
                        ->orWhereIn('users.id',$idSup)
                        ->orderBy('users.deleted_at', 'ASC')
                        ->orderBy('users.name','ASC')
                        ->withTrashed()
                        ->get();

        $groups = $this->getGroupsByUser($id);
        // Permissões
        $permissions = Session::get('permissionsIds');
        $webMaster = in_array(1, $permissions);
        $createGroup = in_array(6, $permissions);
        $deleteGroup = in_array(7, $permissions);
        $compact = compact('title', 'contacts','groups', 'permissions', 'webMaster', 'createGroup', 'deleteGroup');

        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }

        return view('chats.chat', $compact);
    }

    //msgCoordenador MSG
    public function msgCoordenador()
    {
        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }
        $id = Auth::id();

        $title = 'ChatBook';
        $idSup = [Auth::user()->gerente_id, Auth::user()->superintendente_id, 1];

        $contacts = User::select('users.id','users.deleted_at', 'cargos.description as cargo', 'users.name', 'users.avatar')
                        ->distinct()
                        ->join('cargos', 'cargos.id', 'users.cargo_id')
                        ->leftJoin('book_chats.messages','messages.speaker_id','users.id')
                        ->where('messages.interlocutor_id',$id)
                        ->orWhere('users.gerente_id', $id)
                        ->orWhere('users.cargo_id', 7)
                        ->orWhereIn('users.id',$idSup)
                        ->orderBy('users.deleted_at', 'ASC')
                        ->orderBy('users.name','ASC')
                        ->withTrashed()
                        ->get();

        $groups = $this->getGroupsByUser($id);
        /// Permissões
        $permissions = Session::get('permissionsIds');
        $webMaster = in_array(1, $permissions);
        $createGroup = in_array(6, $permissions);
        $deleteGroup = in_array(7, $permissions);
        $compact = compact('title', 'contacts','groups', 'permissions', 'webMaster', 'createGroup', 'deleteGroup');

        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }

        return view('chats.chat', $compact);
    }

    //redireciona para criação de grupos
    public function groupCreate($i)
    {
        $id = base64_decode($i);
        $cargo = Auth::user()->cargo_id;
        $title = 'Novo Grupo';

        //checa cargo
        if(!in_array($cargo, [1,2,3,4,7,9,15])) {
            return back()->with(['errorAlert','Você não tem acesso à essa funcionalidade <a href="https://suporte.ativy.com">'.strtoupper('contate o suporte').'</a>']);
        }

        //select
        if($cargo == 4) {
            $contacts = User::select('users.id', 'cargos.description as cargo', 'users.name', 'users.avatar')
                            ->join('cargos', 'cargos.id', 'users.cargo_id')
                            ->where('users.supervisor_id',$id)
                            ->orderBy('users.name','ASC')
                            ->get();
        } else {
            $contacts = User::select('users.id', 'cargos.description as cargo', 'users.name', 'users.avatar')
                            ->join('cargos', 'cargos.id', 'users.cargo_id')
                            ->get();
        }

        return view('chats.newGroup', compact('title', 'contacts'));
    }

    //redireciona para exclusão de grupos
    public function groupDelete($cargo,$user)
    {
        $id = base64_decode($user);
        if(base64_decode($cargo) == 4){

            return $this->groupDeleteSup($id);
        } else {
            $title = 'Excluir Grupos';
            $groups = Group::select('conversation_title','id')
                            ->where('speaker_id',$id)
                            ->orWhereRaw('interlocutors_ids LIKE "%' . $id . '%"')
                            ->get();

            return view('chats.deleteGroup', compact('title', 'groups'));
        }

    }

    public function groupDeleteSup($id)
    {
        $title = 'Excluir Grupos';
        $groups = Group::where('speaker_id',$id)->get();

        return view('chats.deleteGroup', compact('title', 'groups'));
    }

}
