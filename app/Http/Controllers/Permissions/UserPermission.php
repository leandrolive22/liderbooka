<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use App\Permission\Permission;
use App\Permission\UserPermission AS UserPermissionModel;

class UserPermission extends Controller
{
	protected $user;
    protected $permissions;

    public function __construct($user) {
        $this->setUser($user);
        $permissions = $this->fetchUserPermissions();
        $this->setPermissions($permissions);
        $this->getPermissionsIds();
        $this->getPermissionsNames();
    }

    protected function fetchUserPermissions()
    {
        $id = $this->getUser()->id;
        $userPermissions = UserPermissionModel::where('user_id',$id)
                                        ->get();

        return $userPermissions;

    }

    // Pega id
    public function getPermissionsIds() {
        $permissions = $this->permissions;
        $arr = [];

        foreach($permissions as $item) {
            $arr[] = $item->id;
        }

        return $arr;
    }

    // Pega nome
    public function getPermissionsNames()
    {
        $permissions = $this->permissions;
        $arr = [];

        foreach($permissions as $item) {
            $arr[] = $item->name;
        }

        return $arr;
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
}