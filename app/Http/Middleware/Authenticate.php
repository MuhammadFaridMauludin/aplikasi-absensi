<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    { //ketika belum login admin. akses panel/dashboardadmin masih mengarah ke loginkaryawan
        if (!$request->expectsJson()) {
            if (request()->is('panel/*')) {
                return route('loginadmin');
            } else {
                return route('login');
            }
        }
    }
}
