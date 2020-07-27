<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Quizzes\Quizzes;
use App\Http\Controllers\Permissions\UserPermission AS UserPermissionController;
use App\Permission\UserPermission;
use App\Permission\Permission;
use Auth;

class Permissions extends Controller
{

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

            return view('gerenciamento.permissions.index',compact('allPermissions', 'quiz'));
        } catch (Exception $e) {
            @$log = new Logs();
            @$log->logFileDay($e->getMessage());
            return back()->with('errorAlert','Erro desconhecido, tente novamente mais tarde.');
        }
    }
}
