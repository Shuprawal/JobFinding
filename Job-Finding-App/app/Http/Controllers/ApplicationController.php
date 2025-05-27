<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\ApplicationFilterRequest;
use App\Http\Requests\ApplicationStatusChange;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ApplicationController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(ApplicationFilterRequest $request)
    {

//        $this->authorize('viewAny', Application::class);

        $jobId = $request->input('jobId');

        $applications = Application::with('job', 'user')
            ->when($jobId, fn ($query) => $query->where('job_id', $jobId))
            ->latest()
            ->paginate(10);
        return ApiResponse::success($applications, 'List of applications');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
//        $this->authorize('create', Application::class);
        $this->authorize('create', [Application::class, $request->job_id]);
        $user=Auth::user();
        try {
            DB::beginTransaction();
            $resumePath=$request->file('resume')->store('application/resumes', 'public');
            $coverLetterPath=$request->file('cover_letter')->store('application/cover_letters', 'public');

            $application = Application::create([
               'user_id'=>$user->id,
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
        $this->authorize('view', $application);

        return ApiResponse::success($application, 'Application Found');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        $this->authorize('update', $application);

        try {
            DB::beginTransaction();

            if ($request->hasFile('resume')) {
                $resumePath = $request->file('resume')->store('application/resumes', 'public');
                $application->resume = $resumePath;
            }

            if ($request->hasFile('cover_letter')) {
                $coverLetterPath = $request->file('cover_letter')->store('application/cover_letters', 'public');
                $application->cover_letter = $coverLetterPath;
            }

            if ($request->filled('status')) {
                $application->status = $request->status;
            }

            $application->save();
            DB::commit();

            return ApiResponse::success($application, 'Application updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error($e->getMessage(), 'Failed to update application', 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $this->authorize('delete', $application);
        $application->delete();
        return ApiResponse::success($application, 'Application deleted successfully');
    }

    public function changeStatus(Application $application , ApplicationStatusChange $request)
    {
        $this->authorize('toggle', $application);
        $application->update([
            'status'=>$request->status,
        ]);

        return ApiResponse::success($application, 'Application status changed successfully');
    }


}
