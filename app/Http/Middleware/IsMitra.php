<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class IsMitra
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       if (Auth::user() && Auth::user()->roles == "MB") {
           
           return redirect()->route('user');
           
    }elseif(Auth::user() && Auth::user()->roles == "RB"){
            return $next($request);
        }elseif(Auth::user() && Auth::user()->roles == "ADMIN"){
             return redirect()->route('admin');

        }
        return redirect('/');
    }
}
