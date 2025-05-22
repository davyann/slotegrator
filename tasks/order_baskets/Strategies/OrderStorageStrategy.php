<?php

namespace Strategies;

use Repositories\OrderRepository;
use Repositories\OrderRepositoryInterface;

class OrderStorageStrategy implements OrderStorageStrategyInterface
{
    public function getRepository(): OrderRepositoryInterface
    {
        return new OrderRepository();
    }
}
