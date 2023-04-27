<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentsController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 20;
        if (\request()->has('per_page')){
            $perPage = \request()->per_page;
        }
        try {
            $students = Student::query()->paginate($perPage);
            return $this->successResponse($students, 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Students not retrieved', 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        try {
            return $this->successResponse($student, 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Student not retrieved', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        try {
            $studentDeleted = DB::transaction(function () use ($student) {
                $student->courses()->detach();
                $student->delete();
                return $student;
            });
            return $this->successResponse($studentDeleted, 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Student not deleted', 404);
        }
    }
}
