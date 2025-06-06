<?php

namespace App\Http\Middleware;

use App\Facades\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || $user->role?->name !== 'Admin' ){
            return ApiResponse::error('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
