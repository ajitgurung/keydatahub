<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SubscribedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check for lifetime or valid subscription
        if (
            $user?->lifetime_subscribed ||
            $user?->subscribed('default') ||
            $user?->subscription('default')?->valid()
        ) {
            return $next($request);
        }

        // Redirect to payment/subscription page if not subscribed
        return redirect()->route('subscription')->with('error', 'You must have an active subscription to access this page.');
    }
}
