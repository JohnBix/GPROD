<?php

namespace App\Model;

class Category {

    private int $id;
    private string $name;

    
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name)
    {
        $this->name = $name;

        return $this;
    }
}