<?php

namespace App\Model;

class Product {

    private int $id;
    private string $designation;
    private int $category_id;
    private int $stock_id;


    public function getId(): int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation)
    {
        $this->designation = $designation;

        return $this;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getStockId(): int
    {
        return $this->stock_id;
    }

    public function setStockId(int $stock_id)
    {
        $this->stock_id = $stock_id;

        return $this;
    }
}