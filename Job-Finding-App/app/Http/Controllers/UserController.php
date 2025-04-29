<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function login(StoreLoginRequest $request)
    {


        $login='email';
        if(User::where('username',$request->input('email'))->exists()){
            $login='username';
        }


        $credentials = ([$login => $request->input('email'), 'password' => $request->input('password')]);
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message'=>'Invalid Credentials',
            ]);
        }
        $user = $request->user();
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        return ['success' => ['token' => $success['token']]];


    }
    public function signup(StoreUserRequest $request)
    {

        $input = $request->all();
        $input['password']=bcrypt($input['password']);
        try {
            DB::beginTransaction();

            $user= User::create($input);
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;

            DB::commit();
            return ['success' => ['token' => $success['token']]];
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message'=>$e->getMessage(),
            ]);

        }

//        return response()->json([
//            'message'=>'User created successfully',
//            'success'=>$success,
//            'user'=>$user
//        ]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
