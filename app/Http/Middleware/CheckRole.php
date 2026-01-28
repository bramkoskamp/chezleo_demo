<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $role
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (auth()->check() && !in_array(auth()->user()->role_id, $roles)) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }

}
