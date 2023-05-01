<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\Contracts\IStudentService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    use ApiResponser;

    public function __construct(private readonly IStudentService $studentService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = $this->studentService->getAll();
        return $this->successResponse($students, 200);
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
    public function show($student)
    {
        $student = $this->studentService->getById($student);
        return $this->successResponse($student, 200);
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
    public function destroy($student)
    {
        $studentDeleted = $this->studentService->delete($student);
        return $this->successResponse($studentDeleted, 200);
    }
}
