<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ErrorException extends Exception {

    protected $code = 422;

    /**
     * Report the exception.
     */
    public function report(): void {
        // ...
    }

    /**
     * Render the exception into an HTTP response.
     */

    public function render(Request $request): JsonResponse {
        return new JsonResponse([
            "error" => $this->getMessage(),
            "success" => false,
            "statusCode" => $this->code,
        ], $this->code);
    }
}
