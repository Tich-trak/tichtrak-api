<?php

namespace App\Http\Services;

use App\Exceptions\ErrorResponse;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService {

    public function __construct(
        private UserService $userService,
        private PasswordService $passwordService,
    ) {
    }

    public function register(array $payload) {
    }

    public function verify(string $token) {
    }

    public function login(array $payload) {
    }

    public function resendVerification(string $email) {
    }

    public function forgotPassword(string $email) {
    }

    public function resetPassword($email, array $payload) {
    }

    public function logout() {
        return null;
    }
}