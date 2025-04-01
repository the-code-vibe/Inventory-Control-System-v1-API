<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Access Denied. Admins only.'], 403);
    }
}