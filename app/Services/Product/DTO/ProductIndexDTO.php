<?php

namespace App\Services\Product\DTO;

use App\DTO\ListDTO;
use App\DTO\PaginationDTO;
use App\Http\Requests\Product\ProductIndexRequest;

class ProductIndexDTO extends ListDTO
{
    public function __construct(
        public ?string $category,
        public ?int $userId,
        PaginationDTO $pagination,
        ?string $query,
        ?string $sort,
        ?string $order,
    ) {
        parent::__construct($pagination, $query, $sort, $order);
    }

    public static function fromRequest(ProductIndexRequest $request): self
    {
        return new self(
            $request->getCategory(),
            $request->user()->id ?? null,
            new PaginationDTO($request->getPage(), $request->getPerPage()),
            $request->q(),
            $request->getSort(),
            $request->getOrder(),
        );
    }
}
