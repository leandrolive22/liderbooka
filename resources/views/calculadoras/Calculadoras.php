<?php

namespace App\Http\Controllers\Materials;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
USE Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Users\Ilhas;
use App\Http\Controllers\Users\Setores;
use App\Materials\Calculadora;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class Calculadoras extends Controller
{
    //retorna Calculadoras na navbar
    public function index($ilha_id)
    {
        $Calculadoras = Calculadora::whereRaw("ilha_id LIKE '%,$ilha_id,%' AND deleted_at IS NULL")->get();
        return ($Calculadoras)->toJSON();
    }

    //pega numero das Calculadoras
        public function getCount($ilha) {
        $count = Calculadora::where('ilha_id',$ilha)->count();
        return $count;
    }
   
    //pega Cpf do Formulario e consulta base de dados painel
        public function CpfPending(Request $cpf) {
        $cpf = $cpf->cpfajax;
        $base = DB::select('SELECT desconto_avista FROM book_materiais.base_dados WHERE cpf = ?', [$cpf]);
        return ($base);

        }


    public function store(Request $request, $user)
    {

        $rules = [
            'name' => 'required',
            'ilha_id' => 'required',
            'setor_id' => 'required',
            'file' => 'required'
        ];
        $msgs = [
            'name.required' => 'O campo Nome não pode ser vazio',
            'ilha_id.required' => 'Selecione uma Ilha',
            'setor_id.required' => 'Selecione um setor',
            'file.required' => 'Selecione um arquivo',
        ];

        $request->validate($rules, $msgs);

        $ilha = $request->input('ilha_id');

        $path = 'storage/' . $request->file('file')->store('materials/calculators','public');

        $Calculadora = new Calculadora();
        $Calculadora->name = $request->input('name');
        $Calculadora->file_path = $path;
        $Calculadora->sub_local_id = NULL;
        $Calculadora->ilha_id = $ilha;
        $Calculadora->setor_id = $request->input('setor_id');
        $Calculadora->user_id = $user;
        $Calculadora->save();

        $log = new Logs();
        $log->calculator($Calculadora->id,$ilha,$user);

        return back()->with(['successAlert' => 'Calculadora inserida com sucesso!']);

    }

    public function show() {
        $Calculadoras = Calculadora::all();
        return $Calculadoras->toJSON();
    }

    public function allCalc() {
        $Calculadoras = Calculadora::all();//paginate(10);
        return $Calculadoras;
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

        $roteiro = Calculadora::find($id);
        $roteiro->name = $request->input('name');
        $roteiro->sub_local_id = $request->input('sub_local_id');
        $roteiro->ilha_id = $ilha;
        $roteiro->setor_id = $request->input('setor_id');
        $roteiro->user_id = $user;

        if($roteiro->save()) {
            $log = new Logs();
            $log->calculator($id,$ilha,$user,'EDIT_CALCULATOR_DATA');

            if($request->input('change') === 1) {
                return redirect()->route('GetCalculadorasEdit',['id' => $id]);
            } else {
                return response()->json(['success' => false, 'errorAlert' => 'Alterações Salvas, não foi possível redirecionar'], 204);
            }
        }
        else {
            return response()->json(['success' => false, 'errorAlert' => 'Não foi possível editar roteiro'], 204);
        }

    }

    public function create()
    {
        //pega setores
        $setor = new Setores();
        $setores = $setor->index();

        //pega ilhas
        $ilha = new Ilhas();
        $ilhas = json_decode($ilha->indexPost());

        $title = 'Incluir Calculadora';
        return view('gerenciamento.materials.insert.calculadora',compact('title','setores','ilhas'));
    }

    public function editGet($id, Request $request) {
        //deine variáveis à serem utilizadas na função (user data)
        $ilha = Auth::user()->ilha_id;
        $user = Auth::user()->id;

        $Calculadora = Calculadora::find($id);
        $nome = $Calculadora['name'];
        $title = "Editar Calculadora - $nome";

        $log = new Logs();
        $log->page($request->fullUrl(), $user, $ilha, $request->ip());

        return view('gerenciamento.materials.edit.editCalc',compact('title','Calculadora'));
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
        $path = 'storage/' . $request->file('file')->store('materials/calculators','public');

        $file = Calculadora::find($id);
        $file->user_id = $user;
        $file->file_path = $path;
        if($file->save()) {
            $ilha = $request->input('ilha');
            $log = new Logs();
            $log->calculator($id,$ilha,$user,'EDIT_CALCULATOR_FILE');

            return redirect()->route('GetMaterialsManage')->with(['successAlert' => 'Upload feito com sucesso']);
        } else {
            return back()->with(['errorAlert' => 'Erro']);
        }

    }

    public function destroy($id,$user)
    {
        $Calculadora = Calculadora::find($id);
        if($Calculadora->delete()) {
            $ilha = $Calculadora['ilha_id'];
            $log = new Logs();
            $log->calculator($id,$ilha,$user,"DELETE_CALCULATOR");
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }

    }

    public function download($id, $user) {
        $Calculadora = Calculadora::find($id);
        $path = asset($Calculadora->file_path);

        $log = new Logs();
        $log->calculator($Calculadora->id,$Calculadora->ilha_id,$user,'DOWNLOAD_CALCULATOR');

        return redirect($path);
    }

    public function Adicional() {
        $title = 'Calculadora Adicional';
        return view('calculadoras.Adicional', compact('title'));
    }
    public function Simulador() {
        $title = 'Calculadora Limites';
        return view('calculadoras.SimuladorConsignadoLimites', compact('title'));
    }
    public function Imobiliario() {
        $title = 'Calculadora Imobiliario';
        return view('calculadoras.Simuladorimobiliario', compact('title'));
    }
	 public function Painel() {
        $title = 'Painel De Consulta';
        return view('calculadoras.Painel', compact('title'));
    }
    public function Painelteste() {
        $title = 'Painel De Consulta';
        return view('calculadoras.Paineldeconsulta', compact('title'));
    }
	 public function Siape() {
        $title = 'Calculadora Siape';
        return view('calculadoras.calculadora_siape', compact('title'));
    }
	 public function Dilatacao() {
        $title = 'Calculadora Siape';
        return view('calculadoras.Dilatacao', compact('title'));
    }
}
