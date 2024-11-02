<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use App\Models\StudentRequest;
use App\Observers\StudentRequestObserver;
use App\Models\SubmissionForm;
use App\Policies\SubmissionFormPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        SubmissionForm::class => SubmissionFormPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->registerPolicies();

        StudentRequest::observe(StudentRequestObserver::class);
    }
}
