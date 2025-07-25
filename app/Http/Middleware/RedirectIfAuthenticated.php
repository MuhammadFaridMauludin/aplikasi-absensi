<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * @param Illuminate\Http\Request; $request
     * @param \Closure(\Illuminate\Http\Request); (\illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @param string|null ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard('karyawan')->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
            if (Auth::guard('user')->check()) {
                return redirect(RouteServiceProvider::HOMEADMIN);
            }
        }

        return $next($request);
    }
}
