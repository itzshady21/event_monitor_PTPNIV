<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BagsdmMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session('bagsdm_logged_in') && session('bagsdm_id')) {
            return $next($request);
        }

        return redirect('/login')->with('loginError', 'Silakan login sebagai Bagian SDM.');
    }
}
