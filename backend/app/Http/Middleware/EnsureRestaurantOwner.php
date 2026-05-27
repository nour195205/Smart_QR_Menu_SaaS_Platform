<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the authenticated user has an associated restaurant.
 *
 * Also shares the restaurant instance via request attribute so
 * controllers can access it without redundant DB queries.
 *
 * Must be applied AFTER auth:sanctum middleware.
 */
class EnsureRestaurantOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        $restaurant = $request->user()?->restaurant;

        if (! $restaurant) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'No restaurant found for this account.'], 404);
            }
            abort(404, 'No restaurant found for this account.');
        }

        if (! $restaurant->is_active) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Your restaurant account is currently inactive.'], 403);
            }
            abort(403, 'Your restaurant account is currently inactive.');
        }

        // Share restaurant instance with request — avoids N+1 in controllers
        $request->attributes->set('restaurant', $restaurant);
        
        // Share with all Blade views so layouts.dashboard can access it directly
        \Illuminate\Support\Facades\View::share('restaurant', $restaurant);

        return $next($request);
    }
}
