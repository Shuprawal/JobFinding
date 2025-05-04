<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company= Company::all();
        return ApiResponse::success($company, 'List of companies');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request)
    {
        try {
            $company= Company::create([
                'name'=>$request->name,
                'description'=>$request->description,
                'website'=>$request->website
            ]);
        }catch (Exception $e) {
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
        try {
            $company->delete();
            return ApiResponse::success($company, 'Company deleted successfully');
        }catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 400);
        }


    }
}
