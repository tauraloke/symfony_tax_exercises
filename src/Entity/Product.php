<?php

namespace App\Entity;

class Product
{
    private ?int $id;
    private ?string $title;
    private ?int $price;
    private ?string $currency = '€';

    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    public function setTitle(string $title): Product
    {
        $this->title = $title;
        return $this;
    }

    public function setPrice(int $price): Product
    {
        $this->price = $price;
        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
}