<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // ✅ Import Log

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Debugging: Log the authenticated user
        Log::info('Checking admin access for user:', ['user' => Auth::user()]);

        // Ensure user is authenticated and has the 'admin' role
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}

