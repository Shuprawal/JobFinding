<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

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
        $data =[$user->role->name ,$token];
        return ApiResponse::success($data,
             'User logged in successfully');
    }
    public function signup(StoreUserRequest $request)
    {

        $input = $request->all();


        $input['role_id']= Role::where('name', 'user')->first()->id;


        $input['password']=bcrypt($input['password']);


        try {
            DB::beginTransaction();

            $user= User::create($input);
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;

//            $user->sendEmailVerificationNotification();
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

        $user = auth()->user();
        return ApiResponse::success($user, 'User profile');
    }


    public function logout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return ApiResponse::error('not logged in', 401);
        }
        $token = $user->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            $token->delete();

            return response()->json([
                'message' => 'Logged out successfully'
            ]);
        }

        return response()->json([
            'message' => 'Session user logged out successfully.'
        ]);
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

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return ApiResponse::success($user);
    }

    public function notifications()
    {
        $user = auth()->user();
        return ApiResponse::success($user->notifications, 'List of notifications');
    }


    /**
     * Update the specified resource in storage.
     */
//    public function update(Request $request, User $user)
//    {
//        try {
//
//
//        }catch (\Exception $e) {
//            return ApiResponse::error($e->getMessage(), 400);
//        }
//    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return ApiResponse::setMessage('User deleted successfully');
    }
}
