<?php

namespace Liteapi\Openapi\Element\Attribute;

use Attribute;
use Liteapi\Openapi\Element\Type\ValidationType;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Validation
{

    public function __construct(
        private readonly ValidationType $type,
        private readonly mixed          $pattern,
        private readonly string $message = ''
    )
    {
    }

    public function validate(mixed $value): void
    {
        $this->type->validate($value, $this->pattern, $this->message);
    }

}