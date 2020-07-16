<?php

namespace App\Http\Controllers\Posts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Posts\Comment;

class Comments extends Controller
{
    
    public function index($id) {
        $comment = Comment::where('post_id',$id)->orderBy('updated_at','desc')->orderBy('created_at','desc');
        $comments = $comment->get(['content','updated_at','created_at']);
        $countComments = $comment->count();

        return json_encode(['Comments' => $comments, 'Count' => $countComments]);
    }

    public function comment($user, Request $request)
    {
        $rules = [
            'content' => 'required',
            'post_id' => 'required'
        ];
        $msg = [
            'required' => 'Não é possível enviar comentário vazio'
        ];

        $validator = Validator::make($request->all(), $rules, $msg);
        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        //Seleciona id
        $post_id = $request->input('post_id');
        $content = $request->input('content');
        
        //verifica se a reação já foi efetuada
        $search = Comment::where('user_id',$user)
                          ->where('post_id',$post_id)
                          ->get();
        
        //Verifica se reação já foi feita
        if($search->count() === 0) 
        {
            $comment = new Comment();
            $comment->content = $content;
            $comment->post_id = $post_id;
            $comment->user_id = $user;
            $comment->save();
            return response()->json(["reaction" => true], 200);
        } 
        else 
        {       
            return redirect("api/comments/update/$post_id/$content/$user");
        }

    }

    public function commentUpdate($post_id,$content)
    {
        $comment = Comment::find($post_id);
        $comment->content = $content;

        if($comment->save()) {
            return response()->json(["updated" => true], 200);
        } 
        else 
        {
            return response()->json(["success" => false], 204);
        }
        
    }
}
