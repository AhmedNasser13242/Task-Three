<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserSubCategory;
use Illuminate\Support\Facades\Validator;

class UserSubCategoryController extends Controller
{
    public function CreateUserSubCategory (Request $request){
        $validator = Validator::make($request->all(), [
            'user_subcategory_name' => 'required|string',
            'user_id' => 'required|string',
            'user_subcategory_slug' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'User SubCategory Fails',
                'errors' => $validator->errors()
            ],422);
        }

        $user_subcategory = UserSubCategory::create([
            'user_subcategory_name' => $request->user_subcategory_name,
            'user_id' => $request->user_id,
            'user_subcategory_slug' => strtolower(str_replace(' ', '-',$request->user_subcategory_name)),
        ]);


        return response()->json([
            'message'=>'User SubCategory create success',
            'data'=>[
            'User Subcategory Name' => $user_subcategory->user_subcategory_name,
            'User Subcategory Slug'=> $user_subcategory->user_subcategory_slug,
            'User id'=> $user_subcategory->user_id,

            ]
        ],200);
    }

    public function GetSubCat (Request $request){


        $user_sub_categories[] = UserSubCategory::all();
        foreach($user_sub_categories as $user_sub_cat)
        return response()->json([
            'data'=>$user_sub_cat
        ],200);
    }
}