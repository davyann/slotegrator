<?php

use Repositories\OrderRepositoryInterface;
use Strategies\OrderStorageStrategyInterface;

class OrderService {
    private Order $order;
    private OrderRepositoryInterface $repository;

    public function __construct(OrderStorageStrategyInterface $storageStrategy) {
        $this->repository = $storageStrategy->getRepository();
        $this->order = $this->repository->load();
    }

    public function addItem(OrderItem $item): void {
        $this->order->addItem($item);
    }

    public function deleteItem(OrderItem $item): void {
        $this->order->deleteItem($item);
    }

    public function getItems(): array {
        return $this->order->getItems();
    }

    public function getItemsCount(): int {
        return $this->order->getItemsCount();
    }

    public function calculateTotalSum(): float {
        return $this->order->calculateTotalSum();
    }

    public function printOrder(): void {
        /*...*/
    }

    public function save(): void {
        $this->repository->save($this->order);
    }

    public function update(): void {
        $this->repository->update($this->order);
    }

    public function delete(): void {
        $this->repository->delete($this->order);
    }
}
