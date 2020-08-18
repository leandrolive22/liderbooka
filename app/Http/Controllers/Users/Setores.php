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

    public function store(Request $request)
    {
        $rules = [
            'carteira_id' => 'required',
            'setores' => 'required',
        ];

        $message = [
            'carteira.required' => 'Selecione uma :attribute corretamente!',
            'setores.required' => 'Selecione uma :attribute corretamente!',
        ];

        $date = date('Y-m-d H:i:s');
        $setores = [];
        foreach(explode('|',substr($request->setores,0,-1)) as $item) {
            $arr = [];
            $arr['name'] = $item;
            $arr['carteira_id'] = $request->carteira_id;
            $arr['created_at'] = $date;
            $arr['updated_at'] = $date;

            array_push($setores, $arr);
        }

        try {
            // bulk insert
            if(Setor::insert($setores)) {
                return redirect(url()->previous())->with('successAlert','Setor(es) inserid(a) com sucesso!');
            }

            return back()->with('errorAlert','Erro ao inserir, contate o suporte!');
        } catch (Exception $e) {
            return back()->with('errorAlert',$e->getMessage());
        }
    }
}
