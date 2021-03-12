<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, int $role)
    {
        if ((Auth::check()) && (Auth::user()->role_id == $role) && (Auth::user()->emp_status_id != 2))
        {
          return $next($request);
        }

        return redirect()->route('error.no_permission');
    }
}
