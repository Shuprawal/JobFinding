<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum','admin'])->group(function () {

    Route::post('companies/store',[CompanyController::class,'store']);
});


Route::middleware(['auth:sanctum','admin_or_company'])->group(function () {
    Route::get('companies',[CompanyController::class,'index']);

    Route::get('companies/{company}',[CompanyController::class,'show']);
    Route::delete('companies/{company}',[CompanyController::class,'destroy']);
    Route::put('companies/{company}',[CompanyController::class,'update']);


    Route::post('categories/store',[CategoryController::class,'store']);
    Route::delete('categories/{category}',[CategoryController::class,'destroy']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);

});


Route::get('categories',[CategoryController::class,'index']);
Route::get('categories/{category}',[CategoryController::class,'show']);


Route::get('users',[UserController::class,'index']);


Route::middleware(['auth:sanctum','company'])->group(function () {
    Route::get('jobs',[JobController::class,'index']);
    Route::post('jobs/store',[JobController::class,'store']);
    Route::get('jobs/{job}',[JobController::class,'show']);
    Route::put('jobs/{job}',[JobController::class,'update']);
    Route::delete('jobs/{job}',[JobController::class,'destroy']);
    Route::patch('jobs/{job}/status',[JobController::class,'changeStatus'])->name('job.changeStatus');
    Route::patch('jobs/{job}/featured',[JobController::class,'featured'])->name('job.featured');
    Route::patch('jobs/{job}/type',[JobController::class,'changeType'])->name('job.type');
    Route::get('jobs/{job}/selectedApplications',[JobController::class,'selectedApplications'])->name('job.applications');
    Route::get('jobs/{job}/unselectedApplications',[JobController::class,'unselectedApplications'])->name('job.unselectedApplications');
    Route::patch('applications/{application}',[ApplicationController::class,'changeStatus'])->name('application.changeStatus');
});



Route::middleware('auth:sanctum')->group(function () {
//    Route::get('applications', [ApplicationController::class, 'index']);
    Route::get('profile', [UserController::class, 'profile']);
    Route::post('applications/store', [ApplicationController::class, 'store']);
    Route::get('applications',[ApplicationController::class,'index']);
    Route::get('applications/{application}',[ApplicationController::class,'show']);
    Route::post('logout',[UserController::class,'logout']);


//    Route::get('applications/{application}/accept',[ApplicationController::class,'accept']);
});


//Route::post('applications/store',[ApplicationController::class,'store'])->middleware('auth:web');

//Route::middleware(['web', 'auth:web'])->group(function () {

//});



Route::middleware('logged_out')->group(function () {
//Route::middleware(['auth:sanctum','logged_out'])->group(function () {
    Route::post('signup',[UserController::class,'signup']);
    Route::post('login',[UserController::class,'login'])->name('login');
});



//Route::fallback(function () {
//    return response()->json('Not Found', 404);
//});
