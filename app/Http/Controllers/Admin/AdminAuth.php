<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
// use Dotenv\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuth extends Controller
{
    public function login(Request $request){
        try {
            $validation = Validator::make($request->all(),[
                'name'=>['required','string'],
                'password'=>['required','string'],
            ]);
            if ($validation->fails()) {
                return response()->json([
                    'success'=>false,
                    'error_message'=>"validation problem occured"
                ]);
            }else {
                $users=User::where('name',$request->name)->first();
                if (!$users) {
                    return response()->json([
                        'success'=>false,
                        'error_message'=>"Invalid Credentials 1"
                    ]); 
                }else {
                    if (!Hash::check($request->password,$users->password)) {
                        return response()->json([
                            'success'=>false,
                            'error_message'=>"Invalid Credentials 2"
                        ]); 
                    }else {
                        $tokens=$users->createToken('token')->plainTextToken;
                        return response()->json([
                            'success'=>true,
                            'message'=>'Login Successfully',
                            'token'=>$tokens,
                        ]); 
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage()
            ]);
        }
    }


    public function admins(Request $request){
        $users = $request->user();
        return response()->json($users);
    }

    // public function logout(Request $request){
    //     $id=$request->user()->id;
    //     auth()->user()->tokens()->where('tokenable_id',$id)->delete();
    // }
}
