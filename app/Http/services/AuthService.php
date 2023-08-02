<?php

namespace App\Http\Services;

use App\Exceptions\ErrorException;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Mail\AdminVerificationEmail;
use App\Mail\VerificationEmail;

class AuthService extends BaseService {

    public function __construct(
        private UserService $userService,
        private PasswordService $passwordService,
    ) {
    }

    public function verify(string $token) {
        $decodedToken = $this->decodeToken($token);
        if (!$decodedToken) throw new ErrorException('Invalid token provided');

        $user = $this->userService->findOne(['uuid' => $decodedToken]);
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
        if (!$token) throw new ErrorException('Invalid login credentials');

        $user = auth()->user();
        if (!$user->is_active)  throw new ErrorException('Unverified Account!!', 405);

        return ['user' => $user, 'access_token' => $token];
    }

    public function resendVerification(string $email) {
        $user = $this->userService->findOne(['email' => $email]);
        if ($user->is_active) throw new ErrorException('User already verified');

        $password = $this->generateCode();

        $user =  DB::transaction(function () use ($user, $password) {
            $payload = $user->isAdmin() ? ['verification_token_generated_at' => now(), 'password' => $password]
                : ['verification_token_generated_at' => now()];

            return $this->userService->updateById($user->id, $payload);
        });

        $token = $this->generateToken($user->uuid);

        $data = $user->isAdmin() ? ['user' => $user, 'password' => $password, 'verification_token' => $token]
            : ['user' => $user, 'verification_token' => $token];

        !$user->isAdmin() ? Mail::to($user)->send(new VerificationEmail($user, $token))
            : Mail::to($user)->send(new AdminVerificationEmail($data));

        return $data;
    }

    public function forgotPassword(string $email) {
    }

    public function resetPassword(ResetPasswordFormRequest $payload) {
    }

    public function logout() {
        return null;
    }
}