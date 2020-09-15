<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Users\Cargo;

class Cargos extends Controller
{

    public function index()
    {
        $cargos = Cargo::orderBy('description')->get();

        return $cargos->toJSON();
    }

    public function selectCustom($query) {
    	return $cargos = Cargo::selectRaw($query)->get();
    }

    public function nameCargo($id) {
        $cargo = Cargo::find($id);
        return $cargo->toJSON();
    }

}
