<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\CompanyStoreRequest;
use App\Models\Company;
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

        $company= Company::create([
           'name'=>$request->name,
           'description'=>$request->description,
            'website'=>$request->website
        ]);

        return response()->json([
            'message'=>'Company created successfully',
            'company'=>$company
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return response()->json([
            'company'=>$company
        ]);
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
//        return response()->json([
//            'message'=>'Company updated successfully',
//            'company'=>$company
//        ]);
        return ApiResponse::success($company, 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json([
            'message'=>'Company deleted successfully'
        ]);
    }
}
