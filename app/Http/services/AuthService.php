<?php

namespace App\Http\Services;

use App\Mail\WelcomeEmail;
use App\Mail\VerificationEmail;

use App\Mail\ResetPasswordEmail;
use App\Exceptions\ErrorException;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;

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

    public function login(LoginFormRequest $request) {
        $credentials = $request->only('email', 'password');

        $token = auth()->attempt($credentials);
        if (!$token) throw new ErrorException('invalid login credentials');

        $user = auth()->user();
        if (!$user->is_active)  throw new ErrorException('Unverified Account!!', 405);

        return ['user' => $user, 'access_token' => $token];
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
