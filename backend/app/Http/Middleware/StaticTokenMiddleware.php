<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaticTokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        // Token statis yang digunakan
        $staticToken = 'Bearer lead-management-token-2025';

        if (!$token || $token !== $staticToken) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
