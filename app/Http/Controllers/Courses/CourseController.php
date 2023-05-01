<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Services\CourseService;
use App\Traits\ApiResponser;

class CourseController extends Controller
{
    use ApiResponser;

    public function __construct(protected CourseService $courseService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->successResponse($this->courseService->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $request->merge([
            'time' => json_encode($request->time)
        ]);
        $course = $this->courseService->create($request->all());
        return $this->successResponse($course, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($course)
    {
        return $this->successResponse($this->courseService->getById($course));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
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
        $course = $this->courseService->save($course);
        return $this->successResponse($course);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->successResponse($this->courseService->delete($id));
    }
}
