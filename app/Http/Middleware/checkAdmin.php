<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
            return $next($request);
        else {
            if(Auth::check())
                return redirect('/user/form');
            else
                return redirect('/login');
        }
    }
}
