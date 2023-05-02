<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Student;
use App\Services\Contracts\IStudentCourseService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentCourseService implements IStudentCourseService
{
    public function getAllCoursesByStudent(int $id)
    {
        return Student::with('courses')->findOrFail($id);
    }

    public function attachCourseToStudent(Request $request, int $id)
    {
        $student = Student::findOrFail($id);
        $request->validate(['course_id' => 'required|numeric|min:1|exists:courses,id']);
        $request->merge(['user_id' => $student->id]);
        $idCourses = $student->courses()->pluck('course_id')->toArray();
        $idCourses[] = $request->course_id;
        $student->courses()->sync($idCourses);
        return $student;
    }

    public function countTopCourses()
    {
        $old = Carbon::now()->subMonths(6);
        $limit = 3;
        if (\request()->has('old_date')) $old = \request('old_date');
        if (\request()->has('limit')) $limit = \request('limit');

        return Course::query()
            ->select('courses.*')
            ->selectRaw(
                "(select count(*) from course_user where courses.id = course_user.course_id and created_at > '$old')
                    as students_count"
            )
            ->orderBy('students_count', 'desc')
            ->limit($limit)
            ->get();
    }
}
