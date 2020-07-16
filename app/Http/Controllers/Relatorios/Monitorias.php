<?php

namespace App\Http\Controllers\Relatorios;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Users\Carteiras;
use App\Http\Controllers\Tools\ExcelExports;
use App\Monitoria\Monitoria;
use App\Users\User;
use App\Users\Ilha;
use App\Monitoria\Item;
use Illuminate\Http\Request;
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
        // campos do select
        // $registroMonitoria = $request->input("registroMonitoria");
        // $SEGMENTOMonitoria = $request->input("SEGMENTOMonitoria");
        // $GrupoMonitoria = $request->input("GrupoMonitoria");
        // $OperadorMonitoria = $request->input("OperadorMonitoria");
        // $MonitorMonitoria = $request->input("MonitorMonitoria");
        // $ClienteMonitoria = $request->input("ClienteMonitoria");
        // $DataMonitoria = $request->input("DataMonitoria");
        // $TpLigacaoMonitoria = $request->input("TpLigacaoMonitoria");
        // $cpfclienteMonitoria = $request->input("cpfclienteMonitoria");
        // $DataLigacaoMonitoria = $request->input("DataLigacaoMonitoria");
        // $media = $request->input('media');
        // $SupervisorMonitoria = $request->input("SupervisorMonitoria");
        // $tplaudoMonitoria = $request->input("tplaudoMonitoria");
        // $ILHAMonitoria = $request->input("ILHAMonitoria");
        // $FeedBackMonitoria = $request->input("FeedBackMonitoria");
        // $DataFeedBackMonitoria = $request->input("DataFeedBackMonitoria");
        // $ItemMonitoria = $request->input("ItemMonitoria");
        // $procedimentoMonitoria = $request->input("procedimentoMonitoria");
        // $atendimentoMonitoria = $request->input("atendimentoMonitoria");
        // $quartil = $request->input("quartil");

        // coloca variáveis em select
        // $select = $registroMonitoria.
        // 'laudos.valor as Avaliacoes, '.
        // $SEGMENTOMonitoria.
        // $GrupoMonitoria.
        // $OperadorMonitoria.
        // $MonitorMonitoria.
        // $ClienteMonitoria.
        // $DataMonitoria.
        // $TpLigacaoMonitoria.
        // $cpfclienteMonitoria.
        // $DataLigacaoMonitoria.
        // $media.
        // $SupervisorMonitoria.
        // $tplaudoMonitoria.
        // $ILHAMonitoria.
        // $FeedBackMonitoria.
        // $DataFeedBackMonitoria.
        // $ItemMonitoria.
        // $procedimentoMonitoria.
        // $atendimentoMonitoria.
        // "IF(itens.value = 'Conforme','1','0') AS Conforme, IF(itens.value = 'Não Conforme','1','0') AS Nao_conforme";

        // monta linhas
        // $th = 'Registro|Avaliacoes|Segmento|Grupo|Operador|Monitor|Cliente|data_monitoria|tipo_ligacao|cpf_cliente|data_ligacao|Media|Supervisor|tipo_monitoria|Ilha|FeedBack|data_feedback|Item|Procedimento|grupo_atendimento|Conforme|Nao_conforme|Quartil';

        // // coluna da tabela
        // $coluna = explode('|',$th);

        // trata select para não dar erro
        // str_replace($select,null,'');
        // str_replace($select,'null','');
        // str_replace($select,'none','');

        // filtros de data tipo_monitoria
        $de = date('Y-m-d 00:00:00', strtotime($request->input('periodo')));

        if($request->input('duasDatas') == 0) {
            $ate = date('Y-m-d 23:59:59');
        } else {
            $ate =  date('Y-m-d 23:59:59', strtotime($request->input('ate')));
        }

	    $search = DB::select("select `book_monitoria`.`monitorias`.`quartil` AS `Quartil`,`book_monitoria`.`monitorias`.`id_audio` AS `ID_Audio`,`book_monitoria`.`monitorias`.`usuario_cliente` AS `usuario_cliente`,`book_monitoria`.`monitorias`.`pontos_positivos` AS `pontos_positivos`,`book_monitoria`.`monitorias`.`pontos_desenvolver` AS `pontos_desenvolver`,`book_monitoria`.`monitorias`.`pontos_atencao` AS `pontos_atencao`,`book_monitoria`.`monitorias`.`feedback_monitor` AS `feedback_monitor`,`book_monitoria`.`monitorias`.`feedback_operador` AS `resposta_operador`,`book_monitoria`.`monitorias`.`resp_operador` AS `aceite_operador`,`book_monitoria`.`monitorias`.`hash_operator` AS `hash_operator`,`book_monitoria`.`monitorias`.`hash_monitoria` AS `hash_monitoria`,`book_monitoria`.`monitorias`.`id` AS `Registro`,`laudos`.`valor` AS `Avaliacoes`,`book_usuarios`.`setores`.`name` AS `Segmento`,`carteiras`.`name` AS `Grupo`,`operador`.`name` AS `Operador`,`monitor`.`name` AS `Monitor`,`supervisor`.`name` AS `Supervisor`,`coordenador`.`name` AS `Coordenador`,`gerente`.`name` AS `Gerente`,`superintendente`.`name` AS `Superintendente`,`book_monitoria`.`monitorias`.`media` AS `Media`,`book_monitoria`.`monitorias`.`cliente` AS `Cliente`,date_format(`book_monitoria`.`monitorias`.`created_at`,'%d/%m/%Y') AS `data_monitoria`,`book_monitoria`.`monitorias`.`tipo_ligacao` AS `tipo_ligacao`,`book_monitoria`.`monitorias`.`cpf_cliente` AS `cpf_cliente`,`book_monitoria`.`monitorias`.`data_ligacao` AS `data_ligacao`,`modelos`.`tipo_monitoria` AS `tipo_monitoria`,`book_usuarios`.`ilhas`.`name` AS `Ilha`,if(isnull(`book_monitoria`.`monitorias`.`feedback_supervisor`),'Não Aplicado','Aplicado') AS `feedback_supervisor`,if(isnull(date_format(`book_monitoria`.`monitorias`.`feedback_supervisor`,'%d/%m/%Y')),'N/A',date_format(`book_monitoria`.`monitorias`.`feedback_supervisor`,'%d/%m/%Y')) AS `data_feedback`,`laudos`.`questao` AS `Item`,`itens`.`value` AS `Procedimento`,`laudos`.`sinalizacao` AS `grupo_atendimento`,if((`itens`.`value` = 'Conforme'),1,0) AS `Conforme`,if((`itens`.`value` = 'Não Conforme'),1,0) AS `Nao_conforme`,if(isnull(`operador`.`data_admissao`),'Informação Não Disponível',if((`operador`.`data_admissao` >= (now() - interval 3 month)),'Novo','Maturado')) AS `operador_novo`,`book_monitoria`.`monitorias`.`ncg` AS `ncg`,`book_monitoria`.`monitorias`.`created_at` AS `monitoria_created_at` from ((((((((((((`book_monitoria`.`monitorias` left join `book_usuarios`.`users` `operador` on((`book_monitoria`.`monitorias`.`operador_id` = `operador`.`id`))) left join `book_usuarios`.`ilhas` on((`operador`.`ilha_id` = `book_usuarios`.`ilhas`.`id`))) left join `book_usuarios`.`setores` on((`book_usuarios`.`setores`.`id` = `operador`.`setor_id`))) left join `book_usuarios`.`ilhas` `carteiras` on((`carteiras`.`id` = `operador`.`carteira_id`))) left join `book_usuarios`.`users` `supervisor` on((`supervisor`.`id` = `book_monitoria`.`monitorias`.`supervisor_id`))) left join `book_usuarios`.`users` `coordenador` on((`coordenador`.`id` = `operador`.`coordenador_id`))) left join `book_usuarios`.`users` `gerente` on((`gerente`.`id` = `operador`.`gerente_id`))) left join `book_usuarios`.`users` `superintendente` on((`superintendente`.`id` = `operador`.`superintendente_id`))) left join `book_usuarios`.`users` `monitor` on((`monitor`.`id` = `book_monitoria`.`monitorias`.`monitor_id`))) left join `book_monitoria`.`laudos_itens` `laudos` on((`laudos`.`modelo_id` = `book_monitoria`.`monitorias`.`modelo_id`))) left join `book_monitoria`.`monitoria_itens` `itens` on(((`laudos`.`id` = `itens`.`id_laudo_item`) and (`book_monitoria`.`monitorias`.`id` = `itens`.`monitoria_id`)))) left join `book_monitoria`.`laudos_modelos` `modelos` on((`modelos`.`id` = `laudos`.`modelo_id`))) where ((`book_monitoria`.`monitorias`.`created_at` BETWEEN '$de' AND '$ate') and isnull(`book_monitoria`.`monitorias`.`deleted_at`))");

        // Grava dados na sessão
        //Session::put('excelExportsData', $search);

        //Exporta
        $export = new ExcelExports();
        return $export->basicDatatable(0, 0, $search, $request);
    }
    // End Analítico

    // Start Signs
    public function fetchSign() {

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


