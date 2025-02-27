<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ErrorLog;

class ValidateApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $validToken = env('API_TOKEN');

        if (!$token || $token !== $validToken) {
            ErrorLog::create([
                'error_message' => 'Invalid or missing API token',
                'endpoint' => $request->path(),
                'status_code' => 401,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        return $next($request);
    }
}
