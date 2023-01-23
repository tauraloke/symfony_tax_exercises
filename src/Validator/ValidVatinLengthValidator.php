<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use App\Repository\VatinMaskRepository;

class ValidVatinLengthValidator extends ConstraintValidator
{
    const COUNTRY_CODE_LENGTH = 2;

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof ValidVatinLength) {
            throw new UnexpectedTypeException($constraint, ValidVatinLength::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $country_code = substr($value, 0, self::COUNTRY_CODE_LENGTH);
        $tail = substr($value, self::COUNTRY_CODE_LENGTH);
        $valid = true;

        $country_mask_metadata = VatinMaskRepository::getMetadata();
        if (empty($country_mask_metadata[$country_code]['tail_length'])) {
            throw new UnexpectedValueException($value, 'string');
        }

        $length = $country_mask_metadata[$country_code]['tail_length'];
        if ($length != strlen($tail)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}