<?php

namespace Repositories;

use Order;

interface OrderRepositoryInterface
{
    public function save(Order $order): void;

    public function load(): Order;

    public function update(Order $order): void;

    public function delete(Order $order): void;
}
