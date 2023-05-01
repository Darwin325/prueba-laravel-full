<?php

namespace App\Repositories\Contracts;

use App\Models\Course;
use Illuminate\Support\Collection;

interface ICourseRepository
{
    public function getAll(): Collection;

    public function getById(int $id): ?Course;

    public function create(array $attributes): ?Course;

    public function update(int $id, array $attributes): ?Course;

    public function delete(int $id): ?Course;

    public function save(?Course $course): ?Course;
}
