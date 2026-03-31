<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Category;

class ProductFactory extends Factory
{
    protected $model = Product::class;


    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->unique()->words(3, true),
            'description' => $this->faker->paragraphs(2, true),
            'price' => $this->faker->randomFloat(2, 29.99, 299.99),
            'sale_price' => $this->faker->optional(0.3)->randomFloat(2, 19.99, 149.99),
            'image_url' => 'https://picsum.photos/seed/'.$this->faker->word.'/600/600',
            'stock' => $this->faker->numberBetween(0, 50),
            'size_options' => 'XS,S,M,L,XL,XXL',
            'color_options' => $this->faker->randomElement([
                'Black,White', 'Black,Blue,Gray',
                'White,Cream', 'Navy,Black,White'
            ]),
            'is_featured' => $this->faker->boolean(25),
            'is_active' => true,
            'views_count' => $this->faker->numberBetween(0, 500),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 0,
        ]);
    }

    public function onSale(): static
    {
        return $this->state(fn (array $attributes) => [
            'sale_price' => round($attributes['price'] * 0.7, 2),
        ]);
    }
}
