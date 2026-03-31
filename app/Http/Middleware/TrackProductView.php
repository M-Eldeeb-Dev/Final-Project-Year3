<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Product;

class TrackProductView
{
    /**
     * Increment product views_count after the response is sent.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->route() && $request->route()->named('products.show')) {
            $product = $request->route('product');
            if ($product instanceof Product) {
                $product->increment('views_count');
            }
        }

        return $response;
    }
}
