<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Users\Carteira;
use App\Users\Ilha;
use App\Users\Setor;
use App\Http\Controllers\Users\Setores;
use Auth;

class Carteiras extends Controller
{

    public function index()
    {
        $carteira = Carteira::select('id','name')->orderBy('name')->get();

        return json_encode($carteira);
    }

    public function areas(int $type = 0)
    {
    	if($type === 0) {
    		$setores = new Setores();
    		return $setores->areas($type, Auth::user());
    	} else if($type === 1) {
    		$title = 'Áreas';
    		$carteiras = Carteira::all();
    		$setores = Setor::all();
    		$ilhas = Ilha::all();

    		return view('gerenciamento.areas.index',compact('type','title','carteiras','setores','ilhas'));
    	}

    	return back()->with('warningAlert','Requisição inválida');
    }

}
