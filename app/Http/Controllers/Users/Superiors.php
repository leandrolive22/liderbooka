<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users\Superior;
use App\Users\User;

class Superiors extends Controller
{
    public function getSup($id) {
        if($id == 0) {
            return json_encode(['id' => 0, 'name' => 'Nenhum Superior encontrado']);
        }
        $sup = Superior::where('user_id',$id)->get(['superior_id']);

        if($sup->count() == 0) {
            return json_encode(['id' => 0, 'name' => 'Nenhum Superior encontrado']);
        }

        $superior = User::find($sup[0]['superior_id']);

        return json_encode($superior);
    }

    public function getSupList($ilha,$cargo) {
        $cargo_id = $this->getSuperiorCargo($cargo);

        $sups = User::where('ilha_id',$ilha)->where('cargo_id',$cargo_id)->get(['id','name']);

        return $sups->toJSON();

    }

    public function getSuperiorCargo($cargo) : int {
        if($cargo == 5) { //5
            return 4;
        } else if($cargo == 4) { //4
            return 7;
        } else if($cargo == 7 || $cargo == 3 || $cargo == 6) { //3, 7, 6
            return 2;
        } else if($cargo == 2) { //2 - Gerente
            return 2;
        } else { //Developer
            return 1;
        }
    }

    public function getSub($id)
    {
        $sub = Superior::where('superior_id',$id)
                        ->get('user_id');

        return $sub;
    }

    public function register($id,$user) {
        $sup = new Superior();
        $sup->superior_id = $id;
        $sup->user_id = $user;
        $sup->save();
    }

    public function update($id,$user)
    {
        //$user é o usuario que será alterado
        //$id é o usuario que será o novo superior

        $sup = Superior::where('user_id',$user)
                        ->get()->delete();

        return $this->register($id,$user);
    }
}
