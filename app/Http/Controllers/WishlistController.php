<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    public function index()
    {
        $wishlistIds = session()->get('wishlist', []);

        $products = Product::whereIn('id', $wishlistIds)->active()->get();

        return view('wishlist', compact('products'));
    }


    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id'
        ]);

        $productId = $request->product_id;
        $wishlist = session()->get('wishlist', []);

        $action = 'added';

        if (in_array($productId, $wishlist)) {

            $wishlist = array_values(array_filter($wishlist, fn($id) => $id != $productId));
            $action = 'removed';
        } else {

            $wishlist[] = $productId;
        }

        session()->put('wishlist', $wishlist);

        $count = count($wishlist);

        return response()->json([
            'success' => true,
            'action'  => $action,
            'count'   => $count
        ]);
    }
}
