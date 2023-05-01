<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface IStudentCourseService
{
    public function getAllCoursesByStudent(int $id);

    public function attachCourseToStudent(Request $request, int $id);

    public function countTopCourses();
}
