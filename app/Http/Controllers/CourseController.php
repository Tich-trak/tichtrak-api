<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseFormRequest;
use App\Http\Resources\CourseResource;
use App\Http\Services\CourseService;
use Exception;

class CourseController extends BaseController {
    public function __construct(private CourseService $courseService) {
        $this->middleware('auth');
        $this->middleware('role:SuperAdmin,Admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $data = $this->courseService->find();
        $courses = CourseResource::collection($data);

        return $this->jsonResponse($courses, 'courses fetched successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseFormRequest $request) {
        try {
            $payload = $request->validated();
            $course = $this->courseService->create($payload);

            return $this->jsonResponse($course, 'course created successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $course = $this->courseService->findById($id);


        return $this->jsonResponse($course, 'course fetched successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseFormRequest $request, string $id) {
        try {
            $payload = $request->safe()->except('id');

            $course = $this->courseService->updateById($id, $payload);

            return $this->jsonResponse($course, 'course updated successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $this->courseService->deleteById($id);

        return $this->jsonResponse(null, 'course deleted successfully');
    }
}
