<?php namespace App\Http\Middleware;

use Closure;

class SetCharset
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Content-Type', 'text/html; charset=utf-8');

        return $response;
    }
}