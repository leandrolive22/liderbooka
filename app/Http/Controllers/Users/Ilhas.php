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

    public function indexPost($select = '*',$where = NULL)
    {
        $ilhas = Ilha::selectRaw($select)
                    ->when(!is_null($where),function($q,$where) {
                        return $q->whereRaw($where);
                    })
                    ->orderBy('name')
                    ->get();
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
        $ilhas = Ilha::select('ilhas.id', 'ilhas.name', 's.name AS setor')
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
