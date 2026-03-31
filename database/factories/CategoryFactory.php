<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;


    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Hoodies', 'Jackets', 'Sneakers', 'Accessories',
                'T-Shirts', 'Pants', 'Hats', 'Bags'
            ]),
            'image_url' => 'https://picsum.photos/seed/cat-'.$this->faker->word.'/400/300',
            'description' => $this->faker->sentence(10),
            'is_active' => true,
        ];
    }
}
