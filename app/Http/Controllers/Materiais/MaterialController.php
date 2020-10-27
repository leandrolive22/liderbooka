<?php

namespace App\Http\Controllers\Materiais;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Materiais\Cargo As FiltroCargo;
use App\Materiais\Ilha As FiltroIlha;
use App\Materiais\Material;
use App\Materiais\Tag;
use App\Materiais\Tipo;
use App\Users\Ilha;
use App\Users\Cargo;
use Auth;
use Cache;
use DB;
use Storage;

class MaterialController extends Controller
{
    /* ROTAS */
    public function index()
    {
        $title = 'Wiki';
        $ilhas = $this->getIlhas();
        $cargos = $this->getCargos();
        $tipos = $this->getTipos();
        $tags = $this->getTags();

    	return view('wiki.wiki');
    }

    public function indexnew()
    {
        $title = 'Wiki';
        $ilhas = $this->getIlhas();
        $cargos = $this->getCargos();
        $tipos = $this->getTipos();
        $tags = $this->getTags();
        
    	return view('wiki.viewnew');
    }

	

    public function manager()
    {
        $title = 'Wiki';
        $tipos = $this->getTipos();
        $tags = $this->getTags();
        $ilhas = $this->getIlhas();
        $cargos = $this->getCargos();

        return view('wiki.manager', compact('tipos', 'tags', 'title', 'ilhas', 'cargos'));
    }

    //
    public function syncMaterial(Request $request)
    {
        $rules = [
            'id' => 'required|int|min:0',
            'tipo_id' => 'required|int|min:1',
            'title' => 'required|min:1',
            'tags' => 'required',
            'material_file' => 'required|file'
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
            'tags.required' => 'Selecione ao menos uma tag!',
            'material_file.required' => 'Submeta um arquivo válido!',
            'material_file.file' => 'Submeta um arquivo!',
        ];

        // validação
        $request->validate($rules, $msgs);

        // seta variáveis de controle e quem vem do form
        $error = 0;
        $id = $request->id;
        $tipo_id = $request->tipo_id;
        $title = $request->title;
        $tags = explode(',',$request->tags);
        $file = $request->file('material_file');

        // Checa se existe arquivo e se foi submetido
        if(empty($file)) {
            return back()->with('errorAlert', 'Arquivo inválido!');
        }

        // grava arquivo no Storage
        $file_path = $file->store('materiais','public');

        //
        try {
            // Verifica se material existe
            if($id > 0) {
                $material = Material::find($id);
            } else {
                $material =  new Material();
            }
            $material->name = $title;
            $material->file_path = $file_path;
            $material->tipo_id  = $tipo_id;
            $material->user_id = Auth::id();
            if(!$material->save()) {
                $error++;
            }

            if($error === 0) {
                $material_id = $material->id;

                $tagsInsert = [];
                foreach($tags as $item) {

                    $tagsInsert[] = [
                        'name' => $item,
                        'material_id' => $material_id
                    ];
                }

                if(!Tag::insert($tagsInsert)) {
                    $error++;
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

    /* Coloca todos os filtros para material
    *
    */
    public function todosFiltros($type, $material_id) : bool
    {
        if($type === 'ilhas') {
            $column = 'ilha_id';
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

    // Pega filtros por material id
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

    // pega dados de array e filtra
    public function filtraArray(array $data, array $antigo) : array
    {
        $dados = array_merge($data, $antigo);
        return array_unique($dados);
    }

    // apaga cache de amanger
    public function restoreCacheManager()
    {
        Cache::forget('tags');
        Cache::forget('tipos');
    }

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

}
