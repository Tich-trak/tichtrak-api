<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Services\UserService;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserFormRequest;

class UserController extends BaseController {

    public function __construct(private UserService $userService) {
        $this->middleware('auth', ['except' => ['store']]);
        $this->middleware('role:Admin,SuperAdmin', ['only' => ['storeAdmin']]);
    }

    public function index() {
        $data = $this->userService->find();
        $users = UserResource::collection($data);

        return $this->jsonResponse($users, 'user fetched successfully');
    }

    //! THIS MIGHT NOT BE NEEDED
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
        $data = $this->userService->findById($id);
        $user = new UserResource($data);

        return $this->jsonResponse($user, 'user fetched successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFormRequest $request, string $id) {
        try {
            $payload = $request->safe()->except('id');

            $data = $this->userService->updateById($id, $payload);
            $user = new UserResource($data);

            return $this->jsonResponse($user, 'user updated successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Update th user Additional Details.
     */
    //TODO Implement update user details endpoint
    public function updateDetails(UserFormRequest $request, string $id) {
        try {
            $payload = $request->safe()->except('id');

            return $this->jsonResponse(null, 'user details updated successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $this->userService->deleteById($id);

        return $this->jsonResponse(null, 'user deleted successfully');
    }
}
