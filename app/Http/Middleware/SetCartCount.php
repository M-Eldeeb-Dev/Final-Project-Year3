<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCartCount
{
    /**
     * Share cart item count with all views.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cart  = session('cart', []);
        $count = collect($cart)->sum('quantity');

        $wishlist = session('wishlist', []);
        $wishlistCount = count($wishlist);

        view()->share('cartCount', $count);
        view()->share('wishlistCount', $wishlistCount);

        return $next($request);
    }
}
