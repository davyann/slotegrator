<?php

class Order {
    /** @var OrderItem[] */
    private array $items = [];

    public function addItem(OrderItem $item): void {
        $this->items[] = $item;
    }

    public function deleteItem(OrderItem $item): void {
        $this->items = array_filter($this->items, fn($i) => $i !== $item);
    }

    public function getItems(): array {
        return $this->items;
    }

    public function getItemsCount(): int {
        return count($this->items);
    }

    public function calculateTotalSum(): float {
        return array_reduce($this->items, fn($sum, $item) => $sum + $item->getTotal(), 0);
    }
}
