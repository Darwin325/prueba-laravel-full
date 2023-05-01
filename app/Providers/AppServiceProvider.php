<?php

namespace App\Providers;

use App\Repositories\Contracts\ICourseRepository;
use App\Repositories\CourseRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public $bindings = [
        ICourseRepository::class => CourseRepository::class,
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
