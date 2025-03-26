<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // ✅ Import Log
use Illuminate\Support\Facades\user; // ✅ Import User

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
      if (Auth::check() && Auth::user()->hasRole('admin')) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}

