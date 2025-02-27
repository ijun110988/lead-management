<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class StaticTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $providedToken = $request->bearerToken();
        $expectedToken = config('app.api_token') ?? env('API_TOKEN');

        if (empty($providedToken)) {
            Log::warning('API request made without token');
            return response()->json([
                'message' => 'No API token provided',
                'error' => 'Authorization header missing or empty'
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($providedToken !== $expectedToken) {
            Log::warning('API request made with invalid token');
            return response()->json([
                'message' => 'Invalid API token',
                'error' => 'The provided API token is not valid'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
