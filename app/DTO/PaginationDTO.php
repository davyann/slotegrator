<?php

namespace App\DTO;

class PaginationDTO
{
    public function __construct(
        public int $page,
        public int $perPage
    ) {
    }
}
