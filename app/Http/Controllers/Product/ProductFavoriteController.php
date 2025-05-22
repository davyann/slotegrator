<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Product\AddProductToFavoritesRequest;
use App\Http\Requests\Product\ProductFavoriteIndexRequest;
use App\Services\Product\Actions\AddProductToFavoritesAction;
use App\Services\Product\Actions\ProductFavoriteIndexAction;
use App\Services\Product\DTO\AddProductToFavoritesDTO;
use App\Services\Product\DTO\ProductFavoriteIndexDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductFavoriteController extends ApiController
{
    public function store(
        AddProductToFavoritesRequest $request,
        AddProductToFavoritesAction $addProductToFavoritesAction
    ): JsonResponse {
        $dto = AddProductToFavoritesDTO::fromRequest($request);

        $addProductToFavoritesAction->run($dto);

        return $this->responseSuccess();
    }

    public function index(
        ProductFavoriteIndexRequest $request,
        ProductFavoriteIndexAction $productFavoriteIndexAction
    ): AnonymousResourceCollection {
        $dto = ProductFavoriteIndexDTO::fromRequest($request);

        return $productFavoriteIndexAction->run($dto);
    }
}
