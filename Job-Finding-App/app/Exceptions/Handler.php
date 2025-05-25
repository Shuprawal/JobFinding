<?php

namespace App\Exceptions;

use App\Facades\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types that are not reported.
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Handle unauthenticated access (e.g., missing Sanctum token).
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return ApiResponse::error('Unauthenticated. Please login via /api/login', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Render an exception into a custom JSON API response.
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            if (
                $exception instanceof AuthorizationException ||
                $exception instanceof AccessDeniedHttpException
            ) {
                return ApiResponse::error('You are not authorized to perform this action.', Response::HTTP_FORBIDDEN);
            }

            if ($exception instanceof AuthenticationException) {
                return ApiResponse::error('Unauthenticated. Please login via /api/login', Response::HTTP_UNAUTHORIZED);
            }

            if ($exception instanceof ModelNotFoundException) {
                $model = class_basename($exception->getModel());
                return ApiResponse::error("{$model} not found", Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof NotFoundHttpException) {
                return ApiResponse::error('Route not found', Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                return ApiResponse::error('Method not allowed on this route', Response::HTTP_METHOD_NOT_ALLOWED);
            }

            return ApiResponse::error($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return parent::render($request, $exception);
    }
}
