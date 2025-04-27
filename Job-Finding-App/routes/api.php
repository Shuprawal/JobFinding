<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyController;
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

Route::get('jobs',[JobController::class,'index']);

Route::get('categories',[CategoryController::class,'index']);

Route::post('categories/store',[CategoryController::class,'store']);

Route::post('jobs/store',[JobController::class,'store']);

Route::post('companies/store',[CompanyController::class,'store']);
