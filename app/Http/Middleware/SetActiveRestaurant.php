<?php

namespace App\Http\Middleware;

use App\Models\Restaurant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetActiveRestaurant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get active restaurant (in a multi-restaurant system, this could be based on domain, subdomain, etc.)
        $restaurant = Restaurant::where('is_active', true)->first();
        
        if ($restaurant) {
            // Store restaurant ID in session
            session(['restaurant_id' => $restaurant->id]);
        }
        
        return $next($request);
    }
}
