<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@deebify.com'],
            [
                'name'     => 'Deebify Admin',
                'email'    => 'admin@deebify.com',
                'password' => Hash::make('deebify90@125'),
                'role'     => 'admin',
            ]
        );
    }
}
