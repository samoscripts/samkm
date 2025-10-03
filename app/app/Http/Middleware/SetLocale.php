<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has language preference
        if (Auth::check()) {
            $user = Auth::user();
            $user->load('settings'); // Explicitly load settings relationship
            $locale = $user->language ?? 'pl';
            app()->setLocale($locale);
        } else {
            // For guests, check session or use default
            $locale = session('locale', config('app.locale'));
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
