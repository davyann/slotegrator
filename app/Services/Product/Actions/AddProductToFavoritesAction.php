<?php

namespace App\Services\Product\Actions;

use App\Exceptions\Product\FailedAddProductToFavoritesException;
use App\Repositories\Product\ProductFavoriteRepositoryInterface;
use App\Services\Product\DTO\AddProductToFavoritesDTO;

class AddProductToFavoritesAction
{
    public function __construct(
        protected ProductFavoriteRepositoryInterface $repository
    ) {}

    public function run(AddProductToFavoritesDTO $dto): void
    {
        try {
            $this->repository->add($dto->userId, $dto->productId);
        } catch (\Throwable) {
            throw new FailedAddProductToFavoritesException();
        }
    }
}
