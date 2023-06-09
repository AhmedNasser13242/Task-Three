<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\SubcategoryController;
use App\Http\Controllers\api\UserSubCategoryController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Authintcation
Route::controller(AuthController::class)->group(function(){
    Route::post('/auth/register',  'register');
    Route::post('/auth/login',  'login');
    Route::post('/auth/logout',  'logout');
    Route::get('/all/users',  'GetUser');
});

Route::controller(CategoryController::class)->group(function(){
Route::post('create/category','CreateCategory');
Route::get('all/category','GetCat');
});

Route::controller(SubcategoryController::class)->group(function(){
    Route::post('create/subcategory','CreateSubCategory');
    Route::get('all/subcategory','GetSub');
});
Route::controller(UserSubCategoryController::class)->group(function(){
    Route::post('create/user_sub_cat','CreateUserSubCategory');
    Route::get('all/user_sub_cat','GetSubCat');
});