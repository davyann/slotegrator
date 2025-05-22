<?php

namespace Database\Factories\Product;

use App\Models\Product\ProductFavorite;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFavoriteFactory extends Factory
{
    protected $model = ProductFavorite::class;

    public function definition(): array
    {
        return [
            'user_id'    => 1,
            'product_id' => 1,
        ];
    }
}

