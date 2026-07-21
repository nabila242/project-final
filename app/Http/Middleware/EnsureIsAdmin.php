<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $email = Auth::user()->email;
            if ($email === 'admin@admin.com' || $email === 'admin@example.com') {
                return $next($request);
            }
        }
        return redirect('/dashboard');
    }
}
