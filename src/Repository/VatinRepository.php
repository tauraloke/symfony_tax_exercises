<?php

namespace App\Repository;

class VatinRepository
{
    private const data = [  # just a stub without a real database
        'DE' => [
            'code' => 'DE',
            'country' => 'Germany',
            'tail_length' => 9,
            'tax_rate' => 19
        ],
        'IT' => [
            'code' => 'IT',
            'country' => 'Italy',
            'tail_length' => 11,
            'tax_rate' => 22
        ],
        'GR' => [
            'code' => 'GR',
            'country' => 'Greece',
            'tail_length' => 9,
            'tax_rate' => 24
        ],
    ];

    public static function getMetadata(): array
    {
        return self::data;
    }

    public static function getCodes(): array
    {
        return array_keys(self::data);
    }
}