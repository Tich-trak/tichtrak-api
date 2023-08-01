<?php

namespace App\Http\Services;

use App\Exceptions\ErrorException;

use App\Http\Requests\UserFormRequest;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class AuthService extends BaseService {

    public function __construct(
        private UserService $userService,
        private PasswordService $passwordService,
    ) {
    }

    public function register(UserFormRequest $payload) {
    }

    public function verify(string $token) {
        $decodedToken = $this->decodeToken($token);
        if (!$decodedToken) throw new ErrorException('Invalid token provided');

        $user = $this->userService->findOne(['uuid' => $decodedToken]);
        if (!$user) throw new ErrorException('Invalid token provided');

        if ($user->is_active) throw new ErrorException('User already verified');
        if (!$this->verifyTimeDiff($user->verification_token_generated_at))
            throw new ErrorException('Activation link has expired', 406);

        $user = $this->userService->updateById($user->id, ['is_active' => 1, 'verified_at' => now()]);

        $token = auth()->login($user);
        $data = ['user' => $user, 'access_token' => $token];

        Mail::to($user)->send(new WelcomeEmail($user, $token));

        return $data;
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