<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Subscribe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;

class SubscribeController extends Controller
{
    public function store(Request $request){
        try {
            //validation
            $validation=Validator::make($request->all(),[
                'email'=> ['required','email'],
            ]);
            if (!$validation->fails()) {
                $subscribe = Subscribe::create([
                    'email'=>$request->email
                ]);
                if ($subscribe) {
                    return response()->json([
                        'success'=>true,
                        'message'=> "Subscribe Created Successfully"
                    ]);
                }else {
                    return response()->json([
                        'success'=>false,
                        'message'=> "Some Problem Occured"
                    ]);
                }    
            }else {
                return response()->json([
                    'success'=>false,
                    'message'=> $validation->errors()->all(),
                ]);
            }
            
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'err_message'=> $e->getMessage(), 
            ]);
        }
    }
}
