<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Users\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Cargos extends Controller
{

    public function index()
    {
        $cargos = Cargo::orderBy('description')->get();

        return $cargos->toJSON();
    }

    public function selectCustom($query, $orderBy = NULL) {
        return Cargo::selectRaw($query)
                    ->when(!is_null($orderBy), function($q) use($orderBy){
                        return $q->orderBy(DB::raw($orderBy));
                    })
                    ->get();
    }

    public function nameCargo($id) {
        $cargo = Cargo::find($id);
        return $cargo->toJSON();
    }

}
