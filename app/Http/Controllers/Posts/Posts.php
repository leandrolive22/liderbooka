<?php

namespace App\Http\Controllers\Posts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Validator;
use App\Posts\Post;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\Logs;
use App\Logs\Log;
use App\Users\Ilha;
use App\Users\User;

class Posts extends Controller
{

    //Exibe Posts
    public function indexJSON($ilha,$skip,$user,$cargo, Request $request)
    {
        $permissions = $request->permissions;
        $posts = Post::selectRaw('posts.id as id_post, posts.descript,
            posts.file_path, posts.comment_number,
            posts.reactions_number, posts.priority,
            posts.user_id, DATE_FORMAT(posts.created_at,"%y-%m") AS mesAno,
            posts.created_at as date, posts.updated_at as updated,
            users.name as userPost, users.avatar, users.last_login,
            posts.view_number as view_number')
        ->leftJoin('book_usuarios.users','book_posts.posts.user_id','book_usuarios.users.id')
        ->when($permissions == 0,function($q) use ($ilha,$cargo,$user) {
            return $q->whereRaw('book_posts.posts.ilha_id LIKE "%,'.$ilha.',%"')
            ->orWhereRaw('book_posts.posts.ilha_id LIKE "%,1,%"')
            ->orWhere('book_posts.posts.user_id',$user)
            ->orWhereRaw('book_posts.posts.cargo_id LIKE "%,'.$cargo.',"');
        })
        ->skip($skip)
        ->take(env('PAGINATE_NUMBER'))
        ->orderBy('mesAno','DESC')
        ->orderBy('priority','ASC')
        ->orderBy('date','DESC')
        ->get();

        foreach($posts as $post) {
            $this->viewPost($post->id_post,$user,$ilha);
        }

        return $posts->toJSON();
    }

    // não uso, mas não apaguem
    public function index($ilha,$skip,$user,$cargo)
    {
        //verifica cargo para saber se o usuário verá todo conteúdo ou apenas o próprio
        if(in_array($cargo,[1,2,9,15])) {
            $ilhas = NULL;
        } else {
            $ilhas = [$ilha,1];
        }

        $posts = Post::select('book_posts.posts.id as id_post','book_posts.posts.descript',
            'book_posts.posts.file_path','book_posts.posts.comment_number',
            'book_posts.posts.reactions_number','book_posts.posts.priority',
            'book_posts.posts.user_id','book_usuarios.ilhas.name as ilha_name',
            'book_posts.posts.created_at as date','book_posts.posts.updated_at as updated',
            'book_usuarios.users.name as userPost', 'book_usuarios.users.avatar')
        ->join('book_usuarios.ilhas','book_posts.posts.ilha_id','book_usuarios.ilhas.id')
        ->join('book_usuarios.users','book_posts.posts.user_id','book_usuarios.users.id')
        ->when(!is_null($ilhas),function($q, $ilhas){
            return $q->whereIn('book_posts.posts.ilha_id',$ilhas);
        })
        ->skip($skip)
        ->take(10)
        ->latest('book_posts.posts.created_at')
        ->orderBy('priority','asc')
        ->get();

        foreach($posts as $p) {
            $this->viewPost($p->id_post,$user,$ilha);
        }

        return $posts;
    }

    //salva vizualização de post
    public function viewPost($id, $user, $ilha) {
        $views = $this->verifyViewPost($user,$id);

        if($views[0] == 0 || $views[0] == NULL) {

            $log = new Logs();
            $log->log('VIEW_POST',$id,asset('/home'),$user,$ilha);

            if(is_null($views[1])) {
                $postObj = Post::find($id);
                $postObj->view_number++;
                return $postObj->save();
            }

            return TRUE;
        }
    }

    //verifica quantas vezes o post foi visto
    public function verifyViewPost($user,$post) : Array
    {
        $views = Log::select('created_at')
        ->whereRaw('action LIKE "VIEW_POST%" ')
        ->where('value',$post)
        ->where('user_id',$user)
        ->get();

        return [@$views->count(), @$views[0]->created_at];
    }

    //Salva Posts
    public function store(Request $request, $user)
    {
        // Altera configurações php para upload
        ini_set('max_execution_time',60);
        ini_set('post_max_size',"100M");
        ini_set('upload_max_filesize',"100M");

        $path = NULL;

        $ilha_id = $request->input('ilha_id');
        $cargo_id = $request->input('cargo_id');

        //Verifica se publicação está vazia
        if( ($request->input('descript') == NULL) && ($request->file('file_path') == NULL) ) {
            return response()->json(['erro','Publicação vazia!'], 422);
        }

        // Salvo o Arquivo do post no diretorio definido
        if(!empty($request->file('file_path'))) {
         $path .= 'storage/' . $request->file('file_path')->store('posts','public');
     }

        //Verifica se cargo_id foi selecionado e trata para não haver erros
     if( in_array($cargo_id,[0,'','undefined',' ',NULL,'null'])) {
        unset($cargo_id);
        $cargo_id = NULL;
    }

        //Verifica se ilha_id foi selecionado e trata para não haver erros
    if( in_array($ilha_id,[0,'','undefined',' ',NULL,'null'])) {
        unset($ilha_id);
        $ilha_id = NULL;
    }

        // Insert no banco
    $post = new Post();
    $post->descript = nl2br($request->input('descript'));
    $post->file_path = $path;
    $post->comment_number = 0;
    $post->reactions_number = 0;
    $post->view_number = 0;
    $post->priority = $request->input('priority');
    $post->user_id = $user;
    $post->ilha_id = ','.$ilha_id.',';
    $post->cargo_id = ','.$cargo_id.',';
    if($post->save()) {
        $ilha = Ilha::select('name')->where('id',$ilha_id)->get();
        return response()->json(['success' => TRUE, 'post' => $post, 'ilha_name' => $ilha], 201);
    }

    return response()->json(['success' => FALSE], 422);

}

public function delete($id,$user)
{
    $ilha = User::find($user)['ilha_id'];

    $delete = Post::find($id);
    if($delete->delete()) {
        return back()->with(['successAlert'=> 'Publicação excluída']);
        $log = new Logs();
        $log->post($id, $ilha, $user,'DELETE_POST');

    } else {
        return back()->with(['errorAlert' => $delete->error()->all()]);
    }

}

}
