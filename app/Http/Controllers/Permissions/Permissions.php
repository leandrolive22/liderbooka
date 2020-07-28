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

class Permissions extends Controller
{
    protected $permissions;

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

    public function index()
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
            $users = User::orderBy('name')->get();

            return view('gerenciamento.permissions.index',compact('allPermissions', 'quiz', 'title', 'users'));
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
            'permissions' => 'required'
        ],[
            'required' => 'Erro de Requisiçãom, recarregue e tente novamente!'
        ]);

        // Pega dados do usuário
        $id =  $request->user;
        $permissions = $request->permissions;

        // Pesquisa usuário
        $user = User::find($id);

        // Verifica se encontrou usuário
        if($user->count() < 1) {
            return ['errorAlert' => 'Nenhum Dado Encontrado'];
        }

        // Instancia novo objeto USerPermission e trata as novas permissões
        $userPermission = new UserPermissionController($user);
        $new = $userPermission->newPermissions($permissions);
        $old = $userPermission->getPermissionsIds();
        $old = $userPermission->getUserPermissionsIds();


    }

    public function setDataToSave(array $permissions, array $old, array $new) : array
    {
        $countN = count($new);
        $countO = count($old);

        if($countO >= $countN) {
            for($i=0; $i<$countO; $i++) {
                if(in_array($new[$i],$old)) {
                    $ids
                }
            }
        } else {

        }

    }
}
