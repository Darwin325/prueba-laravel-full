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
        //$this->authorizeResource(Course::class, 'course');
        //$this->middleware('can:viewAny,' . Course::class);
    }

    /**
     * Display a listing of the resource.
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $this->authorize('viewAny', Course::class);
        return $this->successResponse($this->courseService->getAll());
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCourseRequest $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('create', Course::class);
        $request->merge([
            'time' => json_encode($request->time)
        ]);
        $course = $this->courseService->create($request->all());
        return $this->successResponse($course, 201);
    }

    /**
     * Display the specified resource.
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($course): \Illuminate\Http\JsonResponse
    {
        $course = $this->courseService->getById($course);
        $this->authorize('view', $course);
        return $this->successResponse($course);
    }

    /**
     * Update the specified resource in storage.
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCourseRequest $request, Course $course): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', $course);
        if ($request->has('time'))
            $course->time = json_encode($request->time);

        if ($request->has('start_date'))
            $course->start_date = $request->start_date;

        if ($request->has('end_date'))
            $course->end_date = $request->end_date;

        if ($request->has('description'))
            $course->description = $request->description;

        if ($request->has('name'))
            $course->name = $request->name;

        if ($course->isClean())
            return $this->errorResponse('Coloque por lo menos un valor diferente', 422);

        $course = $this->courseService->save($course);
        return $this->successResponse($course);
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Course $course): \Illuminate\Http\JsonResponse
    {
        $this->authorize('delete', $course);//todo check if this is working
        return $this->successResponse($this->courseService->delete($course));
    }
}
