<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        //
    }

    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            // Handle Model Not Found
            if ($exception instanceof ModelNotFoundException) {
                $model = class_basename($exception->getModel());
                return response()->json([
                    'message' => "{$model} not found"
                ], Response::HTTP_NOT_FOUND);
            }

            // Handle Method Not Allowed
            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
                return response()->json([
                    'message' => $exception->getMessage(),
                    'status'  => Response::HTTP_METHOD_NOT_ALLOWED
                ], Response::HTTP_METHOD_NOT_ALLOWED);
            }

            // Handle Not Found (invalid URL)
            if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return response()->json([
                    'message' => 'Route not found',
                    'status'  => Response::HTTP_NOT_FOUND
                ], Response::HTTP_NOT_FOUND);
            }

            // Fallback for other exceptions
            return response()->json([
                'message' => $exception->getMessage(),
                'status'  => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Default rendering for non-API requests
        return parent::render($request, $exception);
    }


}
