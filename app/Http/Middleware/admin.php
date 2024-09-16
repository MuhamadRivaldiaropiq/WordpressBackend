<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                if ($user->level === 'admin') {
                    return redirect('/dashboard'); // Ganti dengan rute admin yang sesuai
                } elseif ($user->level === 'user') {
                    return redirect('/user/home'); // Ganti dengan rute user yang sesuai
                }
            }
        }

        return $next($request);
    }
}
