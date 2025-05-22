<?php

namespace Database\Seeders\Product;

use App\Models\Product\Product;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        Product::factory()
            ->count(50);

        $categoryIds = DB::table('categories')
            ->pluck('id')
            ->toArray();

        $productIds  = DB::table('products')
            ->pluck('id')
            ->toArray();

        foreach ($productIds as $productId) {
            $randomCategories = collect($categoryIds)->random(rand(1, 3));

            foreach ($randomCategories as $categoryId) {
                DB::table('product_category')->insert([
                    'category_id' => $categoryId,
                    'product_id' => $productId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        foreach ($productIds as $productId) {
            $imagesCount = rand(1, 4);
            for ($i = 0; $i < $imagesCount; $i++) {
                DB::table('product_images')->insert([
                    'product_id' => $productId,
                    'url' => $faker->imageUrl(640, 480, 'products'),
                    'is_main' => $i === 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
