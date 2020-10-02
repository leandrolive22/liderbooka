<?php

namespace App\Http\Controllers\Materials;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Permissions\Permissions;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Users\Ilhas;
use App\Http\Controllers\Users\Setores;
use App\Materials\Circular;
use App\Http\Controllers\Quizzes\Quizzes;
use App\Users\Setor;
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
        $titlePage = $title;
        $type = 'CIRCULAR';
        $p = new Permissions();
        $types = $p->wikiSearchType();

        if($types['tudo']) {
            $sql = "deleted_at IS NULL";
        } else if($types['carteira']) {
            $or = 'OR ';
            $carteira = Auth::user()->carteira_id;
            // Seleiona carteiras
            try {
                $setores = Ilha::select('ilhas.id')
                                ->join('book_usuarios.setores','setores.id','ilhas.setor_id')
                                ->where('setores.carteira_id',$carteira)
                                ->get();
            } catch (Exception $e) {
                $setores = [];
            }

            // monta select
            foreach($setores as $item) {
                $or .= "ilha_id LIKE '%".$item->id."%' OR ";
            }
            if(strlen($or) > 1) {
                $or = substr($or,0,-3);
            } else if(strlen($or) < 1) {
                unset($or);
                $or = "";
            }
            $sql = "(ilha_id LIKE '%,1,%' $or) AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%')";

        } else if($types['ilha']) {
            $sql = "(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%')";
        } else {
            $sql = "(ilha_id LIKE '%,1,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL";
        }

        //query
        $result = Circular::whereRaw($sql)
                            ->get();
        // Pega ilhas
        $ilhas = Ilha::select('id','name','setor_id')->get();

        // Cargos
        $cargos = Cargo::select('id','description')->get();

        return view('wiki.view',compact('result','title','titlePage','type', 'cargos', 'ilhas'));
    }

    public function year($year,$ilha)
    {
        $title = "Circulares $year";
        //dados de configuração de usuário
        $conf = json_decode(Auth::user()->another_config, TRUE);
        $cargo = Auth::user()->cargo_id;
        $titlePage = $title;
        $type = 'CIRCULAR';

        //query
        if(in_array(Auth::user()->cargo_id, [4,5])) {
            $result = Circular::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%')  AND deleted_at IS NULL")
                                ->where('year',$year)
                                ->latest()
                                ->get();
        } else {
            $result = Circular::latest()
                                    ->where('year',$year)
                                    ->get();
        }

        // Pega ilhas
        $ilhas = Ilha::select('id','name','setor_id')->get();

        // Cargos
        $cargos = Cargo::select('id','description')->get();

        return view('wiki.view',compact('result','title','titlePage','type', 'cargos', 'ilhas'));
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
            'cargo_id' => 'required',
            'circular' => 'required',
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
        try {
            return Circular::find($id);
        } catch (Exception $e) {
            return ['errorAlert' => $e->getMessage()];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        try {
            $rules = [
                'idEdit' => 'required',
                'nameEdit' => 'required',
                'islandEdit' => 'required',
                'cargo_idEdit' => 'required',
                'fileEdit' => 'required'
            ];
            $msgs = [
                'required' => 'Preencha todos os campos corretamentes'
            ];

            $id = $request->idEdit;
            $name = $request->nameEdit;
            $ilhas = $request->islandEdit;
            $cargos = $request->cargo_idEdit;
            $year = $request->yearEdit;
            $status = $request->statusEdit;
            $tags = str_replace(',', '#', $request->tagsEdit);
            $path = $request->file('fileEdit');

            // caso cargo seja tdoso
            if($cargos === ',all') {
                unset($cargos);
                $cargos = NULL;
            }

            // Ilha e setor
            $ilha = ',';
            $setor = ',';

            // separa ilha e setor
            foreach(explode(',',$ilhas) as $data) {
                $ilhaSetor = (explode('|',$data));
                if(isset($ilhaSetor[1])) {
                    $ilha .= $ilhaSetor[1].',';
                    $setor .= $ilhaSetor[0].',';
                }
            }

            // Busca objeto para alterar dados
            $update = Circular::find($id);

            // Caso não ache o objeto
            if(is_null($update)) {
                return back()->with(['errorAlert' => 'O Circular pode ter sido apagado ou editado, recarregue a página e tente novamente.']);
            }

            // Altera nome
            if($name !== $update->name) {
                $update->$name;
            }

            if(!is_null($year)) {
                $update->year = $year;
            }

            // Altera arquivo
            if(!is_null($path)) {
                $update->file_path = 'storage/' . $path->store('materials/scripts','public');;
            }

            // trata tags
            if(!is_null($tags)) {
                $update->tags = '#'.$tags;
            }

            // Altera ilhas
            if($ilhas !== 'N_A') {
                $update->ilha_id = str_replace('N_A','',$ilha);
                $update->sector = str_replace('N_A','',$setor);
            }

            if($cargos !== 'N_A') {
                $update->cargo_id = ','.str_replace('N_A','',$cargos);
            }

            $update->user_id = $user;

            if($update->save()) {
                return redirect(url()->previous())->with(['successAlert' => 'Circular Alterada com sucesso'],['newOnClick' => ['id' => $id, 'data' => $update->file_path]]);
            }

            return back()->json(['errorAlert' => 'Não foi possível alterar, contate o suporte']);
        } catch (Exception $e) {
            return back()->json(['errorAlert' => $e->getMessage()]);
        }
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

