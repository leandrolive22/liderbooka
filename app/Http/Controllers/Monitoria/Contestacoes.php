<?php

namespace App\Http\Controllers\Monitoria;

use App\Http\Controllers\Controller;
use App\Monitoria\Contestacao;
use App\Monitoria\Monitoria;
use App\Monitoria\MotivoContestar;
use App\Users\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Contestacoes extends Controller
{
    /**
     * Checa se existe contestação para o usuário visualizar
     *
     * @return int Quantidade de contestações
     */
    public function check()
    {
        return DB::table('book_monitoria.listar_contestacoes')
            ->when(Auth::user()->cargo_id == 15 && !in_array(66, Session::get('permissionsIds')) || in_array(1, Session::get('permissionsIds')), function($q) {
                return $q->where('monitor_id',Auth::id())
                        ->where('status',3);
            })
            ->when(in_array(66, Session::get('permissionsIds')), function($q) {
                return $q->where('status',3);
            })
            ->when(Auth::user()->cargo_id == 4 && !in_array(66, Session::get('permissionsIds')), function($q) {
                return $q->where('supervisor_id',Auth::id())
                    ->whereBetween('status', [1,2])
                    ->where('data_contestacao','>=',date('Y-m-d H:i:s',strtotime('-45 Days')));
            })
            ->count();
    }

    /**
     * Abre view com as contestações
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        // Checa permissões de status
        if (in_array(66, Session::get('permissionsIds'))) {
            $id = 0;
        } else {
            $id = Auth::id();
        }

        $title = 'Contestações';
        $contestacoes = $this->getContestacoes($id);
        $monitores = $this->getSupOrMoni(15);
        $supervisores = $this->getSupOrMoni(4);
        $motivos = $this->getMotivos();

        $compact = compact('contestacoes', 'title', 'monitores', 'supervisores', 'motivos');

        return view('monitoring.contestacoes.index', $compact);
    }

    /**
     * Filtra as contestações
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function filterContest(Request $request)
    {
        // regras de validação
        $rules = [
            'minhas_contestacoes' => 'required',
            'tableContestStatus1' => 'required',
            'tableContestStatus2' => 'required',
            'tableContestMonitorFilter' => 'required',
            'tableContestSupervisorFilter' => 'required',
            'tableContestStatus3' => 'required',
            'monitor' => 'required',
            'supervisor' => 'required',
        ];

        // Mensagens de validação
        $msgs = [
            'required' => 'Selecione os filtros corretamente!',
        ];

        // Valida requisição
        $request->validate($rules, $msgs);

        // intancia variáveis da requisição (todas são pois a requisição é JSON tipo string)
        $minhas_contestacoes = $request->minhas_contestacoes;
        $tableContestStatus1 = $request->tableContestStatus1;
        $tableContestStatus2 = $request->tableContestStatus2;
        $tableContestStatus3 = $request->tableContestStatus3;
        $tableContestMonitorFilter = $request->tableContestMonitorFilter;
        $tableContestSupervisorFilter = $request->tableContestSupervisorFilter;
        $monitor = $request->monitor;
        $supervisor = $request->supervisor;
        if($minhas_contestacoes == 'false') {
            // Checa se monitor é válido
            if($tableContestMonitorFilter ==  'true' && in_array($monitor,[null,0,' ',''])) {
                return response()->json(['errorAlert' => 'Selecione um Monitor válido!'], 422);
            }

            // Checa se supervisor é válido
            if($tableContestSupervisorFilter ==  'true' && in_array($supervisor,[null,0,' ',''])) {
                return response()->json(['errorAlert' => 'Selecione um Supervisor válido!'], 422);
            }

            // Verifica se a busca é por monitor
            if($tableContestMonitorFilter == 'false') {
                unset($monitor);
                $monitor = 0;
            }

            // Verifica se a busca é por supervisor
            if($tableContestSupervisorFilter == 'false') {
                unset($supervisor);
                $supervisor = 0;
            }
        } else {
            $supervisor = 0;
            $monitor = Auth::id();
        }

        // categoriza status
        if($tableContestStatus1 == 'true') {
            $status = 1;
        } else if($tableContestStatus2 == 'true') {
            $status = 2;
        } else if($tableContestStatus3 == 'true') {
            $status = 3;
        } else {
            $status = 0;
        }

        return $this->getContestacoes($monitor, $status, 0, $supervisor);
    }

    public function getMotivos()
    {
        return MotivoContestar::all();
    }

    /**
     * Pega supervisor ou monitor por cargo
     *
     * @param int $cargo id do cargo buscado
     * @return App\Users\User
     */
    public function getSupOrMoni(int $cargo)
    {
        return User::select('id', 'name')
            ->where('cargo_id', $cargo)
            ->when(in_array(64, Session::get('permissionsIds')), function ($q) {
                return $q->whereRaw('NOT carteira_id = 1');
            })
            ->when(!in_array(64, Session::get('permissionsIds')), function ($q) {
                return $q->where('carteira_id', 1);
            })
            ->orderBy('name')
            ->get();
    }

    /**
     * Busca contestações de acordo com parâmetros
     *
     * @param int $id id do monitor, 0 para todos
     * @param int $status status da contestação
     * @param int $skip se o resultado virá paginado ou não
     * @param int $supervisor id do supervisor, 0 para todos
     * @return App\Monitoria\Contestacao
     */
    public function getContestacoes(int $monitor = 0, int $status = 0, int $skip = 0, int $supervisor = 0)
    {
        return DB::table('book_monitoria.listar_contestacoes')
            ->when($monitor > 0, function ($q) use ($monitor) {
                return $q->where('monitor_id', $monitor);
            })
            ->when($supervisor > 0, function ($q) use ($supervisor) {
                return $q->where('supervisor_id', $supervisor);
            })
            ->when($status > 0, function ($q) use($status) {
                return $q->where('status', $status);
            })
            ->orderBy(DB::raw('DATE_FORMAT(data_contestacao,"%Y%m")'),'DESC')
            ->orderBy('status','DESC')
            ->limit(15)
            /** ->toSql(); /*/
            ->get();/**/
    }

    /**
     * Mostra contestação ao clicar em "ver"
     *
     * @param int $id
     * @return string|App\Monitoria\Contestacao
     */
    public function showBy(int $id)
    {
        try {
            return Contestacao::select('contestacoes.*','u.name')
                                ->where('monitoria_id', $id)
                                ->leftJoin('book_usuarios.users AS u','u.id','contestacoes.creator_id')
                                ->orderBy('passo')
                                ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Grava contestação
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'motivo_id' => 'required|int',
            'monitoria_id' => 'required|int',
        ];

        $messages = [
            'motivo_id.required' => 'Preencha todos os campos corretamente! (motivo_id)',
            'monitoria_id.required' => 'Preencha todos os campos corretamente! (monitoria_id)',
        ];

        $request->validate($rules, $messages);

        // Se é edição altera, se não, insere
        if ($request->update) {
            $const = Contestacao::find($request->contestacao_id);
            $const->passo++;
            $const->status = $request->status; // 3 = Contestado; 2 = Improcedente; 1 = Procedente;
        } else {
            $const = new Contestacao();
            $const->passo = 1;
            $const->status = 3; // 3 = Contestado; 2 = Improcedente; 1 = Procedente;
        }
        $const->motivo_id = $request->motivo_id;
        $const->obs = $request->obs;
        $const->monitoria_id = $request->monitoria_id;
        $const->creator_id = Auth::id();
        if ($const->save()) {
            return response()->json(['successAlert' => 'Contestação salva com sucesso'], 201);
        }

        return response()->json(['errorAlert' => 'Falha ao salvar Contestação'], 422);
    }
}
