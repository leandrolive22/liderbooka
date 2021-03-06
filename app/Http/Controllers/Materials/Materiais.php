<?php

namespace App\Http\Controllers\Materials;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Users\Ilhas;
use App\Http\Controllers\Users\Setores;
use App\Materials\Material;
use App\Users\Cargo;
use App\Users\Ilha;
use App\Http\Controllers\Quizzes\Quizzes;
use Illuminate\Support\Facades\DB;


class Materiais extends Controller
{

    public function index($ilha)
    {
        $title = 'Materiais';
        $cargo = Auth::user()->cargo_id;
        $result = Material::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL")
        ->orderBy('created_at','desc') 
        ->paginate(10);

        $titlePage = $title;
        $type = 'MATERIAL';

        // Pega ilhas
        $ilhas = Ilha::select('id','name','setor_id')->get();

        // Cargos
        $cargos = Cargo::select('id','description')->get();

        return view('wiki.view',compact('result','title','titlePage','type', 'cargos', 'ilhas'));
    }



    public function pesquisar($campo, $valor,$ilha, Request $tipo ) {
     $title = 'Materiais';
     $titlePage = $title;
     $cargo = "1";
     $type = 'MATERIAL';
     $result = Material::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL")
     ->paginate(10);

     // Pega ilhas
     $ilhas = Ilha::select('id','name','setor_id')->get();

     // Cargos
     $cargos = Cargo::select('id','description')->get();

        // Atualizando no banco de dados
            switch ($campo) {
                case 'nome':
                    return $resultado = Material::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL AND name LIKE '%$valor%'")->get();
                    break;
                
                case 'id':
                    return $resultado = Material::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') 
                    AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL AND id LIKE ?"
                    ,[$valor])->get();
                    break;
        
                case 'tags':
                    return $resultado = Material::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') 
                    AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL AND tags LIKE '%#?%'"
                    ,[$valor])->get();
                    break;

                default:
                    # code...
                    break;
            }

    }

    
    public function filtros($valor) {
        $title = 'Materiais';
        $titlePage = $title;
        $ilha = "13";
        $cargo = "1";
        $type = 'MATERIAL';
   
        $result = Material::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL")
        ->paginate(10);
   
        // Pega ilhas
        $ilhas = Ilha::select('id','name','setor_id')->get();
   
        // Cargos
        $cargos = Cargo::select('id','description')->get();
   
        return $resultado = Material::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL AND tags LIKE '%$valor%'")->get();
       }
 

    public function usuarios()
    {
        $usuarios =  DB::select("SELECT * FROM book_relatorios.logs WHERE value LIKE '%VIDEO%'");
        return view('reports.video',compact('usuarios'));
    }

    //pega numero dos materiais
    public function getCount($ilha,$cargo) {
        $count = Material::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL")->count();
        return $count;
    }

    public function segment($segment,$ilha)
    {
        $title = "Materiais $segment";
        $cargo = Auth::user()->cargo_id;
        $result = Material::whereRaw("((ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') OR sub_local_id LIKE '%,$segment,%') AND deleted_at IS NULL")
                            ->orderBy('name')
                            ->get();

        $titlePage = $title;
        $type = 'MATERIAL';

        // Pega ilhas
        $ilhas = Ilha::select('id','name','setor_id')->get();

        // Cargos
        $cargos = Cargo::select('id','description')->get();

        return view('wiki.view',compact('result','title','titlePage','type', 'cargos', 'ilhas'));
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
            'material' => 'required',
            'tags' => 'required'
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

        $path = 'storage/' . $request->file('material')->store('materials/materials','public');
        $materiais = new Material();
        $materiais->name = $request->input('name');
        $materiais->file_path = $path;
        $materiais->ilha_id = $ilha;
        $materiais->sector = $setor;
        $materiais->tags = $request->input('tags');
        $materiais->cargo_id = $cargo;
        $materiais->user_id = $user;
        $materiais->save();

        return response()->json(['successAlert' => 'Material inserido com sucesso!'], 201);
    }

    public function edit($id, $user, Request $request)
    {

    }

    public function editGet($id) {
        try {
            return Material::find($id);
        } catch (Exception $e) {
            return ['errorAlert' => $e->getMessage()];
        }
    }

    public function show()
    {
        $materiais = Material::all();
        return $materiais->toJSON();
    }

    public function allMaterials()
    {
        $materiais = Material::paginate(1);
        return $materiais;
    }


    public function create()
    {
        $setor_id = Auth::user()->setor_id;
        $cargo = Auth::user()->cargo_id;
        if(is_null($cargo) || is_null($setor_id) || !in_array($cargo, [1,2,3,7,9,15])) {
            return back()->with(['errorAlert' => 'Dados inválidos!<br>Você não tem acesso à essa ferramenta ou a requisição falhou.']);
        }

        // setores
        $setor = new Setores();
        $setores = $setor->index();

        //pega ilhas
        $ilhas = Ilha::select('id','name','setor_id')->get();

        // Cargos
        $cargos = Cargo::select('id','description')->get();

        // Pega quizzes não vistos
        $q = new Quizzes();
        $quiz = $q->getQuizFromUser(Auth::user()->ilha_id, Auth::id());

        $title = 'Incluir material';
        return view('gerenciamento.materials.insert.materiais',compact('title','setores','ilhas','cargos', 'quiz'));

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
            $update = Material::find($id);

            // Caso não ache o objeto
            if(is_null($update)) {
                return back()->with(['errorAlert' => 'O Material pode ter sido apagado ou editado, recarregue a página e tente novamente.']);
            }

            // Altera nome
            if($name !== $update->name) {
                $update->$name;
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
                return redirect(url()->previous())->with(['successAlert' => 'Material Alterado com sucesso'],['newOnClick' => ['id' => $id, 'data' => $update->file_path]]);
            }

            return back()->json(['errorAlert' => 'Não foi possível alterar, contate o suporte']);
        } catch (Exception $e) {
            return back()->json(['errorAlert' => $e->getMessage()]);
        }
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
        $path = 'storage/' . $request->file('file')->store('materials/materials','public');

        $file = Material::find($id);
        $file->user_id = $user;
        $file->file_path = $path;
        if($file->save()) {
            $log = new Logs();
            $log->material($id,$ilha,$user,'EDIT_MATERIAL_FILE');

            return redirect()->route('GetMaterialsManage')->with(['successAlert' => 'Upload feito com sucesso']);
        }

    }

    public function destroy($id,$user)
    {
        $material = Material::find($id);
        if($material->delete()) {
            $ilha = $material['ilha_id'];
            $log = new Logs();
            $log->material($id,$ilha,$user,"DELETE_MATERIAL");
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }

    }

    //baixa material
    public function download($id, $user) {
        $material = Material::find($id);
        $path = asset($material->file_path);

        $log = new Logs();
        $log->material($material->id,$material->ilha_id,$user,'DOWNLOAD_MATERIAL');

        return redirect($path);
    }

}
