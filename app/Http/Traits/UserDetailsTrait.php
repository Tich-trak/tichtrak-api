<?php

namespace App\Http\Traits;

use App\Enums\RoleEnum;

trait UserDetailsTrait {
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
    public function generateAdditionalDetails($payload) {
        $payload['uuid'] = $this->generateIdentity();
        $payload['verification_token_generated_at'] = now();

        return $payload;
    }
}
