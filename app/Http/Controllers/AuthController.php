<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;

use App\Http\Services\AuthService;

class AuthController extends BaseController {

    public function __construct(private AuthService $authService) {
        $this->middleware('auth', ['only' => ['logout']]);
    }

    public function register(UserFormRequest $request) {
    }

    public function verify(string $verificationToken) {
    }

    public function resendVerification(string $email) {
    }

    public function login(LoginFormRequest $request) {
    }

    public function forgotPassword(string $email) {
    }

    public function resetPassword(ResetPasswordFormRequest $request, string $resetToken) {
    }

    public function logout() {
        auth()->logout();

        return $this->jsonResponse(null, 'Successfully Logged Out');
    }
}
