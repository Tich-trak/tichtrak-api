<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\ProgrammeFormRequest;
use App\Http\Resources\ProgrammeResource;
use App\Http\Services\ProgrammeService;

class ProgrammeController extends BaseController {

    public function __construct(private ProgrammeService $programmeService) {
        $this->middleware('auth');
        $this->middleware('role:SuperAdmin,Admin');
    }


    /**
     * Display a listing of the resource.
     */
    public function index() {
        $data = $this->programmeService->find();
        $programmes = ProgrammeResource::collection($data);

        return $this->jsonResponse($programmes, 'programmes fetched successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProgrammeFormRequest $request) {
        try {
            $payload = $request->validated();
            $programme = $this->programmeService->create($payload);

            return $this->jsonResponse($programme, 'programme created successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $programme = $this->programmeService->findById($id);


        return $this->jsonResponse($programme, 'programme fetched successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProgrammeFormRequest $request, string $id) {
        try {
            $payload = $request->safe()->except('id');

            $programme = $this->programmeService->updateById($id, $payload);

            return $this->jsonResponse($programme, 'programme updated successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $this->programmeService->deleteById($id);

        return $this->jsonResponse(null, 'programme deleted successfully');
    }
}
