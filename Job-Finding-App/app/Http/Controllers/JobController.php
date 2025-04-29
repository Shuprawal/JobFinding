<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobRequest;
use App\Models\Category;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $jobs=Job::where('title','LIKE', "%$search%")
            ->orWhere('description','LIKE', "%$search%")
            ->orWhere('location','LIKE', "%$search%")
            ->orWhere('salary','LIKE', "%$search%")
//            ->whereHas('categories', function ($query) use ($search) {
//                $query->where('name', 'LIKE', "%$search%");
//            })
            ->get();
        return response()->json(
            $jobs
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request)
    {
       $job = Job::create([
           'title'=>$request->title,
           'user_id'=>$request->user_id,
           'description'=>$request->description,
           'location'=>$request->location,
           'salary'=>$request->salary,
           'deadline'=>$request->deadline,
           'status'=>$request->status,
           'featured'=>$request->featured,
           'type'=>$request->type,
           'category_id'=>$request->category_id,
           'company_id'=>$request->company_id
       ]);
       return response()->json([
           'message'=>'Job created successfully',
           'job'=>$job
       ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return response()->json([
            'job'=>$job,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreJobRequest $request, Job $job)
    {
        $job->update([
            'title'=>$request->title,
            'user_id'=>$request->user_id,
            'description'=>$request->description,
            'location'=>$request->location,
            'salary'=>$request->salary,
            'deadline'=>$request->deadline,
            'status'=>$request->status,
            'featured'=>$request->featured,
            'type'=>$request->type,
            'category_id'=>$request->category_id,
            'company_id'=>$request->company_id
        ]);
        return response()->json([
            'message'=>'Job created successfully',
            'job'=>$job
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();
        return response()->json([
            'message'=>'Job deleted successfully'
        ]);
    }
}
