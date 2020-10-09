<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Users\Carteira;
use App\Users\Ilha;
use App\Users\Setor;
use App\Http\Controllers\Users\Setores;
use Auth;
use Cache;

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
        if(is_null(Cache::get('getCarteiras'))) {
            $carteiras = Cache::get('getCarteiras');
        } else {
            $carteiras = Carteira::all();
            Cache::put('getCarteiras',$carteiras,720);
        }

        if(is_null(Cache::get('getSetores'))) {
            $setores = Cache::get('getSetores');
        } else {
            $setores = Setor::all();
            Cache::put('getSetores',$setores,720);
        }

        if(is_null(Cache::get('getIlhas'))) {
            $ilhas = Cache::get('getIlhas');
        } else {
            $ilhas = Ilha::all();
            Cache::put('getIlhas',$ilhas,720);
        }
        
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

            $search = Setor::whereNotIn('id',$setores)->where('carteira_id',$c);
            if($search->count() > 0) {
                $search->update(['carteira_id' => NULL]);
            }

            if(Setor::whereIn('id',$setores)->update(['carteira_id' => $c])) {
                $this->forgetCache();
                return response()->json(['successAlert' => 'Sincronizado com sucesso!'],201);
            }

            return response()->json(['errorAlert' => 'Erro ao sincronizar, recarregue a página e tente novamente!'],422);

        } catch (Exception $e) {
            return response()->json(['errorAlert' => $e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
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

            if(Setor::whereIn('id',$setores)->delete() && $carteira->delete()) {
                return response()->json(['successAlert' => 'Deletado com sucesso!'],201);
            }

            return response()->json(['errorAlert' => 'Erro ao sincronizar, recarregue a página e tente novamente'],422);

        } catch (Exception $e) {
            return response()->json(['errorAlert' => $e->getMessage()],500);
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'carteira' => 'required',
        ];

        $message = [
            'carteira.required' => 'Preencha o campo :attribute corretamente!',
        ];
        try {
            // Trata requisição
            $request->validate($rules, $message);
            $name = $request->carteira;
            $insert = new Carteira();
            $insert->name = $name;
            if($insert->save()) {
                return redirect(url()->previous())->with('successAlert','Carteira inserida com sucesso!');
            }

            return back()->with('errorAlert','Erro ao inserir, contate o suporte!');
        } catch (Exception $e) {
            return back()->with('errorAlert',$e->getMessage());
        }
    }

    public function forgetCache()
    {
        try {
            Cache::forget('getSetores');
            Cache::forget('getIlhas');
            Cache::forget('getCarteiras');
        } catch (Exception $e) {
            return 0;
        }
    }

}
