<?php

namespace App\Http\Controllers\Relatorios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Users\Carteiras;
use App\Tools\FromQueryExport;
use App\Monitoria\Monitoria;
use App\Users\User;
use App\Users\Ilha;
use App\Monitoria\Item;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Auth;
use DB;
use Session;

class Monitorias extends Controller
{
    // Start by Supervisor
    public function findmonitoring()
    {
        if(in_array(Auth::user()->cargo_id,[1,15])) {
            $supers = User::select('id','name')
                            ->whereIn('cargo_id',[4])
                            ->get();
            $mode = 'mon';
        } else {
            $supers = [];
            $mode = 'sup';
        }

        $title = 'Relatório';
        $forData = [];
        $maiorNNotas = 1;
        return view('reports.monitoring.findMonitoring',compact('title','forData','maiorNNotas','mode','supers'));
    }

    // Start by Operator
    public function findoperator()
    {
        if(in_array(Auth::user()->cargo_id,[1,15])) {
            $supers = User::select('id','name')
                            ->whereIn('cargo_id',[5])
                            ->get();
            $mode = 'mon';
        } else {
            $supers = [];
            $mode = 'sup';
        }

        $title = 'Relatório Operador';
        $forData = [];
        $maiorNNotas = 1;
        return view('reports.monitoring.findOperator',compact('title','forData','maiorNNotas','mode','supers'));
    }

    // Start by Monitor
    public function findmonitoringAgent($id = NULL, Request $request)
    {

        $title = 'Relatório de Agentes';

        $supers = User::select('id','name')
                        ->whereIn('cargo_id',[15])
                        ->get();

        if($id > 0 && !is_null($id)) {
            $request->validate(['icheck' => 'required']);
            $icheck = $request->input('icheck');
            $results = Monitoria::select('id', 'monitor_id', 'media', 'created_at as date')
                                ->where('monitor_id',$id)
                                ->get();

            $media = Monitoria::selectraw('AVG(media) as media')
                                ->where('monitor_id',$id)
                                ->get()[0]['media'];

            return view('reports.monitoring.findMonitoringAgent',compact('title','supers','results','media'));
        }

        return view('reports.monitoring.findMonitoringAgent',compact('title','supers'));
    }

    public function findmonitoringByDateOperator($id, Request $request)
    {
        $title = 'Relatório de Equipe';
        $start = date('Y-m-d',strtotime($request->input('de')));
        $end = date('Y-m-d',strtotime($request->input('ate')));
        $supers = $request->input('supers');
        $icheck = $request->input('icheck'); //aceite
        if(!empty($icheck)) {
            //grava aceite
            $log = new Logs();
            $log->log('VIEW_REPORT_MONITORING',$icheck,$request->fullUrl(),Auth::id(),Auth::user()->ilha_id);
        }

        $result = DB::select('SELECT m.id, m.operador_id as operador, o.name as `nameOp`, m.id, m.supervisor_id as supervisor, a.name as `nameSup`,
        m.media, m.created_at as `date`, m.conf, m.nConf, m.nAv
        FROM book_monitoria.monitorias as m
        LEFT JOIN book_usuarios.users as o
        ON o.id = m.operador_id
        left JOIN book_usuarios.users as a
        ON a.id = m.supervisor_id
         WHERE m.operador_id = ?
         AND m.supervisor_id
        AND m.hash_operator IS NULL
        AND m.deleted_at IS NULL
        AND m.created_at BETWEEN ? AND ?
        ORDER BY m.id ASC;',[$id,$start,$end]);

        // variáveis de controle e concatenação
        $maiorNNotas = 0;
        $data = [];

        if(count($result) > 0) {
            $idLast = 0;
            $count = 0;
            $media = 0;
            $mes = 0;
            $nome = '';
            $data = [];
            $nConf = 0;
            $nAv = 0;
            $conf = 0;
            $notas = '';
            $media = 0;

            // laço que monta linhas da tabela
            foreach($result as $item) {
                if($idLast === $item->operador || $idLast === 0) {
                    // Concatena variáveis
                    $nome = $item->nameOp;
                    $nameSup = $item->nameSup;
                    $nConf += $item->nConf;
                    $nAv += $item->nAv;
                    $conf += $item->conf;
                    $media += $item->media;
                    $notas .= $item->media.'|';
                    $idLast -= $idLast;
                    $idLast += $item->operador;

                } else {
                    $nota = substr($notas,0,-1);
                    $nNotasAtual = count(explode('|',$nota));
                    if($maiorNNotas < $nNotasAtual) {
                        $maiorNNotas += $nNotasAtual - $maiorNNotas;
                    }

                    $data[] = [
                        'nome' => $nome,
                        'notas' => $nota,
                        'conf' => $conf,
                        'nConf' => $nConf,
                        'nAv' => $nAv,
                        'media' => round(($media/$nNotasAtual),2),
                    ];

                    // zera variáveis
                    $idLast -= $idLast;
                    unset($nome);
                    $nConf -= $nConf;
                    $nAv -= $nAv;
                    $conf -= $conf;
                    $notas = substr($notas,0,0);
                    $media -= $media;

                    // Concatena variáveis
                    $nome = $item->name;
                    $nameSup = $item->nameSup;
                    $nConf += $item->nConf;
                    $nAv += $item->nAv;
                    $conf += $item->conf;
                    $media += $item->media;
                    $notas .= $item->media.'|';
                    $idLast -= $idLast;
                    $idLast += $item->operador;
                }
            }

            //Concatena ultimo dado
            $nota = substr($notas,0,-1);
            $nNotasAtual = count(explode('|',$nota));
            if($maiorNNotas < $nNotasAtual) {
                $maiorNNotas += $nNotasAtual - $maiorNNotas;
            }

            $data[] = [
                'nome' => $nome,
                'nameSup' => $nameSup,
                'notas' => $nota,
                'conf' => $conf,
                'nConf' => $nConf,
                'nAv' => $nAv,
                'media' => round(($media/$nNotasAtual),2),
            ];
        }

        if(in_array(Auth::user()->cargo_id,[1,15])) {
            $mode = 'mon';
            $supers = User::select('id','name')
                        ->whereIn('cargo_id',[5])
                        ->get();
        } else {
            $mode = 'sup';
            $supers = [];
        }

        $forData = $data;

        return view('reports.monitoring.findOperator',compact('title','forData','maiorNNotas','mode','supers','result'));
    }

    // Pega monitoria por supevisor e por data
    public function findmonitoringByDate($id, $type = 'Supervisor', Request $request)
    {
        $title = 'Relatório de '.$type;
        $start = date('Y-m-d',strtotime($request->input('de')));
        $end = date('Y-m-d',strtotime($request->input('ate')));
        $supers = $request->input('supers');
        $icheck = $request->input('icheck'); //aceite
        if(!empty($icheck)) {
            //grava aceite
            $log = new Logs();
            $log->log('VIEW_REPORT_MONITORING',$icheck,$request->fullUrl(),Auth::id(),Auth::user()->ilha_id);
        }

        $result = DB::select('SELECT m.id, m.operador_id as operador, o.name as `name`, m.media, m.created_at as `date`, m.conf, m.nConf, m.nAv
                              FROM book_monitoria.monitorias as m
                              LEFT JOIN book_usuarios.users as o
                              ON o.id = m.operador_id
                              WHERE m.supervisor_id = ?
                              AND m.hash_operator IS NULL
                              AND m.deleted_at IS NULL
                              AND m.created_at
                              BETWEEN ? AND ?
                              ORDER BY m.id ASC;',[$id,$start,$end]);

        if(in_array(Auth::user()->cargo_id,[1,15])) {
            $mode = 'mon';
            $supers = User::select('id','name')
                        ->whereIn('cargo_id',[5])
                        ->get();
        } else {
            $mode = 'sup';
            $supers = [];
        }

        return view('reports.monitoring.findMonitoringEvolution',compact('title','mode','supers','result','type'));
    }
    // End By Supervisor

    // Start Analitico
    public function reportIndexAll()
    {
        $title = 'Relatório Analítico de Monitoria';
        $search = [];
        $de = date('Y-m-d 00:00:00');
        $ate = date('Y-m-d 23:59:59');

        return view('reports.monitoring.search',compact('title','search','de','ate'));
    }

    public function analyticsSearch(Request $request)
    {
        ini_set('max_execution_time', '300');

        // filtros de data tipo_monitoria
        $de = date('d/m/Y', strtotime($request->input('periodo')));

        if($request->input('duasDatas') == 0) {
            $ate = date('d/m/Y');
        } else {
            $ate =  date('d/m/Y', strtotime($request->input('ate')));
        }

        // pega dados
	    // $search = DB::table("book_monitoria.relatorio_analitico_trimestral")
     //                ->whereBetween('data_monitoria',[$de, $ate])
     //                // ->limit(5)
     //                ->get();

     //    // Verifica dados
     //    if($search->count() === 0) {
     //        return back()->with('successAlert','Nenhum resultado para essa pesquisa.');
     //    }

     //    // Transforma dados de Object para array
     //    $data = collect($search)->map(function($x){ return (array) $x; })->toArray(); 
        
     //    $columns = array_keys($data[0]);

        $where = "data_monitoria BETWEEN $de AND $ate";
        $filename = 'liderbook_monitoria'.date('YmdHis').'.xlsx';
        //Exporta
        return  (new FromQueryExport('data_monitoria',[$de,$ate]))->download($filename);
    }

    // End Analítico

    // Start Signs
    public function tirarAcentos($string){
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
    }

    public function searchSign(Request $request)
    {
        $de = $request->input('de');
        $ate = $request->input('ate');
        if($this->dateDifference($ate,$de,"%m") > 3) {
            return back()->with(['errorAlert' => 'Diferença entre datas não pode ser superior a 3 meses']);
        }

        $search = Monitoria::selectRaw('u.name as operador, sup.name as supervisor, monitorias.feedback_monitor, monitorias.usuario_cliente, monitorias.resp_operador as aceite,
                                        DATE_FORMAT(monitorias.created_at,"%Y-%m-%d") as date_monitoring, cargos.description as perfil_avaliador,
                                        monitor.name as avaliador_monitor, monitorias.media as nota, monitorias.id as numero_laudo, super.name as aplicador_feedback')
                            ->leftJoin('book_usuarios.users AS super','super.id','monitorias.supervisor_id')
                            ->leftJoin('book_usuarios.users AS monitor','monitor.id','monitorias.monitor_id')
                            ->leftJoin('book_usuarios.users AS u','monitorias.operador_id','u.id')
                            ->leftJoin('book_usuarios.users AS sup','sup.id','u.supervisor_id')
                            ->leftJoin('book_usuarios.cargos','cargos.id','super.cargo_id')
                            ->get();

        $title = 'Relatório de Assinaturas';
        return view ('reports.monitoring.signs',compact('title','search'));
    }
    // End Signs

    public function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);

    }
     // INICIO RELATÓRIO POR CATEGORIAS
     public function ilhafind()
     {
        if(in_array(Auth::user()->cargo_id,[1,15])) {
            $supers = User::select('id','name')
                            ->whereIn('cargo_id',[5])
                            ->get();
            $mode = 'mon';
        } else {
            $supers = [];
            $mode = 'sup';
        }

        $forData = [];
        $maiorNNotas = 1;

         $ilhas = Ilha::select('id','name','setor_id')->get();

         $title = 'Media Ilha';

         return view('reports.monitoring.categoryIlha',compact('title','setores','cargos','forData','maiorNNotas','mode','supers','ilhas'));
     }

    // Analise por categoria
    public function ilhafindPost($id, Request $request){

        $title = 'Analise Por Categoria';
        $start = date('Y-m-d',strtotime($request->input('de')));
        $end = date('Y-m-d',strtotime($request->input('ate')));
        $supers = $request->input('supers');
        $icheck = $request->input('icheck'); //aceite
        if(!empty($icheck)) {
            //grava aceite
            $log = new Logs();
            $log->log('VIEW_REPORT_MONITORING',$icheck,$request->fullUrl(),Auth::id(),Auth::user()->ilha_id);
        }

        $result = Item::selectRaw('laudos_itens.id AS id_laudo, laudos_itens.sinalizacao AS sina, COUNT(mi.id_laudo_item) AS itens, (
                                            SELECT COUNT(id)
                                            FROM  book_monitoria.monitoria_itens
                                            WHERE value LIKE "Conforme%"
                                            AND id_laudo_item = id_laudo
                                        ) AS conf, (
                                            SELECT COUNT(id)
                                            FROM   book_monitoria.monitoria_itens
                                            WHERE value LIKE "%Não Conforme%"
                                            AND id_laudo_item = id_laudo
                                        ) AS nConf, (
                                            SELECT COUNT(id)
                                            FROM  monitoria_itens
                                            WHERE value LIKE "%Não Avaliado%"
                                            AND id_laudo_item = id_laudo
                                        ) AS nAv')

                                ->leftJoin('book_monitoria.monitoria_itens AS mi', 'mi.id_laudo_item',  'laudos_itens.id')
                                ->leftJoin('book_monitoria.monitorias AS moni', 'mi.monitoria_id', 'moni.id')
                                ->leftJoin('book_usuarios.users AS user', 'moni.operador_id', 'user.id')
                                ->whereBetween('mi.created_at',[$start, $end])
                                ->groupBy('id_laudo')
                                ->get();

        if(in_array(Auth::user()->cargo_id,[1,15])) {
            $mode = 'mon';
            $supers = User::select('id','name')
                        ->whereIn('cargo_id',[5])
                        ->get();
        } else {
            $mode = 'sup';
            $supers = [];
        }
        $ilhas = Ilha::select('id','name','setor_id')->get();

        while($rowlist = $result) {

            $q = $q + $rowlist[$result->itens];
            $e = $q - $v;
            $NomeProduto = $rowlist['NomeProduto'];
       }

        return view('reports.monitoring.findCategoryIlha',compact('title','mode','supers','result','ilhas','$q'));

    }


    // INICIO RELATÓRIO DE EVOLUÇÃO OPERADOR
    public function evolutionOperator()
    {
        //
    }

    public function findEvolutionOperator($id = 0, Request $request)
    {
        $title = 'Relatório de Equipe';
        $start = date('Y-m-d',strtotime($request->input('de')));
        $end = date('Y-m-d',strtotime($request->input('ate')));
        $supers = $request->input('supers');
        $icheck = $request->input('icheck'); //aceite

        // filtro de novos operadores
        $dateNovosOp = date('Y-m-d 00:00:00', strtotime("-90 Days",strtotime(date('Y-m-d'))));

        if($id > 0) {

            if(!empty($icheck)) {
                //grava aceite
                $log = new Logs();
                $log->log('VIEW_REPORT_MONITORING',$icheck,$request->fullUrl(),Auth::id(),Auth::user()->ilha_id);
            }

            $result = DB::select('SELECT m.id, m.operador_id as operador, o.name as `nameOp`, m.id, m.supervisor_id as supervisor, a.name as `nameSup`,
            m.media, DATE_FORMAT(m.created_at,"%d/%m/%Y") as `date`, m.conf, m.nConf, m.nAv, m.quartil,
            IF(o.data_admissao IS NULL,"Informação Não Disponível",IF(o.data_admissao >= "'.$dateNovosOp.'","Novo","Maturado")) AS operador_novo
            FROM book_monitoria.monitorias as m
            LEFT JOIN book_usuarios.users as o
            ON o.id = m.operador_id
            left JOIN book_usuarios.users as a
            ON a.id = m.supervisor_id
            WHERE m.operador_id = ?
            AND m.hash_operator IS NULL
            AND m.deleted_at IS NULL
            AND m.created_at BETWEEN ? AND ?
            ORDER BY m.id ASC;',[$id,$start,$end]);

            Session::put('excelExportsData',(array) $result);

        } else {
            $result = [];
        }
        if(in_array(Auth::user()->cargo_id,[1,15])) {
            $mode = 'mon';
            $supers = User::selectRaw('id, name,
            IF(data_admissao IS NULL,IF(created_at >= "'.$dateNovosOp.'","Novo","Maturado"),IF(data_admissao >= "'.$dateNovosOp.'","Novo","Maturado")) AS operador_novo')
                        ->whereIn('cargo_id',[5])
                        ->get();
        } else {
            $mode = 'sup';
            $supers = [];
        }

        return view('reports.monitoring.evolutionOperator',compact('title','mode','supers','result'));
    }

    public function ByCpfCli(Request $request) {
        $request->validate(['cpf' => 'required|int'],['required' => 'CPF inválido!']);

        $monitorias = Monitoria::select('monitorias.id','u.name','monitorias.cliente','monitorias.media','monitorias.created_at as date')
                                ->leftJoin('book_usuarios.users as u','u.id','monitorias.operador_id')
                                ->where('monitorias.cpf_cliente',$request->input('cpf'))
                                ->orderBy('monitorias.id','DESC')
                                ->get();

        if($monitorias->count() === 0) {
            return 0;
        }

        return $monitorias;
    }

    // INICIO BUSCAR MEDIA POR ILHA
    public function mediaSegments()
    {
        $title = 'Relatório por Carteira';
        $carteira = new Carteiras();
        $carteiras = json_decode($carteira->index());

        $carteiras = Monitoria::selectRaw('AVG(monitorias.media) AS media, c.name, c.id')
                                ->leftJoin('book_usuarios.users AS u','u.id','monitorias.operador_id')
                                ->leftJoin('book_usuarios.carteiras AS c','c.id','u.carteira_id')
                                ->groupBy('c.id','c.name')
                                ->get();

        $setores = Monitoria::selectRaw('AVG(monitorias.media) AS media, s.name, s.id')
                            ->leftJoin('book_usuarios.users AS u','u.id','monitorias.operador_id')
                            ->leftJoin('book_usuarios.setores AS s','s.id','u.setor_id')
                            ->groupBy('s.id','s.name')
                            ->get();

        $ilhas = Monitoria::selectRaw('AVG(monitorias.media) AS media, i.name, i.id')
                            ->leftJoin('book_usuarios.users AS u','u.id','monitorias.operador_id')
                            ->leftJoin('book_usuarios.ilhas AS i','i.id','u.ilha_id')
                            ->groupBy('i.id','i.name')
                            ->get();

        return view('reports.monitoring.mediabySegment',compact('title', 'carteiras', 'setores', 'ilhas'));
    }

    public function searchDetailSegment($id,$type) {
        $result = 0;
        if(in_array($type,['carteira','setor','ilha'])) {
            $search = Monitoria::selectRaw("monitorias.id AS monitoria, c.id carteiraId, c.name carteiraName, s.id as setorId, s.name as setorName, ilhas.id as ilhaId,
                                            ilhas.name as ilhaName, u.name as operador, monitorias.media, monitorias.tipo_ligacao, monitorias.conf, monitorias.nConf, monitorias.nAv,
                                            IF(monitorias.supervisor_at IS NULL,'NÃO APLICADO','APLICADO') as feedbackSupervisor, DATE_FORMAT(monitorias.created_at,'%Y-%m-%d') as dataMonitoria,
                                            IF(monitorias.supervisor_at IS NULL,'-',DATE_FORMAT(monitorias.supervisor_at,'%Y-%m-%d')) AS dataFeedback, monitorias.quartil")
                                            ->leftJoin('book_usuarios.users AS u','u.id','monitorias.operador_id')
                                            ->leftJoin('book_usuarios.ilhas','u.ilha_id','ilhas.id')
                                            ->leftJoin('book_usuarios.setores AS s','s.id','ilhas.setor_id')
                                            ->leftJoin('book_usuarios.carteiras AS c','c.id','s.carteira_id')
                                            ->when($type === 'carteira', function($q) use ($id) {
                                                return $q->where('c.id',$id);
                                            })
                                            ->when($type === 'setor', function($q) use ($id) {
                                                return $q->where('s.id',$id);
                                            })
                                            ->when($type === 'ilha', function($q) use ($id) {
                                                return $q->where('ilhas.id',$id);
                                            })
                                            ->get();

            if($search->count() > 0) {
                $result = $search;
                Session::put('excelExportsData',(array) $result);
            }
        }
        return $result;
    }

    private function export(array $data)
    {

        $export = new MonitoriaExports($data);
        $date = date('YmdHis');

        return Excel::download($export, "monitoria_$date.xlsx");
    }

 }


