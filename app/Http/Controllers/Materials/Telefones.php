<?php

namespace App\Http\Controllers\Materials;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
USE Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Users\Ilhas;
use App\Http\Controllers\Users\Setores;
use App\Materials\Telefone;
use App\Http\Controllers\Quizzes\Quizzes;

class Telefones extends Controller
{
    public function index($setor)
    {
        $phones = Telefone::where('setor_id',$setor)->get();

        return $phones;
    }

    public function indexJson($ilha)
    {

        $search = new Ilhas();
        $setor = $search->sectorByIlha($ilha)['setor_id'];

        $phones = Telefone::where('setor_id',$setor)->get();

        return $phones->toJSON();
    }

    public function store(Request $request)
    {

        $phone = new Telefone();
        $phone->name = $request->input('name');
        $phone->description = $request->input('description');
        $phone->tel1 = $request->input('tel1');
        $phone->desc1 = $request->input('desc1');
        $phone->tel2 = $request->input('tel2');
        $phone->desc2 = $request->input('desc2');
        $phone->email = $request->input('email');
        $phone->days = $request->input('days');
        $phone->obs = $request->input('obs');
        $phone->setor_id = $request->input('setor_id');
        if($phone->save()) {
            //registra Log
            $log = new Logs();
            $log->telephone(Auth::user()->id,$phone->id,Auth::user()->ilha_id);

            return response()->json(["success" => TRUE], 200);
        }

        return response()->json(["success" => FALSE]);
    }

    public function create(Request $request)
    {
        //log
        $log = new Logs();
        $log->page($request->fullUrl(),Auth::user()->id,Auth::user()->ilha_id,$request->ip());

        //setores
        $setor = new Setores();
        $setores = $setor->index();

        //titulo da página
        $title = "Inserir Telefones";

        // Pega quizzes não vistos
        $q = new Quizzes();
        $quiz = $q->getQuizFromUser(Auth::user()->ilha_id, Auth::id());

        return view('gerenciamento.materials.insert.telephones',compact('title','setores', 'quiz'));
    }

    public function delete($user,$ilha,$id)
    {
        $delete = Telefone::find($id);
        if($delete->delete()) {
            //registra Log
            $log = new Logs();
            $log->telephone($user,$id,$ilha,'DELETE_TELEPHONE');

            return response()->json(['success' => TRUE], 200);
        }

        return response()->json(['success' => FALSE],500);
    }
}

