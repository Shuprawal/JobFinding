<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jobId = $request->input('jobId');

        $applications = Application::when($jobId, function ($query) use ($jobId) {
            return $query->where('job_id', $jobId);
        })->get();
        return ApiResponse::success($applications, 'List of applications');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
        try {
            DB::beginTransaction();
            $resumePath=$request->file('resume')->store('application/resumes', 'public');
            $coverLetterPath=$request->file('cover_letter')->store('application/cover_letters', 'public');

            $application = Application::create([
//               'user_id'=>$request->user_id,
               'user_id'=>auth()->id(),
               'job_id'=>$request->job_id,
               'resume'=>$resumePath,
               'cover_letter'=>$coverLetterPath,
               'status'=>'pending',
            ]);

            DB::commit();
            return ApiResponse::success($application,'Application sent successfully');
        }catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage(),'Error occured', 400);
        }




    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        $user=auth()->user();

        if (!$user) {
            return ApiResponse::error('Unauthenticated', 401);
        }

        if ($user->getRole() === 'User') {
            return ApiResponse::success('logged in user');
        }
            return ApiResponse::success($user,'not logged in user');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
    }
}
