<?php

namespace App\Repositories;

use App\Models\Course;
use App\Repositories\Contracts\ICourseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CourseRepository implements ICourseRepository
{
    public function __construct(protected Course $course)
    {
    }

    public function getAll(): Collection
    {
        return $this->course->all();
    }

    public function getById(int $id): ?Course
    {
        return $this->course->findOrFail($id);
    }

    public function create(array $attributes): ?Course
    {
        return $this->course->create($attributes);
    }

    public function update(int $id, array $attributes): ?Course
    {
        $course = $this->course->findOrFail($id);
        $course->update($attributes);
        return $course;
    }

    public function delete(Course $course): ?Course
    {
        return DB::transaction(function () use ($course) {
            $course->students()->detach();
            $course->delete();
            return $course;
        });
    }

    public function save(?Course $course): ?Course
    {
        $course->save();
        return $course;
    }
}
