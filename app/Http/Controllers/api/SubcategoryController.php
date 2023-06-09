<?php

namespace App\Http\Controllers\api;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{
    public function CreateSubCategory (Request $request){
        $validator = Validator::make($request->all(), [
            'subcategory_name' => 'required|string',
            'subcategory_slug' => 'required|string',
            'category_id' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'SubCategory Fails',
                'errors' => $validator->errors()
            ],422);
        }
        $subcategory = SubCategory::create([
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-',$request->subcategory_name)),
            'category_id' => $request->category_id,
        ]);
        return response()->json([
            'message'=>'subcategory create success',
            'data'=>[
                'category'=>$subcategory['category']['category_name'],
                'subcategory_name'=>$subcategory->subcategory_name,
                'subcategory_slug'=>$subcategory->subcategory_slug,
            ]
        ],200);
    }
    public function GetSub (Request $request){


        $sub_categories[] = SubCategory::all();
        foreach($sub_categories as $sub_category)
        return response()->json([
            'data'=>$sub_category
        ],200);
    }
}