<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{

    public function run(): void
    {
        $hoodiesId = Category::where('slug', 'hoodies')->value('id');
        $jacketsId = Category::where('slug', 'jackets')->value('id');
        $sneakersId = Category::where('slug', 'sneakers')->value('id');
        $accessoriesId = Category::where('slug', 'accessories')->value('id');


        $products = [

            [
                'category_id' => $hoodiesId,
                'name' => 'Gravity Hoodie Black',
                'slug' => 'gravity-hoodie-black',
                'price' => 89.99,
                'sale_price' => null,
                'description' => 'Heavyweight fleece. Anti-everything. Designed for maximum comfort in all dimensions. Stay warm and ready for anything.',
                'stock' => 15,
                'is_featured' => true,
                'size_options' => 'XS,S,M,L,XL,XXL',
                'color_options' => 'Black',
                'image_url' => 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=800&q=80'
            ],
            [
                'category_id' => $hoodiesId,
                'name' => 'Neon Circuit Hoodie',
                'slug' => 'neon-circuit-hoodie',
                'price' => 94.99,
                'sale_price' => 74.99,
                'description' => 'Power up your wardrobe with our bright neon trims. Essential wear for the dark nights.',
                'stock' => 8,
                'is_featured' => true,
                'size_options' => 'S,M,L,XL',
                'color_options' => 'Black,Electric Blue',
                'image_url' => 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=800&q=80'
            ],
            [
                'category_id' => $hoodiesId,
                'name' => 'Orbit Pullover Gray',
                'slug' => 'orbit-pullover-gray',
                'price' => 79.99,
                'sale_price' => null,
                'description' => 'Minimalist tech wear. Complete your daily set with this soft pullover.',
                'stock' => 20,
                'is_featured' => false,
                'size_options' => 'XS,S,M,L,XL,XXL',
                'color_options' => 'Gray,Charcoal',
                'image_url' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&q=80'
            ],

            [
                'category_id' => $jacketsId,
                'name' => 'Zero-G Zip Jacket',
                'slug' => 'zero-g-zip-jacket',
                'price' => 129.99,
                'sale_price' => null,
                'description' => 'Defy gravity. Light as a feather but tough enough for the cold.',
                'stock' => 12,
                'is_featured' => true,
                'size_options' => 'S,M,L,XL,XXL',
                'color_options' => 'Black,Midnight Blue',
                'image_url' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=800&q=80'
            ],
            [
                'category_id' => $jacketsId,
                'name' => 'AeroShell Blue Jacket',
                'slug' => 'aeroshell-blue-jacket',
                'price' => 149.99,
                'sale_price' => 119.99,
                'description' => 'Hydrophobic technology. Let the rain slide right off your back.',
                'stock' => 6,
                'is_featured' => false,
                'size_options' => 'S,M,L,XL',
                'color_options' => 'Electric Blue',
                'image_url' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=800&q=80'
            ],
            [
                'category_id' => $jacketsId,
                'name' => 'Plasma Windbreaker',
                'slug' => 'plasma-windbreaker',
                'price' => 119.99,
                'sale_price' => null,
                'description' => 'Bright design to slice through the city environment.',
                'stock' => 9,
                'is_featured' => false,
                'size_options' => 'XS,S,M,L,XL,XXL',
                'color_options' => 'Black,Teal',
                'image_url' => 'https://images.unsplash.com/photo-1520975661595-6453be3f7070?w=800&q=80'
            ],

            [
                'category_id' => $sneakersId,
                'name' => 'Deepify Runner V1',
                'slug' => 'deepify-runner-v1',
                'price' => 179.99,
                'sale_price' => null,
                'description' => 'Walk on the moon. Ultimate cushion response for daily life.',
                'stock' => 10,
                'is_featured' => true,
                'size_options' => '38,39,40,41,42,43,44,45',
                'color_options' => 'Black/Neon,White/Blue',
                'image_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=800&q=80'
            ],
            [
                'category_id' => $sneakersId,
                'name' => 'HyperStep Mid',
                'slug' => 'hyperstep-mid',
                'price' => 159.99,
                'sale_price' => 139.99,
                'description' => 'Mid-rise ankle support for the active urban explorer.',
                'stock' => 7,
                'is_featured' => false,
                'size_options' => '38,39,40,41,42,43,44,45',
                'color_options' => 'Gray/Black,White',
                'image_url' => 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=800&q=80'
            ],
            [
                'category_id' => $sneakersId,
                'name' => 'Void Trainer',
                'slug' => 'void-trainer',
                'price' => 139.99,
                'sale_price' => null,
                'description' => 'All black. Stealth mode activated for your morning runs.',
                'stock' => 14,
                'is_featured' => false,
                'size_options' => '38,39,40,41,42,43,44,45',
                'color_options' => 'All Black,Dark Navy',
                'image_url' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=800&q=80'
            ],

            [
                'category_id' => $accessoriesId,
                'name' => 'Phase Cap',
                'slug' => 'phase-cap',
                'price' => 34.99,
                'sale_price' => null,
                'description' => 'Classic dad cap styled for the cyberpunk era.',
                'stock' => 30,
                'is_featured' => false,
                'size_options' => 'One Size',
                'color_options' => 'Black,White,Blue',
                'image_url' => 'https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=800&q=80'
            ],
            [
                'category_id' => $accessoriesId,
                'name' => 'Levitate Backpack',
                'slug' => 'levitate-backpack',
                'price' => 69.99,
                'sale_price' => 54.99,
                'description' => 'Waterproof bag engineered to hold all gear.',
                'stock' => 18,
                'is_featured' => false,
                'size_options' => 'One Size',
                'color_options' => 'Black,Charcoal',
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&q=80'
            ],
            [
                'category_id' => $accessoriesId,
                'name' => 'Neon Wristband Set',
                'slug' => 'neon-wristband-set',
                'price' => 19.99,
                'sale_price' => null,
                'description' => 'Reflective bands for safety and pure style aesthetics.',
                'stock' => 50,
                'is_featured' => false,
                'size_options' => 'S/M,L/XL',
                'color_options' => 'Neon Blue,Neon Teal,Black',
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&q=80'
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
