<?php

namespace App\Http\Controllers\Users;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Users\Ilha;
use App\Users\Setor;

class Setores extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setores = Setor::orderBy('name')->get();
        return $setores;
    }

    public function name($id, $json = FALSE)
    {
        $setores = Setor::find($id);
        if($json) {
            return $setores->toJSON();
        }
        return $setores;
    }

    public function byCarteiraJSON($carteira)
    {
        $setores = Setor::select('id','name')->where('carteira_id',$carteira)->orderBy('name')->get();

        return json_encode($setores);
    }

    public function byCarteira($carteira)
    {
        $setores = Setor::where('carteira_id',$carteira)->get();

        return ($setores);
    }

    public function areas(int$type, User $user)
    {
        $title = 'Áreas';
        $setores = Setor::all();
        $ilhas = Ilha::all();

        return view('gerenciamento.areas.index',compact('type','title','setores','ilha'));
    }
}
