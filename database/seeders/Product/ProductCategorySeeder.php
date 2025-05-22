<?php

namespace Database\Seeders\Product;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = DB::table('categories')->pluck('id')->toArray();
        $productIds = DB::table('products')->pluck('id')->toArray();

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
    }
}
