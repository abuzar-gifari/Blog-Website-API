<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Exception;

class CommentController extends Controller
{
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


    public function getTotalComments(){
        try {
            $total_comments=Comment::count();
            // dd($total_comments);
            return response()->json([
                'success'=>true,
                'comments'=>"Total Comments number : ".$total_comments
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'contacts'=>$e->getMessage(),
            ]);
        }
    }
}
