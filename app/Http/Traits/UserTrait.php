<?php

namespace App\Http\Traits;

use App\Enums\RoleEnum;

trait UserTrait {
    /**
     * Get User Type Repository
     */
    protected function getUserTypeRepo($userRole) {
        switch ($userRole) {
            case RoleEnum::Admin:
                return $this->admin;
                break;
            case RoleEnum::Student:
                return $this->student;
                break;
            default:
                return $this->student;
        };
    }

    /**
     * Get Full User Details
     */
    protected function getUserDetails($user) {
        $details = $user->role === RoleEnum::Student ?
            $user->student : $user->admin;

        $user = $user->withoutRelations();
        $user['userDetails'] = $details;

        return $user;
    }

    /**
     * Generate Additional User Information
     *
     * @return array
     */
    public function generateAdditionalDetails($payload) {
        $payload['uuid'] = $this->generateIdentity();
        $payload['verification_token_generated_at'] = now();

        return $payload;
    }
}
