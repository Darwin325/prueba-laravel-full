<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Student;
use App\Services\Contracts\IStudentService;
use Illuminate\Support\Facades\DB;

class StudentService implements IStudentService
{

    public function getAll()
    {
        $perPage = 15;
        if (\request()->has('per_page')) {
            $perPage = \request()->per_page;
        }
        return Student::query()->paginate($perPage);
    }

    public function getById($id)
    {
        return Course::findOrFail($id);
    }

    public function create(array $attributes)
    {
        return Course::create($attributes);
    }

    public function update($id, array $attributes)
    {
        return Course::find($id)->update($attributes);
    }

    public function delete($id)
    {
        $student = Student::findOrFail($id);
        return DB::transaction(function () use ($student) {
            $student->courses()->detach();
            $student->delete();
            return $student;
        });
    }
}
