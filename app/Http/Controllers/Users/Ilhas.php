<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Users\Ilha;

class Ilhas extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ilhas = Ilha::where('id','<>',1)
                    ->get();

        return $ilhas->toJSON();
    }

    public function indexPost($select = '*',$where = NULL, $json = TRUE)
    {
        $ilhas = Ilha::selectRaw($select)
                    ->when(!is_null($where),function($q) use ($where) {
                        return $q->whereRaw($where);
                    })
                    ->orderBy('name')
                    ->get();
        if(!$json) {
            return $ilhas;
        }
        return $ilhas->toJSON();
    }

    public function nameIlha($id) {
            $ilha = Ilha::find($id);
            return $ilha->toJSON();
    }

    public function bySetor($setor_id) {
        $ilhas = Ilha::where('setor_id', $setor_id)
                    ->orderBy('name','ASC')
                    ->get();
        return $ilhas->toJSON();
    }

    public function sectorByIlha($ilha)
    {
        $ilhas = Ilha::find($ilha);

        return $ilhas;
    }

    public function getIlhas($setor = 0)
    {
        $ilhas = Ilha::select('ilhas.id', 'ilhas.name', 's.name AS setor', 's.id As setor_id')
                    ->leftJoin('setores AS s','s.id','ilhas.setor_id')
                    ->when($setor > 0, function($q) use ($setor) {
                        return $q->where('ilhas.setor_id',$setor);
                    })
                    ->orderBy('setor')
                    ->get();

        if($ilhas->count() > 0) {
            return $ilhas->toJSON();
        }

        return [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(array $data, $setor_id)
    {
        $rules = [
            'setores' => 'required',
        ];

        $message = [
            'setor.required' => 'Error, :attribute incorreto, contate o suporte!',
        ];

        // Trata requisição
        $request->validate($rules, $message);

        // variaveis
        $i = $request->ilhas;
        $s = $request->setores;
        
        try {
            // Se existe ilha
            if(is_null($s)) {
                return response()->json(['Setor obrigatório',422]);
            }

            // Se existe ilha
            if(!is_null($i)) {
                $ilhas = explode('|',substr($i,0,-1));

                // Altera as ilhas
                ILha::whereIn('id',$ilhas)->update(['setor_id' => $s]);

                // Exclui ilhas 
                ILha::whereNotIn('id',$ilhas)->update(['setor_id' => NULL]);
                return response()->json(['Sincronizado com sucesso!',201]);
            } else {
                if(Ilha::where('setor_id',$s)->delete()) {
                    return response()->json(['Sincronizado com sucesso!',201]);
                } else {
                    return response()->json(['Erro ao excluir setor, contate o suporte!',422]);
                }
            }
        } catch (Exception $e) {
            return response()->json(['errorAlert' => $e->getMessage()],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Ilha::find($id)->delete();
            return response()->json(['successAlert' => 'Excluído com sucesso!',201]);
        } catch (Exception $e) {
            return response()->json(['errorAlert' => $e->getMessage()],500);   
        }
    }
}
