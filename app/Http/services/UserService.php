<?php

namespace App\Http\Services;

use App\Mail\VerificationEmail;
use App\Mail\AdminVerificationEmail;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository as User;
use App\Repositories\StudentRepository as Student;
use App\Repositories\InstitutionRepository as Institution;
use App\Repositories\InstitutionAdminRepository as Admin;
use Illuminate\Support\Facades\Mail;

class UserService extends BaseService {

    public function __construct(
        private User $user,
        private Admin $admin,
        private Student $student,
        private Institution $institution,
    ) {
        parent::__construct($user, 'user');
    }

    public function create(array $request): UserModel {
        $payload = $this->generateDetails($request);
        $payload['role'] = config('utils.roles.student');

        return $this->user->create($payload);
    }

    public function createAdmin(array $request): array {
        $payload = $this->generateDetails($request);

        $password = $this->generateCode();
        $institution = $this->institution->findByField('id', $payload['institution_id'])->first();

        $payload['password'] = $password;
        $payload['name'] = auth()->user()->isSystemAdmin() ?  $institution->name : $payload['name'];
        $payload['email'] = auth()->user()->isSystemAdmin() ?  $institution->email : $payload['email'];
        $payload['role'] = config('utils.roles.admin');

        $user =  DB::transaction(function () use ($payload) {
            $user = $this->user->create($payload);

            $payload['user_id'] = $user->id;
            $payload['owner'] = auth()->user()->id;

            $this->admin->create($payload);
            return $user;
        });

        $token = $this->generateToken($user->uuid);
        $data = ['user' => $user, 'password' => $password, 'verification_token' => $token];

        Mail::to($user)->send(new AdminVerificationEmail($data));

        return $data;
    }
}