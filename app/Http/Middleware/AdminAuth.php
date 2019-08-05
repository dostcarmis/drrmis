<?php

namespace App\Http\Middleware;

use Closure;

class AdminAuth
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
        $is_admin = 1;
        if($this->auth->check() && $this->auth->user()->is_admin)
        {
            return $next($request);
        } else {

            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                return redirect('/');
            }
        }
    }
}
