<?php

namespace App\Http\Controllers\Relatorios;

use App\Logs\MaterialLogs;
use App\Users\Cargo;
use App\Users\Ilha;
use App\Users\User;
use App\Materials\Calculadora;
use App\Materials\Circulare;
use App\Materials\Material;
use App\Materials\Roteiro;
use App\Materials\Video;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\Logs;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;

class Materiais extends Controller
{
    public function getReportMaterials($type,$id, Request $request) {
        $title = 'Relatórios Avançados';
        if(Auth::id() > 0) {
            $materials = MaterialLogs::selectRaw('max(material_logs.created_at) created_at, Month(material_logs.created_at) as mes, u.name, i.name as ilha,
                            u.ilha_id ,u.cargo_id, c.description as cargo, super.name as supervisor, g.name as gerente, coord.name as coordenador,
                            sup.name as superintendente, s.name as setor')
                            ->leftJoin('book_usuarios.users as u','u.id','material_logs.user_id')
                            ->leftJoin('book_usuarios.ilhas as i','i.id','u.ilha_id')
                            ->leftJoin('book_usuarios.setores as s','s.id','u.setor_id')
                            ->leftJoin('book_usuarios.cargos as c','c.id','u.cargo_id')
                            ->leftJoin('book_usuarios.users as super','super.id','u.supervisor_id')
                            ->leftJoin('book_usuarios.users as g','g.id','u.gerente_id')
                            ->leftJoin('book_usuarios.users as coord','coord.id','u.coordenador_id')
                            ->leftJoin('book_usuarios.users as sup','sup.id','u.superintendente_id')
                            ->where('material_logs.action','VIEW_'.$type)
                            ->distinct()
                            ->when($type === 'VIDEO',function($query) use ($id){
                                return $query->where('material_logs.video_id',$id);
                            })
                            ->when($type === 'CIRCULAR',function($query) use ($id){
                                return $query->where('material_logs.circular_id',$id);
                            })
                            ->when($type === 'SCRIPT',function($query) use ($id){
                                return $query->where('material_logs.roteiro_id',$id);
                            })
                            ->when($type === 'MATERIAL',function($query) use ($id){
                                return $query->where('material_logs.material_id',$id);
                            })
                            ->groupBy('u.name')
                            ->groupBy('i.name')
                            ->groupBy('u.ilha_id')
                            ->groupBy('u.cargo_id')
                            ->groupBy('c.description')
                            ->groupBy('super.name')
                            ->groupBy('g.name')
                            ->groupBy('coord.name')
                            ->groupBy('sup.name')
                            ->groupBy('s.name')
                            ->groupBy(DB::raw('Month(material_logs.created_at)'))
                            ->get();
        } else {
            $materials = MaterialLogs::selectRaw('material_logs.created_at, Month(material_logs.created_at) as mes, u.name, i.name as ilha,
                            u.ilha_id ,u.cargo_id, c.description as cargo, super.name as supervisor, g.name as gerente, coord.name as coordenador,
                            sup.name as superintendente, s.name as setor')
                            ->leftJoin('book_usuarios.users as u','u.id','material_logs.user_id')
                            ->leftJoin('book_usuarios.ilhas as i','i.id','u.ilha_id')
                            ->leftJoin('book_usuarios.setores as s','s.id','u.setor_id')
                            ->leftJoin('book_usuarios.cargos as c','c.id','u.cargo_id')
                            ->leftJoin('book_usuarios.users as super','super.id','u.supervisor_id')
                            ->leftJoin('book_usuarios.users as g','g.id','u.gerente_id')
                            ->leftJoin('book_usuarios.users as coord','coord.id','u.coordenador_id')
                            ->leftJoin('book_usuarios.users as sup','sup.id','u.superintendente_id')
                            ->where('material_logs.action','VIEW_'.$type)
                            ->distinct()
                            ->when($type === 'VIDEO',function($query) use ($id){
                                return $query->where('material_logs.video_id',$id);
                            })
                            ->when($type === 'CIRCULAR',function($query) use ($id){
                                return $query->where('material_logs.circular_id',$id);
                            })
                            ->when($type === 'SCRIPT',function($query) use ($id){
                                return $query->where('material_logs.roteiro_id',$id);
                            })
                            ->when($type === 'MATERIAL',function($query) use ($id){
                                return $query->where('material_logs.material_id',$id);
                            })
                            ->get();
        }

        // Grava dados na sessão
        Session::put('excelExportsData', (array) $materials);

        // $bySetor = $this->treatChartData($materials, $materials->count(), 'setor_id',['ilha_id','ilha','mes']);
        // $byIlhas = $this->treatChartData($materials, $materials->count(), 'ilha_id',['ilha_id','ilha','mes']);
        return view('reports.video', compact('title','materials'));
    }

    public function treatChartData($item, int $tamanho, string $delimitadorDeBusca, array $itens) : array
    {
        //Variáveis à serem usadas
        $index = 0;
        $count = 0;
        $index0 = 0;
        $dados = [];
        if($tamanho > 0) {
            // monta dados do gráfico de visualizações por ilha
            for($i=0; $i < $tamanho; $i++) {
                if( $i === 0 ) {
                    $index0 += $item[0][$itens[0]];
                }

                // verifica se é a primeira vez que o laço passa ou se a ilha é igual à outra
                if($index0 == $item[$i][$itens[0]]) {
                    $count++;

                // caso a ilha seja diferente
                } else {
                    // coloca itens e visualizações no array
                    $array = [];
                    foreach($itens as $indice) {
                        $array[$indice] = $item[0][$indice];
                    }
                    // Pega usuários que não viram o material
                    $array['nVistos'] = $nVistos = (User::whereRaw($delimitadorDeBusca.' = '.$item[($i-1)][$itens[0]])->count())-$count;

                    //coloca usuários que visualizaram no array
                    $array['views'] = $count;

                    // coloca array em array principal
                    $dados[] = [$index => $array];
                    $index++;

                    // zera count e soma mais 1
                    $count -= ($count-1);

                    // zeera ilha_id e soma nova ilha
                    $index0 -= $index0;
                    $index0 += $item[$i][$itens[0]];
                }
            }

            if(count($dados) == 0) {
                // coloca itens e visualizações no array
                $array = [];
                foreach($itens as $indice) {
                    $array[$indice] = $item[0][$indice];
                }

                // Pega usuários que não viram o material
                $array['views'] = $count;

                //coloca usuários que visualizaram no array
                $array['nVistos'] = $nVistos = (User::where($delimitadorDeBusca,$item[0][$itens[0]])->count())-$count;

                // coloca array em array principal
                $dados[] = [$index => $array];
            }
        }

        return $dados;
    }

    // retorna relatório de videos para modal
    public function videosLite($id)
    {
        $videos = Video::select('video.id', 'video.name as title', 'u.name', 'u.username', 'l.created_at')
            ->leftJoin('book_relatorios.material_logs as l', 'l.video_id ' ,' video.id')
            ->leftJoin('book_usuarios.users as u', 'u.id ' ,' l.user_id' )
            ->where('l.action','VIEW')
            ->where('l.video_id',$id)
            ->get();
            return $videos;
    }

    public function getViewsCharts($id, $ilha, $type)
    {
        // pega todos usuários que poderiam visualizar o video
        $users = User::where('ilha_id',$ilha)
                        ->whereIn('cargo_id',[4,5,7])
                        ->count();

        // Pega usuários que vizualizaram o video
        $views = MaterialLogs::select('user_id')
                            ->distinct()
                            ->when($type === 'VIDEO',function($query,$id){
                                return $query->where('video_id',$id);
                            })
                            ->when($type === 'CIRCULAR',function($query,$id){
                                return $query->where('circular_id',$id);
                            })
                            ->when($type === 'SCRIPT',function($query,$id){
                                return $query->where('roteiro_id',$id);
                            })
                            ->when($type === 'MATERIAL',function($query,$id){
                                return $query->where('material_id',$id);
                            })
                            ->where('ilha_id',$ilha)
                            ->whereRaw('action','VIEW_'.$ilha)
                            ->count();

        return [$users, $views];
    }
}
