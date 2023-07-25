<?php

namespace App\Http\Controllers;

use App\Models\Institution;
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
        $institutions = $this->institutionService->paginate();

        return $this->jsonResponse(
            InstitutionResource::collection($institutions),
            'institution fetched successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstitutionFormRequest $request) {
        try {
            $payload = $request->validated();
            $institution = $this->institutionService->create($payload);

            return $this->jsonResponse($institution, 'Successfully Created Institution');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Institution $institution) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InstitutionFormRequest $request, Institution $institution) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institution $institution) {
        //
    }
}