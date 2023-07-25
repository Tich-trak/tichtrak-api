<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\ItemNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler {
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (ItemNotFoundException $e, $request) {
            return response()->json([
                'error' => 'Data not found', 'success' => false,
                'statusCode' => $e->getStatusCode(),
            ], 404);
        });

        $this->renderable(function (ModelNotFoundException $e, $request) {
            return response()->json([
                'error' => 'Data not found', 'success' => false,
                'statusCode' => $e->getStatusCode(),
            ], 404);
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            return response()->json([
                'error' => 'Unauthenticated user', 'success' => false,
                'statusCode' => 401,
            ], 404);
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'error' => 'Http route not found', 'success' => false,
                'statusCode' => $e->getStatusCode(),
            ], 404);
        });

        $this->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'error' => $e->errors(), 'success' => false,
                'statusCode' => 422,
            ], 422);
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return response()->json([
                'error' => 'Incorrect Http Verb', 'success' => false,
                'statusCode' => $e->getStatusCode(),
            ], 405);
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            return response()->json([
                'error' => 'Unauthorized user', 'success' => false,
                'statusCode' => $e->getStatusCode(),
            ], 403);
        });
    }
}
