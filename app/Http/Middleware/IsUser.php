<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class IsUser
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
            return $next($request);


        }elseif(Auth::user() && Auth::user()->roles == "RB"){
            return redirect()->route('rb');
        }elseif(Auth::user() && Auth::user()->roles == "ADMIN"){
             return redirect()->route('admin');

        }
        return redirect('/');
    }
}
