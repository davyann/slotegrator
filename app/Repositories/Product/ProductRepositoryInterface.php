<?php

namespace App\Repositories\Product;

use App\Services\Product\DTO\ProductIndexDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function list(ProductIndexDTO $dto, array $relations = []): LengthAwarePaginator;

    public function listFavorites(ProductIndexDTO $dto, array $relations = []): LengthAwarePaginator;
}
