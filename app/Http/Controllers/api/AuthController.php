<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\UserSubCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'user' => $user,
                'authorization' => [
                    'token' => $user->createToken('ApiToken')->plainTextToken,
                    'type' => 'bearer',
                ]
            ]);
        }
        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }
    //Register
    public function register (Request $request){
        $validator = Validator::make($request->all(), [
            'category_id' => 'max:255',
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:255',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Register Fails',
                'errors' => $validator->errors()
            ],422);
        }
        $user = User::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($user->category_id == null){
            return response()->json([
                'message'=>'register success',
                'data'=>[
                    'Name' => $user->name,
                    'Email'=> $user->email,
                    ]
            ],200);
        }else{
            return response()->json([
                'message'=>'register success',
                'data'=>[
                    'Category Name'=>$user['category']['category_name'],
                    'Name' => $user->name,
                    'Email'=> $user->email,
                    ]
            ],200);
        }


    }

    //Logout
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }


    //Get User data
    public function GetUser(Request $request){
        $user = User::where('id', $request->id)->get();
        foreach ($user as $object)
        $user_cat =  DB::table('categories')->select('category_name')->where('id', $object->category_id)->get();
        $user_subcategory[] = DB::table('user_sub_categories')->select('user_subcategory_name')->where('user_id', $object->id)->get();
        foreach ($user_cat as $user_c)
        foreach ($user_subcategory as $user_sub)
        return response()->json([
            'data'=>[
                'User Id'=>$object->id,
                'Category Name'=>$user_c,
                'User Name'=>$object->name,
                'User Email'=>$object->email,
                'User SubCategory' => [
                    $user_sub
                    ]
        ]
        ],200);

    }
}