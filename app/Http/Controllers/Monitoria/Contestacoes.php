<?php

namespace App\Http\Controllers\Monitoria;

use App\Http\Controllers\Controller;
use App\Monitoria\Contestacao;
use Illuminate\Http\Request;

class Contestacoes extends Controller
{
	/* 
	*
	*/
    public function showBy($id)
    {
    	try {
    		return Contestacao::where('monitoria_id',$id)->get();
    	} catch (Exception $e) {
    		return $e->getMessage();
    	}
    }

	public function store(Request $request)
    {
    	$rules = [
    		'motivo_id' => 'required|int',
    		'obs' => 'required|int',
    		'passo' => 'required|int',
    		'status' => 'required|int',
    		'monitoria_id' => 'required|int',
    	];

    	$messages = [
    		'required' => '',
    	];

    	$request->validate($rules,$messages);

    	// 
    	if($request->update) {
    		$const = Contestacao::find($request->contestacao_id);
    	} else {
			$const = new Contestacao();
    	}
    	$const = $request->motivo_id;
    	$const = $request->obs;
    	$const = $request->passo;
    	$const = $request->status;
    	$const = $request->monitoria_id;
    	if($const->save()) {

    	}

    }
}
