<?php

namespace App\Repositories\Product;

use App\Models\Product\ProductFavorite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductFavoriteRepository implements ProductFavoriteRepositoryInterface
{
    public function query(): Builder
    {
        return ProductFavorite::query();
    }

    public function add(int $userId, int $productId): ProductFavorite
    {
        return $this->query()
            ->firstOrCreate([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);
    }

    public function exists(int $userId, int $productId): bool
    {
        return $this->query()
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }

    public function remove(int $userId, int $productId): bool
    {
        return $this->query()
            ->where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    public function getUserFavorites(int $userId): Collection
    {
        return $this->query()
            ->with('product')
            ->where('user_id', $userId)
            ->get();
    }
}
