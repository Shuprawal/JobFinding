<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
//use Illuminate\Routing\Route;
use Illuminate\Http\Response as IlluminateResponse;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Support\Facades\Route;


class EnsureAPIResult
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): SymfonyResponse
    {

        $request->headers->set('Accept', 'application/json');

        $response = $next($request);


        if ($response instanceof JsonResponse){
            return $response;
        }

        return response()->json([
            'data' => $response->getContent(),
        ], $response->getStatusCode());
    }
}
