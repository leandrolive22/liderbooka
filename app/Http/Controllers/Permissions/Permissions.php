<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use App\Permission\Permission;
use App\Http\Controllers\Permissions\UserPermission AS UserPermissionController;
use App\Permission\UserPermission;
use App\Http\Controllers\Logs\Logs;
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
            $user = Auth::user();
            $permissions = new UserPermissionController($user);
            $permissions_ids = $permissoins->getPermissionsIds();
            $allPermissions = $this->allPermissions(in_array(1,$permissions_ids));

            return view('gerenciamento.permissions.index',compact($allPermissions));   
        } catch (Exception $e) {
            @$log = new Logs();
            @$log->logFileDay($e->getMessage());
            return back()->with('errorAlert','Erro desconhecido, tente novamente mais tarde.');
        }
    }
}
