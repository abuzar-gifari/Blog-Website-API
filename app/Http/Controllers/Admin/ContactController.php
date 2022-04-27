<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getContacts(){
        try {
            $contacts=Contact::orderBy('id','desc')->get();
            return response()->json([
                'success'=>true,
                'contacts'=>$contacts
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'contacts'=>$e->getMessage(),
            ]);
        }
    }
}
