<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\DepartmentFormRequest;
use App\Http\Resources\DepartmentResource;
use App\Http\Services\DepartmentService;

class DepartmentController extends BaseController {

    public function __construct(private DepartmentService $departmentService) {
        $this->middleware('auth');
        $this->middleware('role:SuperAdmin,Admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $data = $this->departmentService->find();
        $departments = DepartmentResource::collection($data);

        return $this->jsonResponse($departments, 'departments fetched successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentFormRequest $request) {
        try {
            $payload = $request->validated();
            $department = $this->departmentService->create($payload);

            return $this->jsonResponse($department, 'department created successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $department = $this->departmentService->findById($id);


        return $this->jsonResponse($department, 'department fetched successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentFormRequest $request, string $id) {
        try {
            $payload = $request->safe()->except('id');

            $department = $this->departmentService->updateById($id, $payload);

            return $this->jsonResponse($department, 'department updated successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Add courses to departments.
     */
    public function addCourses(DepartmentFormRequest $request, string $id) {
        try {
            $payload = $request->safe()->only('course_ids');

            $department = $this->departmentService->addCourses($id, $payload);

            return $this->jsonResponse($department, 'departmental courses added successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Remove courses from departments.
     */
    public function removeCourses(DepartmentFormRequest $request, string $id) {
        try {
            $payload = $request->safe()->only('course_ids');

            $department = $this->departmentService->removeCourses($id, $payload);

            return $this->jsonResponse($department, 'departmental courses removed successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $this->departmentService->deleteById($id);

        return $this->jsonResponse(null, 'department deleted successfully');
    }
}
