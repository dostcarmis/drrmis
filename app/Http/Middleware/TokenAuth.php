<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class TokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken() ?? $request->header('X-c_token');

        if (!$token) {
            return response()->json(['message' => 'Unauthorized: No token provided.'], 401);
        }

        $user = User::where('c_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized: Invalid token.'], 401);
        }

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
