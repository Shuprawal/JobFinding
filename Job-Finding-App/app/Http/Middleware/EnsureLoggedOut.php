<?php

namespace App\Http\Middleware;

use App\Facades\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;

class EnsureLoggedOut
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user instanceof \App\Models\User && $user->currentAccessToken()) {
            return ApiResponse::error('already logged in', Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
