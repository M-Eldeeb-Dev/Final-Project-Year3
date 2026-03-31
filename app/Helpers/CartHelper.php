<?php

if (!function_exists('formatPrice')) {
    /**
     * Format a price value using the store's currency symbol.
     *
     * Usage: formatPrice(89.99) → '$89.99'
     */
    function formatPrice(float $amount): string
    {
        $usd = config('deepify.currency_symbol', '$') . number_format($amount, 2);
        // Assuming ~ 48 EGP conversion rate to dollar
        $egpRate = 48.0;
        $egp = number_format($amount * $egpRate, 2) . ' EGP';
        return "<span class='inline-flex flex-col items-end leading-[1.1]'><span class='font-headline'>$usd</span><span class='text-[9px] text-[var(--text-muted)] font-label tracking-wide opacity-80 mt-1 whitespace-nowrap mt-0.5'>$egp</span></span>";
    }
}

if (!function_exists('cartTotal')) {
    /**
     * Return the current session cart total item count.
     */
    function cartTotal(): int
    {
        return (int) collect(session('cart', []))->sum('quantity');
    }
}
