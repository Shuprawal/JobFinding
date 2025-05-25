<?php
//
//namespace App\Providers;
//
//use App\Models\Job;
//use App\Policies\JobPolicy;
//use Illuminate\Support\Facades\Gate;
//use Illuminate\Support\ServiceProvider;
//
//class AuthServiceProvider extends ServiceProvider
//{
//    protected $policies = [
//        Job::class => JobPolicy::class,
//    ];
//    /**
//     * Register services.
//     */
//    public function register(): void
//    {
//        $this->registerPolicies();
//    }
//
//    /**
//     * Bootstrap services.
//     */
//    public function boot(): void
//    {
//        //
//    }
//}



namespace App\Providers;

use App\Models\Application;
use App\Models\Company;
use App\Models\Job;
use App\Policies\ApplicationPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\JobPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider; // ✅ This is the correct base class

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Job::class => JobPolicy::class,
        Company::class => CompanyPolicy::class,
        Application::class => ApplicationPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}

