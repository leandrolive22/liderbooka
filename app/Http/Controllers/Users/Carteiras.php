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

        $title = 'Áreas';
        $carteiras = Carteira::all();
        $setores = Setor::all();
        $ilhas = Ilha::all();
        $compact = compact('type','title','carteiras','setores','ilhas');

        return view('gerenciamento.areas.index',$compact);
    }

    public function getSetoresIlhasByCart($id)
    {
        try {
            return Setor::leftJoin('ilhas','setores.id','ilhas.setor_id')
                        ->select('setores.id as setor','ilhas.id as ilha')
                        ->where('carteira_id',$id)
                        ->get()
                        ->toJSON();
        } catch (Exception $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function sync(Request $request)
    {
        $rules = [
            'carteira' => 'required',
            'setores' => 'required',
        ];

        $message = [
            'carteira.required' => 'Selecione uma :attribute!',            
            'setores.required' => 'Selecione os :attribute corretamente!',
        ];
        try {
            // Trata requisição
            $request->validate($rules, $message);

            $c = $request->carteira;
            $setores = explode('|',substr($request->setores,0,-1));

            $carteira = Carteira::find($c);
            if(is_null($carteira)) {
                return response()->json(['errorAlert' => 'Carteira não identificada, recarregue a página'],422);
            }

            Setor::whereIn('id',$setores)->update('carteira_id',$carteira);
            Setor::whereNotIn('id',$setores)->delete();

            return response()->json(['Sincronizado com sucesso!'],201);

        } catch (Exception $e) {
            return response()->json(['errorAlert' => $e->getMessage()],500);
        }
    }

}
