<?php

namespace Database\Seeders;

use Database\Seeders\Category\CategoriesSeeder;
use Database\Seeders\Product\ProductsSeeder;
use Database\Seeders\User\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategoriesSeeder::class,
            ProductsSeeder::class,
        ]);
    }
}
