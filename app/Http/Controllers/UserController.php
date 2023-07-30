<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Http\Services\UserService;
use Exception;

class UserController extends BaseController {

    public function __construct(private UserService $userService) {
        $this->middleware('auth');
        $this->middleware('role:RoleEnum::SuperAdmin,role:RoleEnum::Admin');
    }


    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request) {
        try {
            $payload = $request->validated();
            $user = $this->userService->create($payload);

            return $this->jsonResponse($user, 'user created successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }


    /**
     * Store a newly created admin in storage.
     */
    public function storeAdmin(UserFormRequest $request) {
        try {
            $payload = $request->validated();
            $admin = $this->userService->createAdmin($payload);

            return $this->jsonResponse($admin, 'admin created successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $user = $this->userService->findById($id);

        return $this->jsonResponse($user, 'user fetched successfully');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update() {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy() {
        //
    }
}
