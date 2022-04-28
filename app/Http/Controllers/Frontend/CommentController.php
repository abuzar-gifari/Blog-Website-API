<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use Exception;

class CommentController extends Controller
{
    public function comment(Request $req,$id) {
        try {
            $validation=Validator::make($req->all(),[
                'name'=> ['required'],
                'email'=> ['required'],
                'comment'=> ['required']
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all()
                ]);
            }else {
                $result=Comment::create([
                    'post_id'=>$id,
                    'name'=> $req->name,
                    'email'=> $req->email,
                    'comment'=> $req->comment,
                ]);
                if ($result) {
                    return response()->json([
                        'success'=>true,
                        'message'=>"Comment Succesfully"
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


    public function getComments(){
        try {
            $commnets=Comment::orderBy('id','desc')->get();
            return response()->json([
                'success'=>true,
                'comments'=>$commnets
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'contacts'=>$e->getMessage(),
            ]);
        }
    }
}
