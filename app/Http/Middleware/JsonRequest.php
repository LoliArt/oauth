<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JsonRequest
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response|JsonResponse|RedirectResponse
    {
        // accept json
        $request->headers->set('Accept', 'application/json');

        // set json response
        return $next($request);
    }
}
