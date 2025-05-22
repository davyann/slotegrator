<?php

class OrderItem
{
    public function __construct(
        public string $name,
        public float $price,
        public int $quantity = 1
    ) {
    }

    public function getTotal(): float {
        return $this->price * $this->quantity;
    }
}
