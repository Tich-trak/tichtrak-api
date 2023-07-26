<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstitutionAdminController;
use App\Http\Controllers\InstitutionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'v1/',], function () {

    /*====================    Auth    =============================*/
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('verify/{verification_token}', [AuthController::class, 'verify']);
    Route::get('resend_verification/{email}', [AuthController::class, 'resendVerification']);
    Route::get('forgot_password/{email}', [AuthController::class, 'forgotPassword']);
    Route::patch('reset_password/{reset_token}', [AuthController::class, 'resetPassword']);
    Route::post('logout', [AuthController::class, 'logout']);

    /*====================  Institutions   =============================*/
    Route::apiResource('institutions', InstitutionController::class);

    /*====================  Users   =============================*/
    Route::apiResource('users', UserController::class);

    /*====================  Institution Admins   =============================*/
    Route::apiResource('admins', InstitutionAdminController::class);

    /*====================  Payments   =============================*/
    Route::apiResource('payments', PaymentController::class);

    /*====================  Subscription   =============================*/
    Route::apiResource('subscriptions', SubscriptionController::class);
});
