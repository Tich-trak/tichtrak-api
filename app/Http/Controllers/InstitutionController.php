<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use App\Http\Requests\InstitutionFormRequest;
use App\Http\Resources\InstitutionResource;
use App\Http\Services\InstitutionService;

class InstitutionController extends BaseController {


    public function __construct(private InstitutionService $institutionService) {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     */
    public function index() {
        $institution = $this->institutionService->paginate();

        return $this->jsonResponse(
            InstitutionResource::collection($institution),
            'institution fetched successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstitutionFormRequest $request) {
        //
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
