<?php

namespace App\Repository;

use App\Entity\Product;

class ProductRepository
{
    /**
     * @return Product[]
    */
    public static function getAll(): array
    {
        return [ # just stub database
            (new Product())->setId(1)->setTitle('headphones')->setPrice(100),
            (new Product())->setId(2)->setTitle('phonecase')->setPrice(20),
        ];
    }
}