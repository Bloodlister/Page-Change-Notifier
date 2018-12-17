<?php

namespace App\Http\Middleware;

use Closure;

class LoggedIn
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
        if ($request->user()) {
            if (!in_array($request->path(), ['filters', 'filters/all', 'filters/delete', 'filters/create', 'logout'])) {
                return redirect('/filters');
            }
        } else {
            if (!in_array($request->path(), ['login', 'register'])) {
                return redirect('/login');
            }
        }
        return $next($request);
    }
}
