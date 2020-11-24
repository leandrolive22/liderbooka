<?php

namespace App\Http\Controllers\Materiais;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Permissions\Permissions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Materiais\Cargo As FiltroCargo;
use App\Materiais\Ilha As FiltroIlha;
use App\Materiais\Material;
use App\Materiais\Tag;
use App\Materiais\Tipo;
use App\Users\Ilha;
use App\Users\Cargo;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /** ROTAS */
    public function index()
    {
        $ilha = Auth::user()->ilha_id;
        $cargo = Auth::user()->cargo_id;

        $title = 'Wiki';
        $tipos = $this->getTipos();
        $categorias = $this->getUserTags($ilha, $cargo);
        $tagsClicadas = $this->tags_mais_clicadas_10_min($ilha, $cargo);
        $materiaisClicados = $this->materiais_mais_clicados_10_min($ilha, $cargo);
        $users = $this->getUsersEngagement();

        $compact = compact('title', 'tipos', 'categorias', 'tagsClicadas', 'materiaisClicados', 'users');

        return view('wiki.viewnew', $compact);
    }

    public function hashtags(){
        $title = "Hash Tags";
        return view('wiki.hashtags',compact('title'));
    }

    public function categorias($type, $ilha){
        $title = "Categorias";
        return view('wiki.categorias',compact('title','type'));
    }

    public function materiais($type, Request $request){
        $title = "Materiais";
        $data = [
            'ilha' => Auth::user()->ilha_id,
            'cargo' => Auth::user()->cargo_id,
            'carteira' => Auth::user()->carteira_id
        ];
        $result = $this->search($type, $request, FALSE, $data);
        $name = @Tipo::find($type)->name;

        return view('wiki.viewmateriais',compact('title','type','result','name'));
    }

    /** Pega tags mais clicadas nos ultimos 10 minutos
     *
     * @return DB|Exception;
     */
    public function tags_mais_clicadas_10_min()
    {
        try {
            return DB::table('book_relatorios.tags_mais_clicadas_10_min')->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /** Pega materiais mais visualizados nos ultimos 10 minutos
     *
     * @param int|null $ilha_id
     * @param int|null $ilha_id
     * @return Material|Exception;
     */
    public function materiais_mais_clicados_10_min($ilha_id = NULL, $cargo_id = NULL)
    {
        try {
            $select = "COUNT(l.id) views, l.id_material, max(l.created_at) recente, materiais_apoio.name as name, materiais_apoio.file_path AS file,
            CONCAT(',',(SELECT CONCAT(ilha_id) FROM book_materiais.filtros_ilhas WHERE material_id = materiais_apoio.id AND deleted_at IS NULL),',') ilhas,
            CONCAT(',',(SELECT CONCAT(cargo_id) FROM book_materiais.filtros_cargos WHERE material_id = materiais_apoio.id AND deleted_at IS NULL),',') cargos";

            return Material::selectRaw($select)
                ->join('book_relatorios.`material_logs` AS l', 'l.id_material', 'materiais_apoio.id')
                ->where('l.action', 'LIKE', DB::raw("VIEW_%"))
                ->where('l.created_at','>=', DB::raw('DATE_SUB(CURRENT_TIMESTAMP, INTERVAl 10 MINUTE)'))
                ->whereRaw("ilhas LIKE ',%$ilha_id%,' OR ilhas IS NULL")
                ->whereRaw("cargos LIKE ',%$cargo_id%,' OR cargos IS NULL")
                ->groupBy('l.material_id')
                ->orderBy(DB::raw('recente'),'DESC')
                ->limit(10);

            } catch (Exception $e) {
                return $e->getMessage();
            }
    }

    /** Seleciona as categorias que o usuário pode ver
     *
     * @param int $cargo_id
     * @param int $ilha_id
     * @return Tag
     */
    public function getUserTags(int $ilha_id, int $cargo_id)
    {
        return Tag::select("tags.name")
            ->distinct()
            ->join('materiais_apoio AS m', 'm.id', 'tags.material_id')
            ->leftJoin('filtros_ilhas AS i','i.material_id','m.id')
            ->leftJoin('filtros_cargos AS c','c.material_id','m.id')
            ->whereRaw("m.deleted_at IS NULL
                AND (ilha_id = $ilha_id OR ilha_id IS NULL)
                AND (cargo_id = $cargo_id OR cargo_id IS NULL)")
            ->get();
    }

    /** Pega usuários que mais viram materiais baseado em data
     *
     * @param string|null $date
     * @return App\User
     */
    public function getUsersEngagement($date = NULL)
    {
        if(is_null($date)) {
            $dateSearch = date("Y-m-01 00:00:00");
        } else {
            $dateSearch = date("Y-m-d 00:00:00", strtotime($date));
        }

        return User::select('users.name', 'users.avatar', DB::raw('count(m.id) views'))
                ->join('book_relatorios.material_logs AS m', 'users.id', 'm.user_id')
                ->whereRaw("m.action LIKE 'VIEW%' AND ISNULL(m.deleted_at)")
                ->where('m.created_at', '>=', $dateSearch)
                ->groupBy('users.name')
                ->groupBy('users.avatar')
                ->limit(4)
                ->get();
    }


    /** Retorna view de gerenciamento de materiais
     *
     * @return View
     */
    public function manager()
    {
        $title = 'Wiki';
        $tipos = $this->getTipos();
        $tags = $this->getTags();
        $ilhas = $this->getIlhas();
        $cargos = $this->getCargos();

        return view('wiki.manager', compact('tipos', 'tags', 'title', 'ilhas', 'cargos'));
    }

    /**
     * Excluí Material com softDelete
     * @param int $id
     * @return Response
     */
    public function deleteMaterial(int $id)
    {
        try {
            $user = Auth::id();
            $material = $this->checkIfMaterialExists($id);

            if(!$material) {
                return response()->json(['errorAlert' => 'Material Não encontrado!'],500);
            } else {
                $tipo = $material->tipo_id;
                $material->delete();
                $log = new Logs();
                $log->logMaterial($user, $id, $tipo, 'DELETE_MATERIAL');
                return response()->json(['successAlert' => 'Material excluído!'],201);
            }
        } catch (\Exception $e) {
            return response()->json(['errorAlert' => 'Erro! Contate o suporte e passe a seguinte frase: <br>'.
                $e->getMessage()],500);
        }
    }

    /** Checa se material existe ou foi apagado
     *
     * @param int $id
     * @return bool|App\Materiais\Material
     */
    public function checkIfMaterialExists(int $id)
    {
        $material = Material::find($id);

        if(!is_null($material)) {
            return $material;
        }

        return FALSE;
    }

    /** Salva ou altera material e sincroniza mudanças
     *
     * @param Illuminate\Http\Request
     * @return Response
     */
    public function syncMaterial(Request $request)
    {
        $id = $request->id;
        $rules = [
            'id' => 'required|int|min:0',
            'tipo_id' => 'required|int|min:1',
            'title' => 'required|min:1',
            'description' => 'required',
        ];

        $msgs = [
            'id.required' => 'Dados inválidos! Recarregue a página e tente novamente! (id)',
            'id.int' => 'Dados inválidos! Recarregue a página e tente novamente! (id)',
            'id.min' => 'Dados inválidos! Recarregue a página e tente novamente! (id)',
            'tipo_id.required' => 'Dados inválidos! Recarregue a página e tente novamente! (tipo_id)',
            'tipo_id.int' => 'Dados inválidos! Recarregue a página e tente novamente! (tipo_id)',
            'tipo_id.min' => 'Dados inválidos! Recarregue a página e tente novamente! (tipo_id)',
            'title.required' => 'O nome do material deve ser preenchido!',
            'title.int' => 'Quantidade de carateres inválidas para o nome do material!',
            'description' => 'O campo Descrição não pode ser inválido',
        ];

        $id = $request->id;

        if($id === 0) {
            $rules['tags'] = 'required';
            $rules['material_file'] = 'required|file';
            $msgs['tags.required'] = 'Selecione ao menos uma Categoria!';
            $msgs['material_file.required'] = 'Submeta um arquivo válido!';
            $msgs['material_file.file'] = 'Submeta um arquivo!';
        }

        // validação
        $request->validate($rules, $msgs);

        // seta variáveis de controle e quem vem do form
        $error = 0;
        $id = $request->id;
        $tipo_id = $request->tipo_id;
        $title = $request->title;
        $description = $request->description;
        $tags = explode(',',$request->tags);
        if($id === 0) {
            $file = $request->file('material_file');

            // Checa se existe arquivo e se foi submetido
            if(empty($file)) {
                return back()->with('errorAlert', 'Arquivo inválido!');
            }

            // grava arquivo no Storage
            $file_path = 'storage/'.$file->store('materiais','public');
        }

        //
        try {
            // Verifica se material existe
            if($id > 0) {
                $material = Material::find($id);
                $isEdit = 1;
            } else {
                $material =  new Material();
                $isEdit = 0;
            }

            $material->name = $title;
            $material->description = $description;

            // Se é edição, não altera caminho
            if($isEdit === 0) {
                $material->file_path = $file_path;
            }

            $material->tipo_id  = $tipo_id;
            $material->user_id = Auth::id();
            if(!$material->save()) {
                $error++;
            }

            if($error === 0) {
                $material_id = $material->id;

                // Se n é editar
                if($isEdit === 0) {
                    $tagsInsert = [];
                    foreach($tags as $item) {

                        $tagsInsert[] = [
                            'name' => trim($item),
                            'material_id' => $material_id
                        ];
                    }

                    if(!Tag::insert($tagsInsert)) {
                        $error++;
                    }
                }

                if($error > 0) {
                    return back()->with('errorAlert', "Erro ao salvar Tags, material #$material_id incluso");
                }

                $this->restoreCacheManager();
                return redirect(url()->previous())->with('material_id_success',$material_id);
            }

        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return back()->with('errorAlert', "Erro! Contate o suporte");
        }
    }

    /**
     * Edita filtros por material
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function syncFiltros(Request $request)
    {
        $error = 0;
        $todos = $request->todos;
        $type = $request->type;
        $data = substr($request->ids,0,-1);
        $material_id = $request->material_id;

        if($todos > 0) {
            if($this->todosFiltros($type, $material_id)) {
                return response()->json(['successAlert' => 'Filtros sincronizado com sucesso!'],201);
            }

            return response()->json(['successAlert' => 'Filtros sincronizado com sucesso!','warningAlert' => 'Filtros antigos não excluídos'],201);
        }

        $get = $this->getFiltros($type, $material_id);
        $filtro = $this->filtraArray(explode(',',$data), $get);
        // return $this->insertSync($type,$filtro, $material_id);
        if($this->insertSync($type,$filtro, $material_id)) {
            if($this->syncDelete($type,$filtro, $material_id)) {
                return response()->json(['successAlert' => 'Filtros sincronizado com sucesso!'],201);
            }

            return response()->json(['successAlert' => 'Filtros sincronizado com sucesso!','warningAlert' => 'Filtros antigos não excluídos'],201);
        }

        return response()->json(['errorAlert' => 'Erro ao sincronizar filtros!'],422);
    }

    /** Coloca todos os filtros para material
     *
     * @param mixed $type
     * @param mixed $material_id
     * @return bool
     */
    public function todosFiltros($type, $material_id) : bool
    {
        if($type === 'ilhas') {
            $column = 'ilha_id';
            $model = 'App\Materiais\Ilha';
        } else if($type === 'cargos') {
            $model = 'App\Materiais\Cargo';
            $column = 'cargo_id';
        }

        $select = $model::where('material_id',$material_id);
        if($select->count() === 0) {
            return TRUE;
        }


        return $select->update([$column => NULL]);
    }

    /** Deleta os filtros do material que foram desmarcados
     *
     * @param string $type
     * @param array $ids
     * @param int $material_id
     * @return bool
     */
    public function syncDelete(string $type, array $ids, int $material_id) : bool
    {
        if($type === 'ilhas') {
            return FiltroIlha::whereRaw('ilha_id NOT IN (?) AND material_id = ?',[implode(',',$ids),$material_id])->delete();
        } else if($type === 'cargos') {
            return FiltroCargo::whereRaw('cargo_id NOT IN (?) AND material_id = ?',[implode(',',$ids),$material_id])->delete();
        }
    }

    /** Grava filtros no banco de dados
     *
     * @param string $type
     * @param array $ids
     * @param int $material
     * @return bool
     */
    public function insertSync(string $type, array $ids, int $material_id) : bool
    {

        if($type === 'ilhas') {
            $model = 'App\Materiais\Ilha';
            $column = 'ilha_id';
        } else if($type === 'cargos') {
            $model = 'App\Materiais\Cargo';
            $column = 'cargo_id';
        }

        foreach($ids as $id){
            $insert[] = [
                'material_id' => $material_id,
                $column => $id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $model::insert($insert);

    }

    /**
     *  Pega filtros por material id
     *
     * @param string $type
     * @param int $material_id
     * @return array
     */
    public function getFiltros(string $type, int $material_id) : array
    {
        if($type === 'ilhas') {
            $filtro = FiltroIlha::where('material_id',$material_id)->get();
            $typeObj = 'ilha_id';
        } else if($type === 'cargos') {
            $filtro = FiltroCargo::where('material_id',$material_id)->get();
            $typeObj = 'cargo_id';
        }

        if($filtro->count() > 0) {
            $retorno = [];
            foreach($filtro as $item) {
                array_push($retorno, $item->$typeObj);
            }
            return $retorno;
        }

        return [];
    }

    /**
     *  une dados de 2 arrays e filtra repetidos
     *
     * @param array $data
     * @param array $antigo
     * @return array
     */
    public function filtraArray(array $data, array $antigo) : array
    {
        $dados = array_merge($data, $antigo);
        return array_unique($dados);
    }

    /**
     * Apaga Cache
     *
     * @return void
     */
    public function restoreCacheManager()
    {
        Cache::forget('tags');
        Cache::forget('tipos');
    }

    /**
     * Pega ilhas de cache para filtragem
     *
     * @return App\Materiais\Tag
     */
    public function getTags()
    {
        $day= 60*60*24; // 86400 seconds or 1 day
        $tags = Cache::get('tags');

        if(is_null($tags)) {
            $tags = Tag::select('name')->distinct()->get();
            Cache::put('tags',$tags,$day);
        }

        return $tags;
    }

    /**
     * Pega ilhas de cache para filtragem
     *
     * @return App\Materiais\Tipo
     */
    public function getTipos()
    {
        $day= 60*60*24; // 86400 seconds or 1 day
        $tipos = Cache::get('tipos');

        if(is_null($tipos)) {
            $tipos = Tipo::all();
            Cache::put('tipos',$tipos,$day);
        }

        return $tipos;
    }

    /**
     * Pega ilhas de cache para filtragem
     *
     * @return App\Users\Ilha
     */
    public function getIlhas($ilha = 0)
    {
        $ilhas = Cache::get('getIlhas');

        if(is_null($ilhas)) {
            $ilhas = Ilha::when($ilha > 0 && !is_null($ilha), function($query) use ($ilha) {
                return $query->where('ilha_id', $ilha);
            })->get();

            Cache::put('getIlhas',$ilhas,3600);
        }

        return $ilhas;
    }

    /**
     * Pega cargos de cache para filtragem
     *
     * @return App\Users\Cargo
     */
    public function getCargos()
    {
        $day= 60*60*24; // 86400 seconds or 1 day
        $cargos = Cache::get('getCargos');

        if(is_null($cargos)) {
            $cargos = Cargo::all();
            Cache::put('getCargos',$cargos,$day);
        }

        return $cargos;
    }

    // permissões
    /** pega ilhas por carteira e transforma em string para consulta
     *
     * @param int $carteira
     * @return string $carteiras
     */
    public function ilhasByCarteira(int $carteira)
    {
        $carteiras = '';
        $getCarteiras = DB::select("SELECT id FROM ilhas WHERE setor_id IN (SELECT id FROM setores WHERe carteira_id = ? AND ISNULL(deleted_at)) AND ISNULL(deleted_at)", [$carteira]);
        foreach ($getCarteiras as $item) {
            $carteiras .= $item->id.',';
        }
        return $carteiras = substr($carteiras, 0, -1);
    }

    /** Configura filtros de busca de materiais
     * @param int $ilha
     * @param int $cargo
     * @param int $carteira_id
     * @return string
     */
    public function setWhere($ilha, $cargo, $carteira_id)
    {
        $p = new Permissions();
        $types = $p->wikiSearchType();

        // Acesso à todas
        if($types['tudo']) {
            return 'materiais_apoio.id > 0';
        } else if($types['carteira']) {
            // Acesso às carteiras
            $carteiras = $this->ilhasByCarteira($carteira_id);

            if(is_null($carteiras) || $carteiras == '') {
                $carteiras = 0;
            }
            return '(i.ilha_id IN ('.$carteiras.') OR ISNULL(i.ilha_id)) AND (c.cargo_id = '.$cargo.' OR ISNULL(c.cargo_id))';
        } else if($types['ilha']) {
            // Acesso à ilhas
            return '(i.ilha_id = '.$ilha.' OR ISNULL(i.ilha_id)) AND (c.cargo_id = '.$cargo.' OR ISNULL(c.cargo_id))';

        } else {
            return 'ISNULL(i.ilha_id) AND (c.cargo_id = '.$cargo.' OR ISNULL(c.cargo_id))';
        }
    }

    /** Faz consulta por materiais
     *
     * @param string $where
     * @param null|string $filter
     * @return App\Materiais\Material
     */
    public function getMaterials($where, $type, $filter = NULL)
    {
        return Material::selectRaw('materiais_apoio.id AS id_material, materiais_apoio.name, materiais_apoio.file_path, materiais_apoio.created_at AS data_criacao')
        ->leftJoin('filtros_ilhas AS i', 'i.material_id', 'materiais_apoio.id')
        ->leftJoin('filtros_cargos AS c', 'c.material_id', 'materiais_apoio.id')
        ->whereRaw($where)
        ->when(!is_null($filter), function($q) use ($filter){
            return $q->whereRaw($filter);
        })
        ->where('materiais_apoio.tipo_id','=',$type)
        ->orderby('materiais_apoio.created_at','desc')
        ->paginate(9);
    }

    /**
     *
     * @param string $filter
     * @param string $text
     * @return string $newFilter
     */
    public function setFilter(string $filter, string $text)
    {
        if($filter === 'id') {
            $newFilter = ' '.$filter.' = '.$text;
        } else {
            $newFilter = ' '.$filter.' LIKE "%'.$text.'%"';
        }
        return $newFilter;
    }

    /** Filtra materiais
     *
     * @param int $type
     * @param Illuminate\Http\Request;
     * @param bool $haveFilter
     * @return string $json
     */
    public function search(int $type, Request $request, bool $haveFilter = FALSE, $data = NULL)
    {
        // Configura filtros
        $setFilter = NULL;
        if($haveFilter) {
            $request->validate(['filter' => 'required', 'text' => 'required'],['filter.required' => 'Selecione um filtro', 'text' => 'Preencha o campo de pesquisa!']);

            $filter = $request->filter;
            $text = $request->text;

            $setFilter = $this->setFilter($filter, $text);
        }

        // Configura consulta
        if(is_null($data)) {
            $where = $this->setWhere(Auth::user()->ilha_id, Auth::user()->cargo_id, Auth::user()->carteira_id);
        } else {
            $where = $this->setWhere($data['ilha'],$data['cargo'],$data['carteira']);
        }

        // Executa consulta
        $materiais = $this->getMaterials($where, $type, $setFilter);
        return $materiais;
    }

    public function getMaterial(int $id)
    {
        try {
            return Material::find($id);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['errorAlert' => $msg], 500);
        }
    }

    /**
     * Retorna as tags que o material possui
     *
     * @param int $id
     * @return App\Materiais\Tag|Illuminate\Http\Response
     */
    public function getTagsByMaterial(int $id)
    {
        try {
            return Tag::where('material_id',$id)->get();
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['errorAlert' => $msg], 500);
        }
    }

    /**
     * Edita tags vinculadas ao material
     *
     * @param int $id
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function setTagsByMaterial(int $id, Request $request)
    {
        try {
            $data = explode(',',$request->tags);

            $insertArray = [];

            DB::beginTransaction();
            Tag::where("material_id",$id)->delete();

            foreach($data as $item) {
                if(!in_array($item,[NULL,'',' '])) {
                    $insertArray[] = [
                        'name' => $item,
                        'material_id' => $id
                    ];
                }
            }

            if(Tag::insert($insertArray)) {
                DB::commit();
                Cache::forget('tags');
                return response()->json(['successAlert' => 'Categoria atualizadas com sucesso!'], 201);
            }

            DB::rollback();
            return response()->json(['errorAlert' => 'Categoria não atualizadas!'], 500);

        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['errorAlert' => $msg], 500);
        }
    }

    /**
     * Altera arquivo do material
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function setFile(Request $request)
    {
        try {

            $id = $request->input('id');;
            $file = $request->file('material_file');

            // Checa se existe arquivo e se foi submetido
            if(empty($file)) {
                return back()->with('errorAlert', 'Arquivo inválido!');
            }

            // grava arquivo no Storage
            $file_path = 'storage/'.$file->store('materiais','public');

            // Verifica se material existe

            $material = Material::find($id);
            $material->file_path = $file_path;
            $material->user_id = Auth::id();
            if($material->save()) {
                return back()->with('successAlert','Material Atualizado')->with('src', $file_path)->with('idMaterial',$id);
            }

        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return back()->with('errorAlert', $msg);
        }
    }

    public function saveStarMaterial(int $id, int $user, int $tipo_id, int $value)
    {
        try {
            $logs = new Logs();
            if($logs->logMaterial($user, $id, $tipo_id, 'NEW_STAR', $value)) {
                return response()->json(['successAlert' => TRUE], 201);
            }

            return response()->json(['errorAlert' => "Erro ao gravar reação, contate o suporte!"], 422);

        } catch (\Exception $e) {
            return response()->json(['errorAlert' => $e->getMessage()], 500);
        }
    }
}
