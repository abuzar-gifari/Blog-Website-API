<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Exception;

class ContactController extends Controller
{
    public function store(Request $req) {
        try {
            $validation=Validator::make($req->all(),[
                'name'=> ['required'],
                'email'=> ['required'],
                'subject'=> ['required'],
                'message'=> ['required']
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all()
                ]);
            }else {
                $result=Contact::create([
                    'name'=> $req->name,
                    'email'=> $req->email,
                    'subject'=> $req->subject,
                    'message'=> $req->message,
                ]);
                if ($result) {
                    return response()->json([
                        'success'=>true,
                        'message'=>"Contact Created Succesfully"
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
}
