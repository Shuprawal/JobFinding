<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

//    public function login(StoreLoginRequest $request)
//    {
//        $login='email';
//        if(User::where('username',$request->input('email'))->exists()){
//            $login='username';
//        }
//
//        $credentials = ([$login => $request->input('email'), 'password' => $request->input('password')]);
//
//        if (!auth()->attempt($credentials)) {
//            return ApiResponse::error('Invalid Credentials', 401);
//        }
//        $success= $request->session()->regenerate();
//
////        $user = $request->user();
////        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
//
//        return ApiResponse::success($success, 'User logged in successfully');
//    }


    public function login(StoreLoginRequest $request)
    {
        $login = 'email';
        if (User::where('username', $request->input('email'))->exists()) {
            $login = 'username';
        }

        $credentials = [$login => $request->input('email'), 'password' => $request->input('password')];

        if (!auth()->attempt($credentials)) {
            return ApiResponse::error('Invalid Credentials', 401);
        }

        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;
//        $request->session()->regenerate();

        return ApiResponse::success([], 'User logged in successfully');
    }
    public function signup(StoreUserRequest $request)
    {

        $input = $request->all();

        $user=$request->user();
        if ($user && $user->role === 'Admin'){
//        if ($request->user()->role->name === 'Admin'){
            $input['role_id']= Role::where('name', 'employee')->first()->id;
        }else{
            $input['role_id']= Role::where('name', 'user')->first()->id;
        }

        $input['password']=bcrypt($input['password']);


        try {
            DB::beginTransaction();

            $user= User::create($input);
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;

            Auth::login($user);
//            $success=$request->session()->regenerate();

            DB::commit();
            return ApiResponse::success($success['token'], 'User created successfully');
//            return ApiResponse::success($user, 'User created successfully');
        }catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage(), 400);


        }


    }



    public function profile()
    {

    }
    public function logout(Request $request)
    {
//        auth()->logout();
//        $request->session()->invalidate();
//        $request->session()->regenerateToken();
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::setMessage('User logged out successfully');
    }

    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {
        $user = User::all();

        return ApiResponse::success($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeEmployee(Request $request)
    {


    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return ApiResponse::success($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {


        }catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return ApiResponse::setMessage('User deleted successfully');
    }
}
