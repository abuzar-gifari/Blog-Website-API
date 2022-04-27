<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscribeController extends Controller
{
    public function getSubs(){
        try {
            $subscribers=Subscribe::get();
            return response()->json([
                'success'=>true,
                'subscriber'=>$subscribers,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'exception'=>"some problem occur"
            ]);
        }
    }
}
