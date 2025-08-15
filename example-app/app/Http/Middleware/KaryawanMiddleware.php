<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KaryawanMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('karyawan_logged_in')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
