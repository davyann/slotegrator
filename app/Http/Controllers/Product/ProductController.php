<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Product\ProductIndexRequest;
use App\Services\Product\Actions\ProductIndexAction;
use App\Services\Product\DTO\ProductIndexDTO;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends ApiController
{
    public function index(
        ProductIndexRequest $request,
        ProductIndexAction $productIndexAction
    ) : AnonymousResourceCollection
    {
        $dto = ProductIndexDto::fromRequest($request);

        return $productIndexAction->run($dto);
    }
}
