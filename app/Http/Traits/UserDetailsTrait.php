<?php

namespace App\Http\Traits;

use App\Enums\RoleEnum;

trait UserDetailsTrait {
    protected function getUserDetailsRepository($userRole) {
        switch ($userRole) {
            case RoleEnum::Admin:
                return $this->individual; //TODO change
                break;
            case RoleEnum::Student:
                return $this->company; //TODO change
                break;
            default:
                return $this->student;
        };
    }

    /**
     * Get Full User Details
     */
    protected function getUserDetails($user) {
        $details = $user->role === RoleEnum::Student ? $user->student : $user->institutionAdmin;

        $user = $user->withoutRelations();
        $user['userDetails'] = $details;

        return $user;
    }

    /**
     * Generate Additional User Information
     *
     * @return array
     */
    public function generateAdditionalDetails($payload, $userType, $role = null) {
        $payload['uuid'] = $this->generateIdentity();
        $payload['verification_token_generated_at'] = now();
        $payload['password'] = data_get($payload, 'password') ?: env('DEFAULT_PASSWORD');

        if ($role !== null) {
            $payload['role'] = $role;
        } else {
            $payload['role'] = $userType == 1 ? 'individual' : 'company';
        }

        return $payload;
    }
}