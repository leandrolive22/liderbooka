<?php

namespace App\Http\Controllers\Materials;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
USE Illuminate\Support\Facades\Auth;
use App\Materials\Video;
use App\Users\Ilha;
use App\Users\Cargo;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Quizzes\Quizzes;
use App\Http\Controllers\Users\Ilhas;
use App\Http\Controllers\Users\Setores;


class Videos extends Controller
{

    public function index($ilha)
    {
        $title = 'Videos';
        $cargo = Auth::user()->cargo_id;
        $titlePage = $title;
        $type = 'VIDEO';

        $result = Video::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL")->get();
        
        return view('wiki.view',compact('result','title','titlePage','type'));
    }


    public function relatorio()
    {
        return view('reports.video');
    }
    //pega numero dos videos
    public function getCount($ilha,$cargo) {
        $count = Video::whereRaw("(ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND deleted_at IS NULL")->count();
        return $count;
    }

    public function segment($segment,$ilha)
    {
        $title = "Videos";
        $cargo = Auth::user()->cargo_id;
        $result = Video::whereRaw("((ilha_id LIKE '%,1,%' OR ilha_id LIKE '%,$ilha,%') AND (cargo_id is NULL OR cargo_id LIKE '%,$cargo,%') AND sub_local_id LIKE '%$segment%') AND deleted_at IS NULL")
                        ->orderBy('name')
                        ->get();
        $titlePage = $title;
        $type = 'VIDEO';

        return view('wiki.view',compact('result','title','titlePage','type'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($user,Request $request)
    {
        // Altera configurações php para upload
        ini_set('max_execution_time',60);
        ini_set('post_max_size',"100M");
        ini_set('upload_max_filesize',"100M");

        $rules = [
            'name' => 'required',
            'ilha_id' => 'required',
            'cargo_id' => 'required',
            'video' => 'required'
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

        // salva arquivo
        $path = 'storage/' . $request->file('video')->store('materials/videos','public');

        $videos = new Video();
        $videos->name = $request->input('name');
        $videos->file_path = $path;
        $videos->ilha_id = $ilha;
        $videos->sector = $setor;
        $videos->cargo_id = $cargo;
        $videos->user_id = $user;
        $videos->save();

        return response()->json(['successAlert' => 'Video inserido com sucesso!'], 201);
    }

    public function edit($id, $user, Request $request)
    {

    }

    public function editGet($id) {
        $video = Video::find($id);
        $nome = $video['name'];
        $title = "Editar Video - $nome";

        return view('gerenciamento.materials.edit.editVideo',compact('title','video'));
    }


    public function show()
    {
        $videos = Video::all();
        return $videos->toJSON();
    }

    public function allVideos()
    {
        $videos = Video::all();//paginate(10);
        return $videos;
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

        // Pega ilhas
        $ilhas = Ilha::select('id','name','setor_id')->get();

        // Cargos
        $cargos = Cargo::select('id','description')->get();

        // Pega quizzes não vistos
        $q = new Quizzes();
        $quiz = $q->getQuizFromUser(Auth::user()->ilha_id, Auth::id());

        $title = 'Incluir video';
        return view('gerenciamento.materials.insert.video',compact('title','setores','ilhas','cargos', 'quiz'));

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
        $path = 'storage/' . $request->file('file')->store('materials/videos','public');

        $file = Video::find($id);
        $file->user_id = $user;
        $file->file_path = $path;
        if($file->save()) {
            $log = new Logs();
            $log->material($id,$ilha,$user,'EDIT_SCRIPVIDEO');

            return redirect()->route('GetMaterialsManage')->with(['successAlert' => 'Upload feito com sucesso']);
        }

    }

    public function destroy($id,$user)
    {
        $video = Video::find($id);
        if($video->delete()) {
            $ilha = $video['ilha_id'];
            $log = new Logs();
            $log->material($id,$ilha,$user,"DELETE_VIDEO");
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }

    }

    //baixa video
    public function download($id, $user) {
        $video = Video::find($id);
        $path = asset($video->file_path);

        $log = new Logs();
        $log->material($video->id,$video->ilha_id,$user,'DOWNLOAD_VIDEO');

        return redirect($path);
    }

}
