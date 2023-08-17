<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\LevelFormRequest;
use App\Http\Resources\LevelResource;
use App\Http\Services\LevelService;

class LevelController extends BaseController {

    public function __construct(private LevelService $levelService) {
        $this->middleware('auth');
        $this->middleware('role:SuperAdmin,Admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $data = $this->levelService->find();
        $levels = LevelResource::collection($data);

        return $this->jsonResponse($levels, 'levels fetched successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LevelFormRequest $request) {
        try {
            $payload = $request->validated();
            $level = $this->levelService->create($payload);

            return $this->jsonResponse($level, 'level created successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $level = $this->levelService->findById($id);


        return $this->jsonResponse($level, 'level fetched successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LevelFormRequest $request, string $id) {
        try {
            $payload = $request->safe()->except('id');

            $level = $this->levelService->updateById($id, $payload);

            return $this->jsonResponse($level, 'level updated successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $this->levelService->deleteById($id);

        return $this->jsonResponse(null, 'level deleted successfully');
    }
}