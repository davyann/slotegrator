<?php

namespace Database\Seeders\Category;

use App\Models\Category\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()
            ->count(15);
    }
}
