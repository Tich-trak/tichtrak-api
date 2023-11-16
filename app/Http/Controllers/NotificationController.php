<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\NotificationFormRequest;
use App\Http\Resources\NotificationResource;
use App\Http\Services\NotificationService;


class NotificationController extends BaseController {

    public function __construct(private NotificationService $notificationService) {
        $this->middleware('auth');
        $this->middleware('role:SuperAdmin,Admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        $data = $this->notificationService->find();
        $notifications = NotificationResource::collection($data);

        return $this->jsonResponse($notifications, 'notifications fetched successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationFormRequest $request) {
        try {
            $payload = $request->validated();
            $notification = $this->notificationService->create($payload);

            return $this->jsonResponse($notification, 'notification created successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $notification = $this->notificationService->findById($id);

        return $this->jsonResponse($notification, 'notification fetched successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationFormRequest $request, string $id) {
        try {
            $payload = $request->safe()->except('id');

            $notification = $this->notificationService->updateById($id, $payload);

            return $this->jsonResponse($notification, 'notification updated successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $this->notificationService->deleteById($id);

        return $this->jsonResponse(null, 'notification deleted successfully');
    }
}
