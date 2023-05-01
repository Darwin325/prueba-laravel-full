<?php

namespace App\Providers;

use App\Repositories\Contracts\ICourseRepository;
use App\Repositories\CourseRepository;
use App\Services\Contracts\IStudentCourseService;
use App\Services\Contracts\IStudentService;
use App\Services\Contracts\IUserService;
use App\Services\StudentCourseService;
use App\Services\StudentService;
use App\Services\UserService;
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
        IUserService::class => UserService::class
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
