<?php

namespace App\Util;

use App\Repository\VatinRepository;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class VatinAnalyzer
{
    const COUNTRY_CODE_LENGTH = 2;

    public ?string $vatin;

    function __construct(string $vatin) {
        $this->vatin = $vatin;
    }

    public function getTail() {
        return substr($this->vatin, self::COUNTRY_CODE_LENGTH);
    }

    public function getCountryCode() {
        return substr($this->vatin, 0, self::COUNTRY_CODE_LENGTH);
    }

    public function getMetadata() {
        $country_code = $this->getCountryCode($this->vatin);
        $metadata = VatinRepository::getMetadata();
        if (empty($metadata[$country_code])) {
            throw new UnexpectedValueException($this->vatin, 'string');
        }
        return $metadata[$country_code];
    }

    public function isValidLength() {
        $data = $this->getMetadata();
        $tail = $this->getTail();
        if (empty($data['tail_length'])) {
            throw new UnexpectedValueException($this->vatin, 'string');
        }
        return $data['tail_length'] == strlen($tail);
    }
}