<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category= Category::all();
        return ApiResponse::success($category, 'List of categories');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category=Category::create([
            'name'=>$request->name
        ]);

        return ApiResponse::success($category, 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
//        return response()->json([
//            'category'=>$category
//        ]);
        return ApiResponse::success($category, 'Category Found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {

        $category->update([
           'name'=>$request->name,
        ]);

        return ApiResponse::success($category, 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return ApiResponse::success($category, 'Category deleted successfully');
    }
}
