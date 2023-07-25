<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstitutionFormRequest;
use App\Http\Resources\InstitutionResource;
use App\Http\Services\InstitutionService;
use Exception;

class InstitutionController extends BaseController {


    public function __construct(private InstitutionService $institutionService) {
        // $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     */
    public function index() {
        $data = $this->institutionService->find();
        $institutions = InstitutionResource::collection($data);

        return $this->jsonResponse($institutions, 'institution fetched successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstitutionFormRequest $request) {
        try {
            $payload = $request->validated();
            $institution = $this->institutionService->create($payload);

            return $this->jsonResponse($institution, 'institution created successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $institution = $this->institutionService->findById($id);

        return $this->jsonResponse($institution, 'institution fetched successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InstitutionFormRequest $request, string $id) {
        try {
            $payload = $request->safe()->except('id');

            $institution = $this->institutionService->updateById($id, $payload);

            return $this->jsonResponse($institution, 'institution updated successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $this->institutionService->deleteById($id);

        return $this->jsonResponse(null, 'institution deleted successfully');
    }
}
