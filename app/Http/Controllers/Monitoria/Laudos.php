<?php

namespace App\Http\Controllers\Monitoria;

use App\Monitoria\Item;
use App\Monitoria\Laudo;
use App\Users\Ilha;
use App\Users\User;
use App\Users\Carteira;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Laudos extends Controller
{
    // view que Cria Laudos de monitoria
    public function create()
    {
        $title = 'Criar Modelo/Laudo';
        $carteiras = Carteira::select('id','name')
                    ->orderBy('name')
                    ->get();

        return view('monitoring.makeModels',compact('title','carteiras'));
    }

    // view que Cria Laudos de monitoria
    public function edit($i)
    {
        $id = base64_decode($i);
        $title = 'Editar Modelo/Laudo';
        $carteiras = Carteira::select('id','name')
                    ->get();

        $laudo = Laudo::find($id);
        $count = $laudo->count();

        return view('monitoring.makeModels',compact('title','carteiras','laudo','count'));
    }

    public function toApply($model, Request $request)
    {
        if($request->method() === "GET") {
            return back()->with('errorAlert','Selecione primeiro um operador!');
        }

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

        if(!is_null($laudo) || $laudo->count() > 0 || $operador->count() > 0) {
            return view('monitoring.makeMonitoria',compact('laudo','model','title','users','ilhas','supers','id','operador'));
        }

        return redirect()->route('GetMonitoriasIndex')->with('errorAlert','Erro ao carregar informações do laudo, contato o suporte.');
    }

    public function store($user, Request $request)
    {
        $rules = [
            'title' => 'required|min:3',
            'laudos' => 'required',
            'carteira_id' => 'required|int',
            'tipo_monitoria' => 'required|min:3',
        ];

        $messages = [
            'title.required' => 'Prencha o campo titulo corretamente',
            'tipo_monitoria.required' => 'Prencha o campo Tipo de Laudo corretamente',
            'title.min' => 'Quantidade de caracteres inválidos para o campo Titulo',
            'tipo_monitoria.min' => 'Quantidade de caracteres inválidos para o campo Tipo de Laudo',
        ];

        $request->validate($rules,$messages);

        // DEBUG
        // return response()->json([$_POST['laudos']], 422);

        // trata variaveis
        $title = $request->input('title');
        $carteira_id = $request->carteira_id;
        $tipo_monitoria = $request->input('tipo_monitoria');
        $laudos = explode('_______________',substr($request->input('laudos'),0,-15));
        $valor = $request->input('valor');
        $valores = $request->input('valores');

        //Cria laudo
        $laudo = new Laudo();
        $laudo->titulo = $title;
        $laudo->carteira_id = $carteira_id;
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
                    // $array[3] - Não utilizado na inserção, apenas edição
                    if($array[4] === 0) {
                        $valorArray = $valor;
                    } else {
                        $valorArray = (str_replace('|','.',$array[4])/100);
                    }

                    $itensInsert[] = [
                        'numero' => str_replace('|',',',$numberArray),
                        'questao' => str_replace('|',',',$perguntaArray),
                        'sinalizacao' => str_replace('|',',',$sinalArray),
                        'procedimento' =>  'Conforme;Não Conforme; Não Avaliado',
                        'valor' => $valorArray,
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

    //altera Laudo
    public function update($user, Request $request)
    {
        $rules = [
            'title' => 'required|min:3',
            'laudos' => 'required',
            'carteira_id' => 'required|int',
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
        $error = 0;
        $ids = '';
        $id = $request->laudo_id;
        $carteira_id = $request->carteira_id;
        $title = $request->input('title');
        $tipo_monitoria = $request->input('tipo_monitoria');
        $laudos = explode('_______________',substr($request->input('laudos'),0,-15));
        $valor = $request->input('valor');

        //Cria laudo
        $laudo = Laudo::find($id);
        $laudo->titulo = $title;
        $laudo->carteira_id = $carteira_id;
        $laudo->tipo_monitoria = $tipo_monitoria;
        $laudo->creator_id = $user;
        if($laudo->save()) {
            // array bulk update and id modelo
            $itensUpdate = [];

            //monta insert de itens
            foreach($laudos as $item) {
                $array = explode(',',$item);
                if(isset($item[2])) {
                    $numberArray = $array[0];
                    $perguntaArray = $array[1];
                    $sinalArray = $array[2];
                    $idArray = $array[3];
                    if($array[4] === 0) {
                        $valorArray = $valor;
                    } else {
                        $valorArray = ($array[4]/100);
                    }


                    if(count(explode('_',$idArray)) == 2) {
                        $newId = explode('_',$idArray)[1];
                        $ids .= $newId.',';
                        $up = Item::where('id', $newId)->update([
                                                'numero' => $numberArray,
                                                'questao' => $perguntaArray,
                                                'sinalizacao' => $sinalArray,
                                                'procedimento' =>  'Conforme;Não Conforme; Não Avaliado',
                                                'valor' => $valorArray,
                                                'creator_id' => $user,
                                                'updated_at' => date('Y-m-d H:i:s'),
                                            ]);
                    } else {
                        $up = new Item();
                        $up->modelo_id = $id;
                        $up->numero = $numberArray;
                        $up->questao = $perguntaArray;
                        $up->sinalizacao = $sinalArray;
                        $up->procedimento =  'Conforme;Não Conforme; Não Avaliado';
                        $up->valor = $valor;
                        $up->creator_id = $user;
                        $up->save();

                        $ids .= $up->id.',';
                    }
                    if(!$up) {
                        $error++;
                    }
                }
            }

            if($error === 0) {
                Item::whereNotIn('id',explode(',',$ids))->where('modelo_id',$id)->delete();
                return response()->json(['success' => TRUE, 'msg' => 'Laudo alterado com sucesso!', 'id' => $id,], 201);
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
