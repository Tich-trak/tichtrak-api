<?php

namespace App\Http\Controllers;

use Exception;
use Ramsey\Uuid\Uuid;

use App\Mail\WelcomeEmail;
use App\Mail\VerificationEmail;

use App\Mail\ResetPasswordEmail;
use App\Exceptions\ErrorResponse;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UserFormRequest;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;



class AuthController extends BaseController {

    public function __construct(
        private User $user,
        private Individual $individual,
        private Company $company,
        private Password $password,
    ) {
        $this->middleware('auth', ['only' => ['logout']]);
    }

    /**
     * Register a New user account.
     *
     * @OA\Post(
     *     path="/register",
     *     tags={"Auth"},
     *     operationId="registerUser",
     *     description="Register a User",
     *     @OA\RequestBody(
     *         description="create user object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateUser")
     *      ),
     *     @OA\Response(
     *         response=201,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/CreateUser"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessible entity"
     *     ),
     * )
     */
    public function register(UserFormRequest $request) {
        try {
            $payload = $request->validated();
            $userPayload = $this->generateAdditionalDetails($payload, $request->userType);

            $user =  DB::transaction(function () use ($userPayload) {
                $user = $this->user->create($userPayload);

                $userPayload['user_id'] = $user->id;
                $userDetails = $this->getUserDetailsRepository($user->role);
                $userDetails->create($userPayload);

                return $user;
            });

            $token = $this->generateToken($user->uuid);
            $data = ['user' => $user, 'verification_token' => $token];

            Mail::to($user)->send(new VerificationEmail($user, $token));

            return $this->jsonResponse($data, 'Successfully created User, Please Check your Email', 201);
        } catch (Exception $ex) {
            return $this->jsonError(['error' => 'Error encountered please contact admin with error :' . $ex->getMessage()], 500);
        }
    }

    /**
     * Verify a user account.
     *
     * @OA\Get(
     *     path="/verify/{verification_token}",
     *     tags={"Auth"},
     *     operationId="verifyUser",
     *     description="Verify a User",
     *     @OA\Parameter(
     *         name="verification_token",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data not found"
     *     ),
     *     @OA\Response(
     *         response=406,
     *         description="Not accepted"
     *     ),
     * )
     */
    public function verify($verificationToken) {
        $decodedToken = $this->decodeToken($verificationToken);
        ($decodedToken && Uuid::isValid($decodedToken)) ?: throw new ErrorResponse('invalid token provided', 400);

        $user = $this->user->findByField('uuid', $decodedToken)->first();
        ($user) ?: throw new ErrorResponse('User Not Found', 404);

        ($user->is_active == 0) ?: throw new ErrorResponse('User already Verified Please Login!!!', 406);
        ($this->verifyTimeDiff($user->verification_token_generated_at))
            ?: throw new ErrorResponse('Activation link has expired. Please request a new activation link', 406);

        $user = $this->user->updateEntity(['is_active' => 1, 'verified_at' => now()], $user->id);

        $token = auth()->login($user);
        $data = ['user' => $user, 'access_token' => $token];

        Mail::to($user)->send(new WelcomeEmail($user, $token));

        return $this->jsonResponse($data, 'Successfully verified Email', 200);
    }

    /**
     * Resend verification link.
     *
     * @OA\Get(
     *     path="/resend_verification/{email}",
     *     tags={"Auth"},
     *     operationId="resendVerification",
     *     description="Resend verification link",
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Response(
     *         response=404,
     *         description="Data not found"
     *     ),
     *     @OA\Response(
     *         response=406,
     *         description="Not accepted"
     *     ),
     * )
     */
    public function resendVerification($email) {
        try {
            $user = $this->user->findByField('email', $email)->first();
            ($user) ?: throw new ErrorResponse('User Not Found', 404);

            ($user->is_active == 0) ?: throw new ErrorResponse('User already verified!', 406);

            $user =  DB::transaction(function () use ($user) {
                return $this->user->updateEntityUuid(
                    ['verification_token_generated_at' => now()],
                    $user->uuid
                );
            });

            $token = $this->generateToken($user->uuid);
            $data = ['user' => $user, 'verification_token' => $token];

            Mail::to($user)->send(new VerificationEmail($user, $token));

            return $this->jsonResponse($data, 'Verification Sent, Please Check your Email', 200);
        } catch (\PDOException $ex) {
            return $this->jsonError(['error' => 'Error encountered please contact admin with error :' . $ex->getMessage()], 500);
        }
    }

    /**
     * Login User Account
     *
     * @OA\Post(
     *     path="/login",
     *     tags={"Auth"},
     *     operationId="userLogin",
     *     description="Login in a User",
     *     @OA\RequestBody(
     *         description="Updated user object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserLogin")
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/User"),
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Not allowed"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessible entity"
     *     ),
     * )
     */
    public function login(LoginFormRequest $request) {
        $credentials = $request->only('email', 'password');
        ($token = auth()->attempt($credentials)) ?: throw new ErrorResponse('invalid login credentials provided');

        $user = auth()->user();
        ($user->is_active == 1) ?: throw new ErrorResponse('Unverified Account, Please check your email to verify your account!!!', 405);

        $data = ['user' => $user, 'access_token' => $token];

        return $this->jsonResponse($data, 'User logged in Successfully');
    }

    /**
     * Forgot Password.
     *
     * @OA\Get(
     *     path="/forgot_password/{email}",
     *     tags={"Auth"},
     *     operationId="forgotPassword",
     *     description="Send password reset email",
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Response(
     *         response=404,
     *         description="Data not found"
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Not allowed"
     *     ),
     * )
     */
    public function forgotPassword($email) {
        try {
            $user = $this->user->findByField('email', $email)->first();
            ($user) ?: throw new ErrorResponse('User Not Found', 404);

            ($user->is_active) ?: throw new ErrorResponse('Unverified Account', 405);

            $passwordData =  DB::transaction(function () use ($user) {
                $password_reset = $this->password->updateOrCreate(['email' => $user->email], [
                    'token' => $this->generateIdentity(),
                    'created_at' => now()
                ]);

                $this->user->updateEntity(['password' => ''], $user->id);
                return $password_reset;
            });

            $data = ['user' => $passwordData->email, 'reset_token' => $passwordData->token];

            Mail::to($user)->send(new ResetPasswordEmail($user, $passwordData->token));

            return $this->jsonResponse($data, 'Reset Password Email Sent, Please Check your Mail');
        } catch (\PDOException $ex) {
            return $this->jsonError(['error' => 'Error encountered please contact admin with error :' . $ex->getMessage()], 500);
        }
    }

    /**
     * Reset User password.
     *
     * @OA\Patch(
     *     path="reset_password/{reset_token}",
     *     tags={"Auth"},
     *     operationId="resetUserPassword",
     *     description="Reset a user's password",
     *     @OA\Parameter(
     *         name="passwordreset",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *              ref="#/components/schemas/PasswordReset"
     *          )
     *	    ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Data not found"
     *     ),
     *     @OA\Response(
     *         response=406,
     *         description="Not accepted"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Unprocessible entity"
     *     ),
     * )
     */
    public function resetPassword(ResetPasswordFormRequest $request, $resetToken) {
        try {
            // dd($request);

            $passwordData = $this->password->findByField('token', $resetToken)->first();
            ($passwordData) ?: throw new ErrorResponse('Data Not Found', 404);

            $user = $this->user->findByField('email', $passwordData->email)->first();
            ($user) ?: throw new ErrorResponse('User Not Found', 404);

            ($this->verifyTimeDiff($passwordData->created_at)) ?: throw new ErrorResponse('Token Expired, Request a New One', 406);

            $user =  DB::transaction(function () use ($user, $request, $resetToken) {
                $user = $this->user->updateEntity(['password' => $request->password], $user->id);
                $this->password->deleteWhere(['token' => $resetToken]);

                return $user;
            });

            $token = auth()->login($user);
            $data = ['user' => $user, 'access_token' => $token];

            return $this->jsonResponse($data, 'Password Reset Successful');
        } catch (\PDOException $ex) {
            return $this->jsonError(['error' => 'Error encountered please contact admin with error :' . $ex->getMessage()], 500);
        }
    }

    /**
     * User Logout
     *
     * @OA\Post(
     *     path="/logout",
     *     tags={"Auth"},
     *     operationId="userLogout",
     *     description="Logout a user",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     * security={
     *         {"Drive45_auth": {"read:user"}}
     *     },
     * )
     */
    public function logout() {
        auth()->logout();

        return $this->jsonResponse(null, 'Successfully Logged Out');
    }
}