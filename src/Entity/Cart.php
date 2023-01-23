<?php

namespace App\Entity;

use App\Validator\StartsFromCountryCode;
use App\Validator\ValidVatinLength;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Cart
{
    protected $vatin; # EU TAX id number
    protected $cart;

    public function getVatin(): string
    {
        return $this->vatin;
    }

    public function setVatin(?string $vatin): void
    {
        $this->vatin = $vatin;
    }

    public function getCart(): ?array
    {
        return $this->cart;
    }

    public function setCart(?array $cart): void
    {
        $this->cart = $cart;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('vatin', new NotBlank());
        $metadata->addPropertyConstraint('vatin', new StartsFromCountryCode('loose'));
        $metadata->addPropertyConstraint('vatin', new ValidVatinLength('loose'));
        $metadata->addPropertyConstraint('cart', new NotBlank());
    }
}