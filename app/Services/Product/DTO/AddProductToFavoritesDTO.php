<?php

namespace App\Services\Product\DTO;

use App\Http\Requests\Product\AddProductToFavoritesRequest;

class AddProductToFavoritesDTO
{
    public int $userId;
    public int $productId;

    public function __construct(int $userId, int $productId)
    {
        $this->userId = $userId;
        $this->productId = $productId;
    }

    public static function fromRequest(AddProductToFavoritesRequest $request): self
    {
        return new self(
            $request->user()->id,
            $request->input('product_id')
        );
    }
}
