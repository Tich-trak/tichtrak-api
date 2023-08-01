<?php

namespace App\Http\Services;

use App\Mail\AdminVerificationEmail;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository as User;
use App\Repositories\StudentRepository as Student;
use App\Repositories\InstitutionAdminRepository as Admin;
use Illuminate\Support\Facades\Mail;

class UserService extends BaseService {

    public function __construct(
        private User $user,
        private Admin $admin,
        private Student $student,
    ) {
        parent::__construct($user, 'user');
    }

    public function create(array $request) {
        $payload = $this->generateDetails($request);
        $payload['role'] = config('utils.roles.student');

        $user =  DB::transaction(function () use ($payload) {
            $user = $this->user->create($payload);

            $payload['user_id'] = $user->id;
            $this->student->create($payload);

            return $user;
        });

        $token = $this->generateToken($user->uuid);
        $data = ['user' => $user, 'verification_token' => $token];

        Mail::to($user)->send(new VerificationEmail($user, $token));

        return $data;
    }

    public function createAdmin(array $request) {
        $payload = $this->generateDetails($request);
        $password = $this->generateCode();

        $payload['password'] = $password;
        $payload['is_active'] = 1;
        $payload['role'] = config('utils.roles.admin');

        $user =  DB::transaction(function () use ($payload) {
            $user = $this->user->create($payload);

            $payload['user_id'] = $user->id;
            $payload['owner'] = auth()->user()->id;

            $this->admin->create($payload);

            return $user;
        });

        $token = $this->generateToken($user->uuid);
        $data = ['user' => $user, 'verification_token' => $token, 'password' => $password];

        Mail::to($user)->send(new AdminVerificationEmail($data));

        return $data;
    }
}
