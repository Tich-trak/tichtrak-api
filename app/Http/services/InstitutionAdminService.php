<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\InstitutionAdminRepository;


class InstitutionAdminService extends BaseService {

    public function __construct(
        private InstitutionAdminRepository $admin,
        private UserService $userService
    ) {
        parent::__construct($admin, 'admin');
    }

    public function create(array $request) {
        $password = $this->generateCode();
        dump($password);

        $payload = $this->generateAdditionalDetails($request);
        $payload['password'] = $password;
        $payload['is_active'] = 1;
        $payload['role'] = config('utils.roles.admin');

        $user =  DB::transaction(function () use ($payload) {
            $user = $this->userService->create($payload);

            $payload['user_id'] = $user->id;
            $payload['owner'] = auth()->user()->id;

            $this->admin->create($payload);

            return $user;
        });

        $token = $this->generateToken($user->uuid);
        $data = ['user' => $user, 'verification_token' => $token];

        //TODO send Email Mail::to($user)->send(new VerificationEmail($user, $token));

        return $data;
    }
}
