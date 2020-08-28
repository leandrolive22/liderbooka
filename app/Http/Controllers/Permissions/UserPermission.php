<?php

namespace App\Http\Controllers\Permissions;

use App\User;
use App\Http\Controllers\Controller;
use App\Permission\Permission;
use App\Permission\UserPermission AS UserPermissionModel;

class UserPermission extends Controller
{
	protected $user;
    protected $permissions;

    // busca e configura as permissões do usuário  
    public function __construct(User $user)
    {
        $this->setUser($user);
        $permissions = $this->fetchUserPermissions();
        $this->setPermissions($permissions);
    }

    /* Getter's and Setter's */
    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }

    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;
    }

    // Pega no DB as permissões do usuário
    protected function fetchUserPermissions()
    {
        $id = $this->getUser()->id;
        $userPermissions = UserPermissionModel::selectRaw('user_id, permission_id, users.name, user_permissions.id')
                                ->leftJoin('book_usuarios.users','users.id','user_id')
                                ->where('user_permissions.user_id',$id)
                                ->get();

        return $userPermissions;
    }

    // Pega id das permissões
    public function getPermissionsIds() : array
    {
        $arr = [];

        foreach($this->getPermissions() as $item) {
            $arr[] = $item->permission_id;
        }

        return $arr;
    }

    // Pega id da tabela user_permissions
    public function getUserPermissionsIds() : array
    {
        $permissions = $this->getPermissions();
        $arr = [];

        foreach($permissions as $item) {
            $arr[] = $item->id;
        }

        return $arr;
    }

    // Pega nome das permissões
    public function getPermissionsNames() : array
    {
        $permissions = $this->getPermissions();
        $arr = [];

        foreach($permissions as $item) {
            $arr[] = $item->name;
        }

        return $arr;
    }

    public function newPermissions(array $permissions) : array
    {
        $old = $this->getPermissionsIds();
        $new = [];

        foreach($permissions AS $item) {
            // Verifica se novas permissões são as mesmas do que as do antigas e concatena as novas
            if(!in_array($item,$old)) {
                $new[] = $item;
            }
        }

        foreach($old AS $item) {
            // Verifica se novas permissões são as mesmas do que as do antigas e concatena as antigas
            if(in_array($item,$permissions)) {
                $new[] = $item;
            }
        }

        return $new;
    }
}