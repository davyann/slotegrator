<?php

namespace App\Services\Product\Actions;

use App\Http\Resources\Product\ProductResource;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Product\DTO\ProductIndexDTO;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductIndexAction
{
    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {
    }

    public function run(ProductIndexDTO $dto): AnonymousResourceCollection
    {
        $products = $this->productRepository->list($dto, ['images', 'categories']);

        return ProductResource::collection($products);
    }
}
