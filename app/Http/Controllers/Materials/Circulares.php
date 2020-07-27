<?php

namespace App\Http\Controllers\Materials;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
USE Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Users\Ilhas;
use App\Http\Controllers\Users\Setores;
use App\Materials\Circular;
use App\Http\Controllers\Quizzes\Quizzes;
use App\Users\Ilha;
use App\Users\Cargo;

class Circulares extends Controller
{

    public function index($ilha)
    {
        $title = 'Circulares';
        //dados de configuração de usuário
        $conf = json_decode(Auth::user()->another_config, TRUE);
        $cargo = Auth::user()->cargo_id;

        //query
        $circulares = Circular::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL")
                            ->get();

        return view('wiki.circulares',compact('circulares','title'));
    }

    public function year($year,$ilha)
    {
        $title = "Circulares $year";
        //dados de configuração de usuário
        $conf = json_decode(Auth::user()->another_config, TRUE);
        $cargo = Auth::user()->cargo_id;

        //query
        if(in_array(Auth::user()->cargo_id, [4,5])) {
            $circulares = Circular::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%')  AND deleted_at IS NULL")
                                ->where('year',$year)
                                ->latest()
                                ->get();
        } else {
            $circulares = Circular::latest()
                                    ->where('year',$year)
                                    ->get();
        }

        return view('wiki.circulares',compact('circulares','title'));
    }


    //pega numero das circulars
    public function getCount($ilha,$cargo) {
        $count = Circular::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL")->count();
        return $count;
    }

    public function create()
    {
        $setor_id = Auth::user()->setor_id;
        $cargo = Auth::user()->cargo_id;
        if(is_null($cargo) || is_null($setor_id) || !in_array($cargo, [1,2,3,7,9,15])) {
            return back()->with(['errorAlert' => 'Dados inválidos!<br>Você não tem acesso à essa ferramenta ou a requisição falhou.']);
        }

        // Pega ilhas
        $ilhas = Ilha::select('id','name','setor_id')->get();

        // Cargos
        $cargos = Cargo::select('id','description')->get();

        // Pega quizzes não vistos
        $q = new Quizzes();
        $quiz = $q->getQuizFromUser(Auth::user()->ilha_id, Auth::id());

        $title = 'Incluir Circular';
        return view('gerenciamento.materials.insert.circular',compact('title','ilhas','cargos', 'quiz'));
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
        ];
        $msgs = [
            'required' => ':attribute não pode ser nulo'
        ];

        $request->validate($rules, $msgs);

        $user = $request->input('user');
        $data = explode('|',$request->input('ilha_id'));

        // Ilha
        $ilha = ',';
        // Setor
        $setor = ',';
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

        $path = 'storage/' . $request->file('circular')->store('materials/circulars','public');
        $circular = new Circular();
        $circular->name = $request->input('name');
        $circular->number = $request->input('number');
        $circular->year = $request->input('year');
        $circular->file_path = $path;
        $circular->status = $request->input('status');
        $circular->setor_id = $setor;
        $circular->ilha_id = $ilha;
        $circular->cargo_id = $cargo;
        $circular->user_id = $user;
        $circular->save();

        return response()->json(['successAlert' => 'Circular inserida com sucesso!']);

    }

    public function show()
    {
        $circulares = Circular::all();
        return $circulares->toJSON();
    }

    public function allCirc()
    {
        $circulares = Circular::all();//paginate(10);
        return $circulares;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$user,Request $request)
    {
        $request->validate([
            'name' => 'required',
            'number' => 'required',
            'year' => 'required',
            'segment' => 'required',
            'status' => 'required',
            // 'setor_id' => 'required',
            'ilha_id' => 'required',
        ],[
            'required' => ':attribute não pode ser vazio'
        ]);

         // Trata variáveis
         foreach(explode(',',$request->input('ilha_id')) as $data) {
            $ilhaSetor = explode('|',$data);
            $ilha .= ','.$ilhaSetor[1].',';
            $setor .= ','.$ilhaSetor[0].',';
        }

        $path = 'storage/' . $request->file('circular')->store('materials/circulars','public');
        $circular = Circular::find($id);
        $circular->name = $request->input('name');
        $circular->number = $request->input('number');
        $circular->year = $request->input('year');
        $circular->file_path = $path;
        $circular->segment = $request->input('segment');
        $circular->status = $request->input('status');
        $circular->setor_id = $setor;
        $circular->ilha_id = $ilha;
        $circular->cargo_id = ','.$cargos.',';
        $circular->user_id = $user;

        if($circular->save()) {
            $log = new Logs();
            $log->circular($id,$ilha,$user,'EDIT_CIRCULAR_DATA');
            if($request->input('change') === 1) {
                return redirect()->route('GetCircularesEdit',['id' => $id]);
            } else {
                return response()->json(['success' => false], 204);
            }
        }
        else {
            return response()->json(['success' => false], 204);
        }

    }

    public function editGet($id) {
        $circular = Circular::find($id);
        $nome = $circular['name'];
        $title = "Editar Circular - $nome";

        return view('gerenciamento.materials.edit.editCirc',compact('title','circular'));
    }

    public function file(Request $request,$user) {
        $request->validate([
            'file' => 'required',
            'id' => 'required'
        ],
        [
            'required' => 'Selecione um arquivo!',
        ]);

        $id = $request->input('id');
        $path = 'storage/' . $request->file('file')->store('materials/circulars','public');

        $file = Circular::find($id);
        $file->user_id = $user;
        $file->file_path = $path;
        if($file->save()) {
            $ilha = $request->input('ilha');
            $log = new Logs();
            $log->circular($id,$ilha,$user,'EDIT_CIRCULAR_FILE');

            return redirect()->route('GetMaterialsManage')->with(['successAlert' => 'Upload feito com sucesso']);
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$user)
    {
        $circular = Circular::find($id);
        if($circular->delete()) {
            $ilha = $circular['ilha_id'];
            $log = new Logs();
            $log->circular($id,$ilha,$user,"DELETE_CIRCULAR");
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }

    }

    //baixa circular
    public function download($id, $user) {
        $circular = Circular::find($id);
        $path = asset($circular->file_path);

        $log = new Logs();
        $log->circular($circular->id,$circular->ilha_id,$user,'DOWNLOAD_CIRCULAR');

        return redirect($path);
    }

}

