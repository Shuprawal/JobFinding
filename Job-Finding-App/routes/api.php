<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json('aaa');
});

Route::get('/test2', function () {
    return response()->json('bbb');
});


//Route::middleware('auth:sanctum'), function (Request $request) {
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('companies',[CompanyController::class,'index']);
    Route::post('companies/store',[CompanyController::class,'store']);
    Route::get('companies/{company}',[CompanyController::class,'show']);
    Route::delete('companies/{company}',[CompanyController::class,'destroy']);
    Route::put('companies/{company}',[CompanyController::class,'update']);
});

//});
Route::get('categories',[CategoryController::class,'index']);
Route::post('categories/store',[CategoryController::class,'store']);
Route::get('categories/{category}',[CategoryController::class,'show']);
Route::delete('categories/{category}',[CategoryController::class,'destroy']);
Route::put('categories/{category}',[CategoryController::class,'update']);


Route::get('jobs',[JobController::class,'index']);
Route::post('jobs/{job}',[JobController::class,'store']);
Route::get('jobs/{job}',[JobController::class,'show']);
Route::put('jobs/{job}',[JobController::class,'update']);
Route::delete('jobs/{job}',[JobController::class,'destroy']);

Route::post('signup',[UserController::class,'signup']);
Route::post('login',[UserController::class,'login']);


Route::fallback(function () {
    return response()->json('Not Found', 404);
});
