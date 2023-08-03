<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Services\FacultyService;
use App\Http\Requests\FacultyFormRequest;
use App\Http\Resources\FacultyResource;

class FacultyController extends BaseController {

    public function __construct(private FacultyService $facultyService) {
        $this->middleware('auth');
        $this->middleware('role:SuperAdmin,Admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $data = $this->facultyService->find();
        $faculties = FacultyResource::collection($data);

        return $this->jsonResponse($faculties, 'faculties fetched successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FacultyFormRequest $request) {
        try {
            $payload = $request->validated();
            $faculty = $this->facultyService->create($payload);

            return $this->jsonResponse($faculty, 'faculty created successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $faculty = $this->facultyService->findById($id);

        return $this->jsonResponse($faculty, 'faculty fetched successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FacultyFormRequest $request, string $id) {
        try {
            $payload = $request->safe()->except('id');

            $faculty = $this->facultyService->updateById($id, $payload);

            return $this->jsonResponse($faculty, 'faculty updated successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $this->facultyService->deleteById($id);

        return $this->jsonResponse(null, 'faculty deleted successfully');
    }
}
