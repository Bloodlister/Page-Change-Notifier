<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        var_dump(Auth::guard($guard)->check()); exit();
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
