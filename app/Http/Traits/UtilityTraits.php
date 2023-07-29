<?php

namespace App\Http\Traits;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

trait UtilityTraits {
    /**
     * Verify Time Difference between dates
     */
    protected function verifyTimeDiff($createdAt) {
        $verifyGenerated = strtotime($createdAt);
        $verifyAt = strtotime('now - 24 hours');

        if ($verifyAt <= $verifyGenerated) return true;
        else return false;
    }

    /**
     * Generate UUID
     *
     * @return string
     */
    protected function generateIdentity() {
        return (string)Uuid::uuid5(Uuid::uuid4(), Str::random(10));
    }

    /**
     * Generate Random Number
     *
     * @return
     */
    public function generateCode() {
        return random_int(100000, 999999);
    }

    /**
     * Generate Token From UUID
     *
     * @return
     */
    protected function generateToken($uuid) {
        return Crypt::encryptString($uuid);
    }

    /**
     * Decode Token From UUID
     *
     * @return
     */
    protected function decodeToken($token) {
        return Crypt::decryptString($token);
    }
}