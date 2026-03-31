<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{

    public function run(): void
    {
        $categories = [
            [
                'name' => 'Hoodies',
                'slug' => 'hoodies',
                'description' => 'Gravity-defying comfort for the streets.',
                'image_url' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80'
            ],
            [
                'name' => 'Jackets',
                'slug' => 'jackets',
                'description' => 'Engineered for the future explorer.',
                'image_url' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80'
            ],
            [
                'name' => 'Sneakers',
                'slug' => 'sneakers',
                'description' => 'Step into the next dimension.',
                'image_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80'
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Finish the look. Complete the orbit.',
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&q=80'
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
