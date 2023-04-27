<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CourseController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $courses = Course::all();
            return $this->successResponse($courses);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        try {
            $request->merge([
                'time' => json_encode($request->time)
            ]);
            $course = Course::query()->create($request->all());
            return $this->successResponse($course, 201);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        try {
            return $this->successResponse($course);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        try {
            if ($request->has('time')) {
                $course->time = json_encode($request->time);
            }
            if ($request->has('start_date')) {
                $course->start_date = $request->start_date;
            }
            if ($request->has('end_date')) {
                $course->end_date = $request->end_date;
            }
            if ($request->has('description')) {
                $course->description = $request->description;
            }
            if ($request->has('name')) {
                $course->name = $request->name;
            }
            if ($course->isClean()) {
                return $this->errorResponse('Coloque por lo menos un valor diferente', 422);
            }
            $course->save();
            return $this->successResponse($course);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            $course = DB::transaction(function () use ($course) {
                $course->students()->detach();
                $course->delete();
                return $course;
            });
            return $this->successResponse($course);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }
}
