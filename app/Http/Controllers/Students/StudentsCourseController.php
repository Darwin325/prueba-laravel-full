<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentsCourseController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     */
    public function index(Student $student)
    {
        try {
            return $this->successResponse($student->courses, 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Courses not retrieved', 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Student $student)
    {
        $request->validate([
            'course_id' => 'required|numeric|min:1|exists:courses,id|unique:course_student,course_id',
        ]);

        try {
            $request->merge([
                'student_id' => $student->id,
            ]);
            $student->courses()->attach($request->course_id);
            return $this->successResponse($student->courses, 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Course not added', 404);
        }
    }

    /**
     * Count top courses by students count in last 6 months
     * @param Student $student
     * @param $old
     * @return \Illuminate\Http\JsonResponse
     */
    public function countTopCourses(Student $student): \Illuminate\Http\JsonResponse
    {
        $old = Carbon::now()->subMonths(6);
        $limit = 3;
        Log::info('old: ' . $old . ' limit: ' . $limit);
        if (\request()->has('old')) {
            $old = \request('old');
        }
        if (\request()->has('limit')) {
            $limit = \request('limit');
            Log::info('limit: ' . $limit);
        }

        try {
            $courses = Course::query()
                ->select('courses.*')
                ->selectRaw(
                    "(select count(*) from course_student where courses.id = course_student.course_id and created_at > '$old')
                    as students_count"
                )
                ->orderBy('students_count', 'desc')
                ->limit($limit)
                ->get();
            return $this->successResponse($courses, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }
}
