<?php

namespace App\Http\Controllers\Monitoria;

use App\Monitoria\Item;
use App\Monitoria\Laudo;
use App\Users\Ilha;
use App\Users\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Laudos extends Controller
{
    public function toApply($model, Request $request)
    {
        $title = 'Aplicar Monitoria';
        $carteira = Auth::user()->carteira_id;

        $laudo = Laudo::find($model);
        $users = User::select('id','name','supervisor_id')
                    ->whereIn('cargo_id',[5])
                    ->where('carteira_id',Auth::user()->carteira_id)
                    ->orderBy('name')
                    ->get();
        $supers = User::select('id','name')
                    ->whereIn('cargo_id',[4])
                    ->orderBy('name')
                    ->get();

        $ilhas = Ilha::select('id','name')
                    // ->where('deleted_at','IS','NULL')
                    ->orderBy('name')
                    ->get();
        $operador = User::selectRaw('users.ilha_id, users.id, users.name, s.name AS supervisor')
                        ->leftJoin('users As s','s.id','users.supervisor_id')
                        ->where('users.id',$request->userToApply)
                        ->first();
        // não é update
        $id = 0;

        if(is_null($laudo) || $laudo->count() > 0 || $operador->count() > 0) {
            return view('monitoring.makeMonitoria',compact('laudo','model','title','users','ilhas','supers', 'id', 'operador'));
        }

        return redirect()->route('GetMonitoriasIndex')->with('errorAlert','Erro ao carregar informações do laudo, contato o suporte.');
    }

    public function store($user, Request $request)
    {
        $rules = [
            'title' => 'required|min:3',
            'laudos' => 'required',
            'tipo_monitoria' => 'required|min:3',
        ];

        $messages = [
            'title.required' => 'Prencha o campo titulo corretamente',
            'tipo_monitoria.required' => 'Prencha o campo Tipo de Laudo corretamente',
            'title.min' => 'Quantidade de caracteres inválidos para o campo Titulo',
            'tipo_monitoria.min' => 'Quantidade de caracteres inválidos para o campo Tipo de Laudo',
        ];

        $request->validate($rules,$messages);

        // trata variaveis
        $title = $request->input('title');
        $tipo_monitoria = $request->input('tipo_monitoria');
        $laudos = explode('_______________',substr($request->input('laudos'),0,-15));
        $valor = $request->input('valor');

        //Cria laudo
        $laudo = new Laudo();
        $laudo->titulo = $title;
        $laudo->tipo_monitoria = $tipo_monitoria;
        $laudo->creator_id = $user;
        if($laudo->save()) {
            // array bulk insert and id modelo
            $itensInsert = [];
            $id = $laudo->id;

            //monta insert de itens
            foreach($laudos as $item) {
                $array = explode(',',$item);
                if(isset($item[2])) {
                    $numberArray = $array[0];
                    $perguntaArray = $array[1];
                    $sinalArray = $array[2];

                    $itensInsert[] = [
                        'numero' => $numberArray,
                        'questao' => $perguntaArray,
                        'sinalizacao' => $sinalArray,
                        'procedimento' =>  'Conforme;Não Conforme; Não Avaliado',
                        'valor' => $valor,
                        'creator_id' => $user,
                        'modelo_id' => $id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }
            }

            //insere
            $itens = Item::insert($itensInsert);
            if($itens) {
                return response()->json(['success' => TRUE, 'msg' => 'Laudos salvo com sucesso!', 'id' => $id,], 201);
            } else {
                @Laudo::find($id)->delete();
                return response()->json([$itens->errors()->all()], 422);
            }
        }
    }

    // Exclui laudo
    public function delete($user,$id) {
        if($delete = Laudo::find($id)->delete()) {
            // regitra log
            $log = new Logs();
            $log->log("DELETE_MONITORIA", $id, 'delete_monitoria', $user, intval(@User::find($user)->ilha_id));

            if(Item::where('modelo_id',$id)->delete()) {
                return response()->json(['success' => TRUE, 'msg' => 'Modelo e Itens Excluídos com sucesso!'], 200);
            }
            return response()->json(['success' => TRUE, 'msg' => 'Modelo Excluído com sucesso!<br>Entre em contato com o desenvolvimento para excluir os itens da monitoria'], 200);
        }

        return response()->json($delete->errors()->all(), 500);
    }
}
