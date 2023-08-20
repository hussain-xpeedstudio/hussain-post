<?php

namespace Hussain\Post\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Hussain\Post\Models\Post;
class PostController extends Controller
{
    public function index(){
        $post = Post::orderBy('id', 'desc')->get();
        return view('post::post',['posts'=>$post]);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:10|max:255',
            'content' => 'required|min:5|max:5000'
        ]);
    
        if ($validator->fails()) {
            return array(['errors' => $validator->errors(),'success'=>0]);
        }
        $post_id=$request->id??0;
        if($post_id==0){
            $post=new Post();
            $post->title=$request->title;
            $post->content=$request->content;
            $post->save();
        }
        else{
            $post=Post::find($post_id);
            $post->title=$request->title;
            $post->content=$request->content;
            $post->save();
        }
        
        $post = Post::orderBy('id', 'desc')->get();
        return array(['message' => 'success','success'=>1,'post'=>$post]);
    }
}
