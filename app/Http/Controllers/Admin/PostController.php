<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(){
        try {
            $posts = Post::orderBy('id','desc')->with('categorys')->get();
            $categories=Category::orderBy('id','desc')->get();
            if ($posts) {
                return response()->json([
                    'success'=>true,
                    'posts'=> $posts
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=> $e->getMessage()
            ]);
        }
    }



    public function store(Request $req) {
        try {
            $validation=Validator::make($req->all(),[
                'title'=> ['required','min:10','max:100','string','unique:posts'],
                'description'=> ['required','min:10','max:1000'],
                'cat_id'=> ['required'],
                'image'=> ['required']
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all()
                ]);
            }else {
                $fileName="";
                if ($req->file('image')) {
                    $fileName=$req->file('image')->store('posts','public');
                }else {
                    $fileName="null";
                }
                $result=Post::create([
                    'title'=>$req->title,
                    'description'=>$req->description,
                    'image'=>$fileName,
                    'cat_id'=>$req->cat_id,
                    'views'=>0
                ]);
                if ($result) {
                    return response()->json([
                        'success'=>true,
                        'message'=>"Post Added Succesfully"
                    ]);
                }else {
                    return response()->json([
                        'success'=>false,
                        'message'=>"Some Problem Occured"
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ]);
        }
    }


    public function edit($id){
        try {
            $posts=Post::findOrFail($id);
            if ($posts) {
                return response()->json([
                    'success'=>true,
                    'posts'=> $posts
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ]);
        }
    }

    public function update(Request $req, $id){
        try {
            $posts=Post::findOrFail($id);
            $validation = Validator::make($req->all(),[
                'title'=> ['required','min:10','max:100','string','unique:posts'],
                'description'=> ['required','min:10','max:1000'],
                'cat_id'=> ['required'],
                'image'=> ['required']
            ]);
            if ($validation->fails()) {
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all()
                ]);
            }else {
                $fileName="";
                if ($req->file('new_image')) {
                    $fileName=$req->file('new_image')->store('posts','public');
                }else {
                    $fileName="null";
                }
                $posts->title=$req->title;
                $posts->description=$req->description;
                $posts->cat_id=$req->cat_id;
                $posts->image=$req->image;
                $result=$posts->save();
                if ($result) {
                    return response()->json([
                        'success'=>true,
                        'message'=>"Post Updated Successfully"
                    ]);
                }else {
                    return response()->json([
                        'success'=>false,
                        'message'=>"Some Problem Occured"
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ]);
        }
    }


    public function delete($id){
        try {
            $posts=Post::findOrFail($id)->delete();
            if ($posts) {
                return response()->json([
                    'success'=>true,
                    'message'=>"Post Deleted Successfully"
                ]);
            }else {
                return response()->json([
                    'success'=>false,
                    'message'=>"Some Problem Occured"
                ]);
            }
        }    catch (Exception $exp) {
            return response()->json([
                'success'=>false,
                'message'=>$exp->getMessage()
            ]);
        }
    }

    public function search($search){ 
        try {
            $posts=Post::where('title','LIKE','%'.$search.'%')->orderBy('id','desc')->get();
            if ($posts) {
                return response()->json([
                    'success'=>true,
                    'posts'=> $posts
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage()
            ]);
        }
    }

}
