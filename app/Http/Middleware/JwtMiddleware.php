<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$this->verifyToken($request->bearerToken())) {
            return response()->json([
                'message' => 'Unauthenticated User.'
            ], 401);
        }

        return $next($request);
    }

    protected function verifyToken($token)
    {
        $response = Http::withToken($token)->get(config('services.auth.url') . '/api/auth/user');

        return $response->successful();
    }
}
