<?php

namespace App\DTO;

class ListDTO
{
    public function __construct(
        public PaginationDTO $pagination,
        public ?string $query,
        public ?string $sort,
        public ?string $order,
    ) {
    }

}
