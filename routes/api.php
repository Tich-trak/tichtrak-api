<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ProgrammeController;

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
    Route::get('verify/{verification_token}', [AuthController::class, 'verify']);
    Route::get('resend_verification/{email}', [AuthController::class, 'resendVerification']);
    Route::get('forgot_password/{email}', [AuthController::class, 'forgotPassword']);
    Route::patch('reset_password/{reset_token}', [AuthController::class, 'resetPassword']);
    Route::post('logout', [AuthController::class, 'logout']);

    /*====================  Institutions   =============================*/
    Route::apiResource('institutions', InstitutionController::class);

    /*====================  Faculties   =============================*/
    Route::apiResource('faculties', FacultyController::class);

    /*====================  Departments   =============================*/
    Route::apiResource('departments', DepartmentController::class);

    /*====================  Programmes   =============================*/
    Route::apiResource('programmes', ProgrammeController::class);

    /*====================  Levels   =============================*/
    Route::apiResource('levels', LevelController::class);

    /*====================  Users   =============================*/
    Route::post('users/admin', [UserController::class, 'storeAdmin']);
    Route::apiResource('users', UserController::class);

    /*====================  Transactions   =============================*/
    Route::apiResource('transactions', TransactionController::class);

    /*====================  Subscription   =============================*/
    Route::apiResource('subscriptions', SubscriptionController::class);
});
