<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\Contracts\IStudentCourseService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class StudentsCourseController extends Controller
{
    use ApiResponser;

    public function __construct(private readonly IStudentCourseService $studentCourseService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index($student)
    {
        $courses = $this->studentCourseService->getAllCoursesByStudent($student);
        return $this->successResponse($courses, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $student)
    {
        $this->studentCourseService->attachCourseToStudent($request, $student);
        $courses = $this->studentCourseService->getAllCoursesByStudent($student);
        return $this->successResponse($courses, 201);
    }

    /**
     * Count top courses by students count in last 6 months
     * @param Student $student
     * @param $old
     * @return \Illuminate\Http\JsonResponse
     */
    public function countTopCourses(Student $student): \Illuminate\Http\JsonResponse
    {
        $courses = $this->studentCourseService->countTopCourses();
        return $this->successResponse($courses, 200);
    }
}
