<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCartNotEmpty
{
    /**
     * Redirect to cart if the session cart is empty.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('warning', 'Your cart is empty.');
        }

        return $next($request);
    }
}
