<?php

namespace App\Http\Controllers\Tabs;

use App\Tab\Item;
use App\Tab\Modelo;
use App\Tab\Registro;
use App\Tab\Tabulacao;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;

class Tabulacoes extends Controller {
	public function operator(Request $request) {
		return view('tabs.operator');
	}

	public function supervisor(Request $request) {
		return view('tabs.supervisor');
	}

	public function backoffice(Request $request) {
		return view('tabs.backoffice');
	}
}