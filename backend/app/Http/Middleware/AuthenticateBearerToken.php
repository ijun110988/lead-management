<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateBearerToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = env('API_TOKEN');

        if ($request->header('Authorization') !== "Bearer $token") {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}

