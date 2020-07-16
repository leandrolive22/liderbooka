<?php

namespace App\Http\Controllers\Materials;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
USE Illuminate\Support\Facades\Auth;
use App\Users\Ilha;
use App\Users\Cargo;
use App\Materials\Roteiro;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Users\Ilhas;
use App\Http\Controllers\Users\Setores;

class Roteiros extends Controller
{

    public function index($ilha)
    {
        $title = 'Roteiros';
        $cargo = Auth::user()->cargo_id;
        $roteiros = Roteiro::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL")
                            ->get();

        return view('wiki.roteiros',compact('roteiros','title'));
    }

    //pega numero dos roteiros
    public function getCount($ilha,$cargo) {
        $count = Roteiro::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL")->count();
        return $count;
    }


    public function segment($segment,$ilha)
    {
        $title = "Roteiros $segment";
        $cargo = Auth::user()->cargo_id;
        $roteiros = Roteiro::whereRaw("((ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%')  OR sub_local_id LIKE '%,$segment,%') AND deleted_at IS NULL")
                            ->orderBy('name')
                            ->get();

        return view('wiki.roteiros',compact('roteiros','title'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user)
    {

        $rules = [
            'name' => 'required',
            'ilha_id' => 'required',
            'cargo_id' => 'required',
            'script' => 'required'
        ];
        $msgs = [
            'required' => 'O campo :attribute não pode estar vazio'
        ];

        $request->validate($rules, $msgs);

        // Ilha
        $ilha = ',';
        // Setor
        $setor = ',';
        // cargo
        $cargo = ','.$request->input('cargo_id');
        if($cargo == ',all') {
            unset($cargo);
            $cargo = NULL;
        }

        // Trata variáveis
        foreach(explode(',',$request->input('ilha_id')) as $data) {
            $ilhaSetor = (explode('|',$data));
            if(isset($ilhaSetor[1])) {
                // $ilhaSetor = explode('|',$data);
                $ilha .= $ilhaSetor[1].',';
                $setor .= $ilhaSetor[0].',';
            }
        }

        $path = 'storage/' . $request->file('script')->store('materials/scripts','public');
        $roteiros = new Roteiro();
        $roteiros->name = $request->input('name');
        $roteiros->file_path = $path;
        $roteiros->ilha_id = $ilha;
        $roteiros->sector = $setor;
        $roteiros->cargo_id = $cargo;
        $roteiros->user_id = $user;
        $roteiros->save();

        return response()->json(['successAlert' => 'Roteiro inserido com sucesso!'], 201);
    }

    public function edit($id, $user, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sub_local_id' => 'required',
            'ilha_id' => 'required',
            'setor_id' => 'required',
            'change' => 'required',
        ],[
            'required' => ':attribute não pode ser vazio'
        ]);

        $ilha = $request->input('ilha_id');

        $roteiro = Roteiro::find($id);
        $roteiro->name = $request->input('name');
        $roteiro->sub_local_id = $request->input('sub_local_id');
        $roteiro->ilha_id = $ilha;
        $roteiro->sector = $request->input('setor_id');
        $roteiro->user_id = $user;

        if($roteiro->save()) {
            $log = new Logs();
            $log->script($id,$ilha,$user,'EDIT_SCRIPT_DATA');

            if($request->input('change') === 1) {
                return redirect()->route('GetRoteirosEdit',['id' => $id]);
            } else {
                return response()->json(['success' => false, 'errorAlert' => 'Alterações Salvas, não foi possível redirecionar'], 204);
            }
        }
        else {
            return response()->json(['success' => false, 'errorAlert' => 'Não foi possível editar roteiro'], 204);
        }

    }

    public function editGet($id) {
        $roteiro = Roteiro::find($id);
        $nome = $roteiro['name'];
        $title = "Editar Roteiro - $nome";

        return view('gerenciamento.materials.edit.editScript',compact('title','roteiro'));
    }


    public function show()
    {
        $roteiros = Roteiro::all();
        return $roteiros->toJSON();
    }

    public function allScripts()
    {
        $roteiros = Roteiro::all();//paginate(10);
        return $roteiros;
    }


    public function create()
    {

        $setor_id = Auth::user()->setor_id;
        $cargo = Auth::user()->cargo_id;
        if(is_null($cargo) || is_null($setor_id) || !in_array($cargo, [1,2,3,7,9,15])) {
            return back()->with(['errorAlert' => 'Dados inválidos!<br>Você não tem acesso à essa ferramenta ou a requisição falhou.']);
        }

        // pega setores
        $setor = new Setores();
        $setores = $setor->index();

        //pega ilhas
        $ilhas = Ilha::select('id','name','setor_id')->get();

        // Cargos
        $cargos = Cargo::select('id','description')->get();

        $title = 'Incluir Roteiro';
        return view('gerenciamento.materials.insert.roteiro',compact('title','setores','ilhas','cargos'));

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

    public function file(Request $request,$user) {
        $request->validate([
            'file' => 'required',
            'id' => 'required',
            'ilha' => 'required',
        ],
        [
            'required' => 'Selecione um arquivo!',
        ]);
        $id = $request->input('id');
        $ilha = $request->input('ilha_id');
        $path = 'storage/' . $request->file('file')->store('materials/scripts','public');

        $file = Roteiro::find($id);
        $file->user_id = $user;
        $file->file_path = $path;
        if($file->save()) {
            $log = new Logs();
            $log->script($id,$ilha,$user,'EDIT_SCRIPT_FILE');

            return redirect()->route('GetMaterialsManage')->with(['successAlert' => 'Upload feito com sucesso']);
        }

    }

    public function destroy($id,$user)
    {
        $roteiro = Roteiro::find($id);
        if($roteiro->delete()) {
            $ilha = $roteiro['ilha_id'];
            $log = new Logs();
            $log->script($id,$ilha,$user,"DELETE_SCRIPT");
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }

    }

    //baixa roteiro
    public function download($id, $user) {
        $Roteiro = Roteiro::find($id);
        $path = asset($Roteiro->file_path);

        $log = new Logs();
        $log->script($Roteiro->id,$Roteiro->ilha_id,$user,'DOWNLOAD_SCRIPT');

        return redirect($path);
    }

}
