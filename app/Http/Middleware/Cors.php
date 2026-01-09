<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
    $origin = $request->headers->get('Origin');

    $allowed = [
        'http://localhost:5173',
        'http://127.0.0.1:5173',
    ];

    $headers = [
        'Access-Control-Allow-Methods'     => 'GET, POST, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With, X-CSRF-TOKEN, X-XSRF-TOKEN',
        'Access-Control-Allow-Credentials' => 'true',
        'Vary'                             => 'Origin',
    ];

    if ($origin && in_array($origin, $allowed, true)) {
        $headers['Access-Control-Allow-Origin'] = $origin;
    }

    if ($request->getMethod() === "OPTIONS") {
        return response('', 204, $headers);
    }

    $response = $next($request);
    foreach ($headers as $key => $value) {
        $response->headers->set($key, $value);
    }
    return $response;
}

}
