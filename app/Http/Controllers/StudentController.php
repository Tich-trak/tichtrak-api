<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\UserFormRequest;
use App\Http\Resources\StudentResource;
use App\Http\Services\StudentService;

class StudentController extends BaseController {

    public function __construct(private StudentService $studentService) {
        $this->middleware('auth', ['except' => ['signup']]);
        $this->middleware('role:Admin,SuperAdmin', ['only' => ['store']]);
    }

    //* Filter with institution ID
    public function index() {
        $data = $this->studentService->find();
        $students = StudentResource::collection($data);

        return $this->jsonResponse($students, 'students fetched successfully');
    }

    public function register(UserFormRequest $request, $subdomain) {
        try {
            $payload = $request->validated();
            $student = $this->studentService->register($payload, $subdomain);

            return $this->jsonResponse($student, 'student created successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }
}