<?php

namespace App\Http\Controllers;

use App\Facades\ApiResponse;
use App\Http\Requests\JobFilterRequest;
use App\Http\Requests\StoreJobRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class JobController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(JobFilterRequest $request)
    {
        $query=Job::query();

        if($request->filled('search')){
            $search=$request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%')
                    ->orWhere('location', 'like', '%'.$search.'%');
            });

        }
        if ($request->filled('category_id')){
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('company_id')){
            $query->where('company_id', $request->company_id);
        }
        if ($request->filled('type')){
            $query->where('type', $request->type);
        }
       if ($request->filled('posted_date')){
           $query->where('created_at','>=', $request->posted_date);
       }
       if ($request->filled('deadline')){
           $query->where('deadline','>=', $request->deadline);
       }
       $jobs=$query->orderBy('created_at', 'desc')-> paginate(10);

        return ApiResponse::success($jobs, 'List of jobs');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobRequest $request)
    {
        $company=Company::where('user_id', auth()->id())->first();
        if($request->category_id == null){
            $categoryName=ucwords(strtolower(trim(preg_replace('/\s+/', ' ', $request->category_name))));;
          if(Category::where('name', $categoryName)->onlyTrashed()->exists()){
              $category=Category::withTrashed()->where('name', $categoryName)->first();
              $category->restore();
          }else{
              $category=Category::firstOrCreate([
                  'name'=>$categoryName
              ]);
          }
            $categoryId=$category->id;
        }else{

            $categoryId=$request->category_id;
        }
       $job = Job::create([
           'title'=>$request->title,
           'description'=>$request->description,
           'location'=>$request->location,
           'salary'=>$request->salary,
           'deadline'=>$request->deadline,
           'type'=>$request->type,
           'category_id'=>$categoryId,
           'company_id'=>$company->id
       ]);
       return ApiResponse::success($job, 'Job created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {

        return ApiResponse::setData($job);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreJobRequest $request, Job $job)
    {
        $this->authorize('update', $job);

        $company=Company::where('user_id', auth()->id())->first();
        $job->update([

            'title'=>$request->title,
            'description'=>$request->description,
            'location'=>$request->location,
            'salary'=>$request->salary,
            'deadline'=>$request->deadline,
            'type'=>$request->type,
            'category_id'=>$request->category_id,
            'company_id'=>$company->id
        ]);

        return ApiResponse::success($job, 'Job updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);
        $job->delete();
        return ApiResponse::success($job, 'Job deleted successfully');
    }

    public function changeStatus(Job $job){
        $this->authorize('toggle', $job);
        if ($job->status == 'enabled'){
            $job->update([
                'status'=>'disabled'
            ]);
        }else{
            $job->update([
                'status'=>'enabled'
            ]);
        }
        return ApiResponse::success($job, 'Job status changed successfully');
    }

    public function featured( Job $job){
        $this->authorize('toggle', $job);
        if ($job->featured =='yes'){
            $job->update([
                'featured'=>'no'
            ]);
        }else{
            $job->update([
                'featured'=>'yes'
            ]);
        }
        return ApiResponse::success($job, 'Job status changed successfully');

    }

    public function changeType(StoreJobRequest $request, Job $job)
    {
        $this->authorize('update', $job);
        $job->update([
           'type'=>$request->type
        ]);
        return ApiResponse::success($job, 'Job status changed successfully');

    }
}
