<?php

namespace App\Providers;

use App\Repositories\Contracts\ICourseRepository;
use App\Repositories\CourseRepository;
use App\Services\Contracts\IStudentCourseService;
use App\Services\Contracts\IStudentService;
use App\Services\StudentCourseService;
use App\Services\StudentService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public $bindings = [
        ICourseRepository::class => CourseRepository::class,
        IStudentService::class => StudentService::class,
        IStudentCourseService::class => StudentCourseService::class,
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
