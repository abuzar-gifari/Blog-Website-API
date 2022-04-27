<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class GetPostController extends Controller
{
    public function index(){
        try {
            $posts=Post::orderBy('id','desc')->get();
            return response()->json([
                'success'=>true,
                'posts'=>$posts
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage()
            ]);
        }
    }

    public function viewposts(){
        try {
            $posts=Post::where('views','>',0)->with('categorys')->orderBy('id','desc')->get();
            return response()->json([
                'success'=>true,
                'posts'=>$posts
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage()
            ]);
        }
    }

    public function getPostById($id){
        try {

            $posts=Post::findOrFail($id);
            $posts->views = $posts->views+1;
            $posts->save();

            return response()->json([
                'success'=>true,
                'posts'=>$posts
            ]);  

        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage()
            ]);
        }
    }

    public function getPostByCategory($id){
        try {
            $posts=Post::where('id',$id)->orderBy('id','desc')->get();
            return response()->json([
                'success'=>true,
                'posts'=>$posts
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage()
            ]);
        }
    }


    public function searchPost($search){
        try {
            $posts=Post::with('categorys')->where('title','LIKE','%'.$search.'%')->orderBy('id','desc')->get();
            return response()->json([
                'success'=>true,
                'posts'=>$posts
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage()
            ]);
        }
    }
}
