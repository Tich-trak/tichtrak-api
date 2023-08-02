<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Services\AuthService;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;

class AuthController extends BaseController {

    public function __construct(private AuthService $authService) {
        $this->middleware('auth', ['only' => ['logout']]);
    }

    public function verify(string $token) {
        try {
            $data = $this->authService->verify($token);

            return $this->jsonResponse($data, 'User verified successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    public function resendVerification(string $email) {
        try {
            $data = $this->authService->resendVerification($email);

            return $this->jsonResponse($data, 'Email resent successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    public function login(LoginFormRequest $request) {
        try {
            $data = $this->authService->login($request);

            return $this->jsonResponse($data, 'User logged in successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    public function forgotPassword(string $email) {
        try {
            $data = $this->authService->forgotPassword($email);

            return $this->jsonResponse($data, 'Forget password email sent successfully');
        } catch (Exception $ex) {
            return $this->jsonError($ex->getMessage(), 500);
        }
    }

    public function resetPassword(ResetPasswordFormRequest $request, string $resetToken) {
    }

    public function logout() {
        auth()->logout();

        return $this->jsonResponse(null, 'Successfully Logged Out');
    }
}