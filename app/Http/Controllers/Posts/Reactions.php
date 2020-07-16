<?php

namespace App\Http\Controllers\Posts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Posts\Reaction;
use App\Posts\Post;

date_default_timezone_set('America/Sao_Paulo');

class Reactions extends Controller
{

    public function index($id) {
        $reaction1 = Reaction::where('post_id',$id)
                            ->where('react_id',1)
                            ->count();
        $reaction2 = Reaction::where('post_id',$id)
                            ->where('react_id',2)
                            ->count();
        return json_encode([$reaction1,$reaction2]);
    }

    public function view($id, $user)
    {
        $data = Reaction::where('post_id',$id)
                        ->where('user_id',$user)
                        ->get();
        return json_encode($data);
    }

    public function reaction($post_id, $react_id, $user)
    {
        //verifica se a reação já foi efetuada
        $search = Reaction::where('user_id',$user)
                          ->where('post_id',$post_id);

        //Verifica se reação já foi feita
        if($search->count() === 0) {
            $reaction = new Reaction();
            $reaction->react_id = $react_id;
            $reaction->post_id = $post_id;
            $reaction->user_id = $user;

            $post = Post::find($post_id);
            $post->reactions_number++;

            if ( $reaction->save() && $post->save() ) {
                return response()->json(["success" => true], 200);

            }
        }
        else
        {
            $reaction = $search->get('id')[0];
            $reaction->react_id = $react_id;

            if($reaction->save()) {
                return response()->json(["success" => true], 200);
            }
            else
            {
                return response()->json(["success" => false], 204);
            }
        }


    }

    public function delete($post_id,$react_id,$user_id) {
        $reaction = Reaction::where('post_id', $post_id)
                            ->where('user_id', $user_id)
                            ->get('id')[0];

        if($reaction->delete()) {
            return response()->json(["success" => true], 200);
        }
        else
        {
            return response()->json(["success" => false], 204);
        }
    }

    //pega numero de reação

    public function checkReactionNumber($post)
    {
        $reaction = Reaction::where('post_id',$post)
                            ->where('user');
    }

}
