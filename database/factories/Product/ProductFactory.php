<?php

namespace Database\Factories\Product;

use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name =  $this->faker->words(3, true);

        return [
            'name'        => $name,
            'slug'        => strtolower($name),
            'description' => $this->faker->paragraph,
        ];
    }

    public function withCategories(int $count = 1): static
    {
        return $this->afterCreating(function (Product $product) use ($count) {
            $categories = Category::factory()->count($count)->create();
            $product->categories()->attach($categories->pluck('id'));
        });
    }

    public function withImages(int $count = 3): static
    {
        return $this->afterCreating(function (Product $product) use ($count) {
            ProductImage::factory()->count($count - 1)->create([
                'product_id' => $product->id,
                'is_main' => false,
            ]);

            ProductImage::factory()->create([
                'product_id' => $product->id,
                'is_main' => true,
            ]);
        });
    }
}
