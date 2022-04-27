<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(){
        try {
            $categorys=Category::orderBy('id','desc')->get();
            if ($categorys) {
                return response()->json([
                    'success'=>true,
                    'category'=> $categorys
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'error'=>$e->getMessage()
            ]);
        }
    }

    public function store(Request $req) {
        try {
            $validation=Validator::make($req->all(),[
                'category_name'=>['required','min:10','max:20','string','unique:categories']
            ]);
            if ($validation->fails()) {
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all()
                ]);
            }else {
                $result=Category::create([
                    'category_name'=>$req->category_name
                ]);
                if ($result) {
                    return response()->json([
                        'success'=>true,
                        'message'=>"Category Added Succesfully"
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
            $categorys=Category::find($id);
            if ($categorys) {
                return response()->json([
                    'success'=>true,
                    'message'=>$categorys
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'message'=>$e->getMessage()
            ]);
        }
    }
    
    public function update(Request $request,$id){
        try {
            $categorys=Category::findOrFail($id);
            $validation = Validator::make($request->all(),[
                'category_name'=>['required','min:10','max:20','string','unique:categories']
            ]);
            if ($validation->fails()) {
                return response()->json([
                    'success'=>false,
                    'message'=>$validation->errors()->all()
                ]);
            }else {
                $categorys->category_name=$request->category_name;
                $result=$categorys->save();
                if ($result) {
                    return response()->json([
                        'success'=>true,
                        'message'=>"Category Updated Successfully"
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
            $categorys=Category::findOrFail($id)->delete();
            if ($categorys) {
                return response()->json([
                    'success'=>true,
                    'message'=>"Category Deleted Successfully"
                ]);
            }else {
                return response()->json([
                    'success'=>false,
                    'message'=>"Some Problem Occured"
                ]);
            }
        } catch (Exception $exp) {
            return response()->json([
                'success'=>false,
                'message'=>$exp->getMessage()
            ]);
        }
    }

    public function search($search){
        try {
            $categorys=Category::where('category_name','LIKE','%'.$search.'%')->orderBy('id','desc')->get();
            if ($categorys) {
                return response()->json([
                    'success'=>true,
                    'category'=> $categorys
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
