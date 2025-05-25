<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class CompanyController extends Controller
{
   use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company= Company::all();
//        $company= Auth::user()->getRole();
        return ApiResponse::success($company, 'List of companies');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request)
    {

        try {
            DB::beginTransaction();
            $role=Role::where('name', 'Company')->first();
            $name=$request->name;
            $user=User::create([
                'first_name'=>$name,
                'last_name'=>$name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'password'=>bcrypt($request->password),
                'username'=>$name,
                'role_id'=>$role->id,

            ]);
            $company= Company::create([
                'user_id'=>$user->id,
                'name'=>$name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'description'=>$request->description,
                'website'=>$request->website
            ]);

            DB::commit();
        }catch (Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage(), 400);
        }
        return ApiResponse::success($company, 'Company created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return ApiResponse::setData($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyStoreRequest $request, Company $company)
    {
        $this->authorize('update', $company);

        $company->update([
            'name'=> $request->name,
            'description'=>$request->description,
            'website'=>$request->website
        ]);

        return ApiResponse::success($company, 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);
        try {
            $company->delete();
            return ApiResponse::success($company, 'Company deleted successfully');
        }catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }


    }
}
