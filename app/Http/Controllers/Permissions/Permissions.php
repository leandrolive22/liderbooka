<?php

namespace App\Http\Controllers\Permissions;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Quizzes\Quizzes;
use App\Http\Controllers\Permissions\UserPermission AS UserPermissionController;
use App\Permission\UserPermission;
use App\Permission\Permission;
use Illuminate\Http\Request;
use Auth;
use Session;

class Permissions extends Controller
{
    protected $permissions;

    public function wikiSearchType()
    {
        $permissions = Session::get('permissionsIds');
        $tudo = in_array(44, $permissions);
        $carteira = in_array(42, $permissions);
        $ilha = in_array(56, $permissions);
        $setor = in_array(57, $permissions);

        return compact('tudo','carteira','ilha','setor');
    }

    public function getPermissions() : array
    {
        return $this->permissions;
    }

    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;
    }

    // Lista todas permissões
    public function allPermissions($webMaster = FALSE)
    {
        return Permission::when(!$webMaster, function($q) {
                        return $q->where('id','<>',1);
                    })
                    ->orderBy('name')
                    ->get();
    }

    public function index(int $id = 0)
    {
        try {
            // Usuário
            $user = Auth::user();

            // Pega permissões
            $permissions = new UserPermissionController($user);
            $permissions_ids = $permissions->getPermissionsIds();
            $allPermissions = $this->allPermissions(in_array(1,$permissions_ids));

            // Pega quizzes não vistos
            $q = new Quizzes();
            $quiz = $q->getQuizFromUser(Auth::user()->ilha_id, Auth::id());
            $title = 'Gestão de Permissões';

            // Pega todos usuário ativos
            if($id === 0) {
                $users = User::orderBy('name')->get();
                $userPermissions = [];
            } else {
                $users = User::find($id);
                $userPermission = new UserPermissionController($users);
                $userPermissions = $userPermission->getPermissionsIds();
            }
            return view('gerenciamento.permissions.index',compact('allPermissions', 'quiz', 'title', 'users', 'id', 'userPermissions'));
        } catch (Exception $e) {
            @$log = new Logs();
            @$log->logFileDay($e->getMessage());
            return back()->with('errorAlert','Erro desconhecido, tente novamente mais tarde.');
        }
    }

    // Verifica se usuário possui determinada permissão
    public function havePermission(int $permission_id) : bool
    {
        return in_array($permission_id, $this->permissions);
    }

    public function getUserPermissions(Request $request)
    {
        $request->validate([
            'user' => 'required'
        ],[
            'required' => 'Erro de Requisiçãom, recarregue e tente novamente!'
        ]);

        $id =  $request->user;
        $user = User::find($id);

        if($user->count() < 1) {
            return ['errorAlert' => 'Nenhum Dado Encontrado'];
        }

        $userPermission = new UserPermissionController($user);
        return $userPermission->getPermissionsIds();
    }

    public function store(Request $request)
    {
        // Valida dados de formulário
        $request->validate([
            'user' => 'required',
        ],[
            'required' => 'Erro de Requisiçãom, recarregue e tente novamente!'
        ]);

        // Pega dados do usuário
        $id =  $request->user;
        $permissions = explode(',',$request->permissions);

        // Pesquisa usuário
        $user = User::find($id);

        // Verifica se encontrou usuário
        if($user->count() < 1) {
            return ['errorAlert' => 'Nenhum Dado Encontrado'];
        }

        // Instancia novo objeto USerPermission e trata as novas permissões
        $userPermission = new UserPermissionController($user);
        // Separa as permissões
        $new = $userPermission->newPermissions($permissions);
        // Pega ID das permissões (taela User_permissions)
        $old = $userPermission->getUserPermissionsIds();

        try {
            if(strlen($permissions[0]) === 0) {
                @UserPermission::where('user_id',$user->id)
                                ->where('permission_id','<>',1)
                                ->delete();
                return response()->json(['msg' => 'Permissões alteradas com sucesso!'],201);
            }

            // marca permissões natigas como deletadas
            $oldDb = UserPermission::whereIn('id',$old)->get();
            $countOldDb = $oldDb->count();
            if($countOldDb > 0) {
                UserPermission::whereIn('id',$old)->delete();
            }

            // Atualiza permissões no banco
            if(UserPermission::insert($this->setDataToSave($new, $id))) {
                return response()->json(['msg' => 'Permissões alteradas com sucesso!'],201);
            }

            // restaura deletadas
            if($countOldDb > 0) {
                UserPermission::withTrashed()->whereIn('id',$id)->restore();
            }
            
            return response()->json(['msg' => 'Erro ao alterar permissões!'],422);
        } catch (Exception $e) {
            return response()->json(['errorAlert' => $e->getMessage()],500);
        }

    }

    private function setDataToSave(array $permissions, $user) : array
    {
        $arr = array();
        $timestamp = date('Y-m-d H:i:s');
        foreach($permissions as $item) {
            $line = array(
                'permission_id' => $item,
                'user_id' => $user,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            );

            array_push($arr, $line);
        }

        return $arr;
    }
}
