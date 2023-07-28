<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\UserFormRequest;
use App\Http\Services\InstitutionAdminService;
use App\Http\Resources\InstitutionAdminResource;

class InstitutionAdminController extends BaseController {

    public function __construct(private InstitutionAdminService $adminService) {
        $this->middleware('auth');
        $this->middleware('role:RoleEnum::SuperAdmin,role:RoleEnum::Admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $data = $this->adminService->find();
        $admins = InstitutionAdminResource::collection($data);

        return $this->jsonResponse($admins, 'admin fetched successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request) {
        try {
            $payload = $request->validated();
            $admin = $this->adminService->createAdmin($payload);

            return $this->jsonResponse($admin, 'admin created successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
