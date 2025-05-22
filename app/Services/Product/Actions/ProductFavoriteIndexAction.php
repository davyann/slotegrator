<?php

namespace App\Services\Product\Actions;

use App\Http\Resources\Product\ProductResource;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Product\DTO\ProductIndexDTO;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductFavoriteIndexAction
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    ) {
    }

    public function run(ProductIndexDTO $dto): AnonymousResourceCollection
    {
        $products = $this->productRepository->listFavorites($dto);

        return ProductResource::collection($products);
    }
}
