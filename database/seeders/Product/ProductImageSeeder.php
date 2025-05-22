<?php

namespace Database\Seeders\Product;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();
        $productIds = DB::table('products')->pluck('id')->toArray();

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
