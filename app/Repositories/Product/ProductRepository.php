<?php

namespace App\Repositories\Product;

use App\Models\Product\Product;
use App\Services\Product\DTO\ProductFavoriteIndexDTO;
use App\Services\Product\DTO\ProductIndexDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function query(): Builder
    {
        return Product::query();
    }

    public function list(ProductIndexDTO $dto, array $relations = []): LengthAwarePaginator
    {
        $query = $this->buildFilteredAndSortedQuery($dto, $this->query(), $relations);

        return $query->paginate($dto->pagination->perPage);
    }

    public function listFavorites(ProductIndexDTO $dto, array $relations = []): LengthAwarePaginator
    {
        $query = $this->query()
            ->whereHas('favorites', fn($q) => $q->where('user_id', $dto->userId));

        $query = $this->buildFilteredAndSortedQuery($dto, $query, $relations);

        return $query->paginate($dto->pagination->perPage);
    }

    protected function buildFilteredAndSortedQuery(
        ProductIndexDTO $dto,
        Builder $query,
        array $relations = []
    ): Builder {
        $userId = auth()->id();

        $query->when($dto->query, fn($q) =>
            $q->where('products.name', 'like', "%{$dto->query}%")
        );

        $query->when($dto->category, fn($q) =>
             $q->whereHas('categories', fn($q) =>
                $q->where('categories.slug', $dto->category)
        )
        );

        $query->when($dto->sort, fn($q) =>
            $q->orderBy($dto->sort, $dto->order)
        );

        $query->withExists([
            'favorites as is_favorite' => fn($q) => $q->where('user_id', $userId),
        ]);

        return $query->with($relations);
    }
}
