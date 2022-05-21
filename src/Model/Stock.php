<?php

namespace App\Model;

class Stock {

    private int $id;
    private int $quantity;
    

    public function getId(): int
    {
        return $this->id;
    }

    public function getQuantity():?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }
}