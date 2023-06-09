<?php

namespace App\Http\Controllers\api;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    //Create Category
    public function CreateCategory (Request $request){
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string',
            'slug' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Category Fails',
                'errors' => $validator->errors()
            ],422);
        }

        $category = Category::create([
            'category_name' => $request->category_name,
            'slug' => strtolower(str_replace(' ', '-',$request->category_name)),
        ]);

        return response()->json([
            'message'=>'category create success',
            'data'=>$category
        ],200);
    }

    //Get Category
    public function GetCat (Request $request){

        $category[] = Category::all();
        foreach($category as $cat)
        return response()->json([
        'data'=>$cat,
        ],200);

    }
}