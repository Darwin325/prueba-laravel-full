<?php

namespace App\Services;

use App\Models\Course;
use App\Repositories\Contracts\ICourseRepository;
use Illuminate\Support\Collection;

class CourseService
{
    public function __construct(protected ICourseRepository $courseRepository)
    {
    }

    public function getById(int $id): ?Course
    {
        return $this->courseRepository->getById($id);
    }

    public function getAll(): Collection
    {
        return $this->courseRepository->getAll();
    }

    public function create(array $attributes): ?Course
    {
        return $this->courseRepository->create($attributes);
    }

    public function update(int $id, array $attributes)
    {
        return $this->courseRepository->update($id, $attributes);
    }

    public function delete(int $id)
    {
        return $this->courseRepository->delete($id);
    }

    public function save(?Course $course): ?Course
    {
        return $this->courseRepository->save($course);
    }
}
