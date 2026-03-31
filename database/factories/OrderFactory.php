<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;

class OrderFactory extends Factory
{
    protected $model = Order::class;


    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 50, 500);
        $shipping_cost = $this->faker->randomElement([0, 9.99]);
        $tax = round($subtotal * 0.08, 2);
        $total = round($subtotal + $shipping_cost + $tax, 2);

        return [
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->safeEmail(),
            'customer_phone' => $this->faker->phoneNumber(),
            'shipping_address' => $this->faker->streetAddress(),
            'shipping_city' => $this->faker->city(),
            'shipping_country' => $this->faker->country(),
            'shipping_zip' => $this->faker->postcode(),
            'shipping_cost' => $shipping_cost,
            'tax' => $tax,
            'total' => $total,
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
            'payment_method' => 'cash_on_delivery',
            'credit_card_owner' => null,
            'credit_card_ccv' => null,
            'credit_card_number' => null,
            'credit_card_expiration_date' => null,
            'notes' => null,
        ];
    }
}
