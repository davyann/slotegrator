<?php

namespace Database\Factories\Category;

use App\Models\Category\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->name;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
