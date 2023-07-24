<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Mail\WelcomeEmail;
use App\Mail\VerificationEmail;
use App\Mail\ResetPasswordEmail;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\UserFormRequest;

class AuthService extends BaseService {

    public function __construct(
        private UserService $userService,
        private StudentService $studentService,
        private InstitutionAdminService $adminService,
        private PasswordService $passwordService,
    ) {
    }

    public function register(UserFormRequest $payload) {
    }

    public function verify(string $token) {
    }

    public function login(LoginFormRequest $payload) {
    }

    public function resendVerification(string $email) {
    }

    public function forgotPassword(string $email) {
    }

    public function resetPassword(ResetPasswordFormRequest $payload) {
    }

    public function logout() {
        return null;
    }
}
