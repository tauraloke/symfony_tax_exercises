<?php

namespace App\Validator;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class StartsFromCountryCode extends Constraint
{
    public $message = 'The string "{{ string }}" can only begin from country code like IT, GR, DE.';
    public string $mode;

    #[HasNamedArguments]
    public function __construct(string $mode, array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);
        $this->mode = $mode;
    }
}