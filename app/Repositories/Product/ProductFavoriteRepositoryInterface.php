<?php

namespace App\Repositories\Product;

use App\Models\Product\ProductFavorite;
use Illuminate\Database\Eloquent\Collection;

interface ProductFavoriteRepositoryInterface
{
    public function add(int $userId, int $productId): ProductFavorite;

    public function exists(int $userId, int $productId): bool;

    public function remove(int $userId, int $productId): bool;
    public function getUserFavorites(int $userId): Collection;
}
