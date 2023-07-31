<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository as User;
use App\Repositories\StudentRepository as Student;
use App\Repositories\InstitutionAdminRepository as Admin;

class UserService extends BaseService {

    public function __construct(
        private User $user,
        private Admin $admin,
        private Student $student,
    ) {
        parent::__construct($user, 'user');
    }

    public function createAdmin(array $request) {
        $payload = $this->generateAdditionalDetails($request);

        $password = $this->generateCode();
        $payload['password'] = $password;

        $payload['is_active'] = 1;
        $payload['role'] = config('utils.roles.admin');

        $admin =  DB::transaction(function () use ($payload) {
            $user = $this->user->create($payload);

            $payload['user_id'] = $user->id;
            $payload['owner'] = auth()->user()->id;

            $this->admin->create($payload);

            return $this->getUserDetails($user);
        });

        $token = $this->generateToken($admin->uuid);
        $data = ['user' => $admin, 'verification_token' => $token];

        //TODO send Email Mail::to($user)->send(new VerificationEmail($user, $token));

        return $data;
    }
}
