<?php
//
//use App\Http\Controllers\ProfileController;
//use Illuminate\Foundation\Application;
//use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\CategoryController;
//use App\Http\Controllers\JobController;
//use App\Http\Controllers\CompanyController;
//use Inertia\Inertia;
//
//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});
//
//Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});
//
//Route::get('/test', function () {
//    return response()->json('aaa');
//});
//
//Route::get('/test2', function () {
//    return response()->json('bbb');
//});
//
//Route::get('jobs',[JobController::class,'index']);
//
//Route::get('categories',[CategoryController::class,'index']);
//
//Route::post('categories/store',[CategoryController::class,'store']);
//
//Route::post('jobs/store',[JobController::class,'store']);
//
//Route::post('companies/store',[CompanyController::class,'store']);
//
//Route::get('categories/{category}',[CategoryController::class,'show']);
//
//Route::put('categories/{category}',[CategoryController::class,'update']);
//
//
//require __DIR__.'/auth.php';
