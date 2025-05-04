<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role= Role::all();
        return ApiResponse::setData($role);
    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(Request $request)
//    {
//        $role= Role::create([
//           'name'=>$request->name,
//        ]);
//        return ApiResponse::success($role, 'Role created successfully');
//    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return ApiResponse::setData($role);
    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(Request $request, Role $role)
//    {
//
//    }

    /**
     * Remove the specified resource from storage.
     */
//    public function destroy(Role $role)
//    {
//        //
//    }
}
