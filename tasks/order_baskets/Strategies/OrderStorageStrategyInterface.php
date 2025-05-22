<?php

namespace Strategies;

use Repositories\OrderRepositoryInterface;

interface OrderStorageStrategyInterface
{
    public function getRepository(): OrderRepositoryInterface;
}
