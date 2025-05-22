<?php

namespace Database\Factories\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => 1,
            'url' => $this->faker->imageUrl(640, 480, 'products'),
            'is_main' => false,
        ];
    }
}
