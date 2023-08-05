<?php

namespace Liteapi\Openapi\Element\Type;

use Liteapi\Openapi\Exception\ValidationException;

enum ValidationType
{

    case Regex;


    public function validate(mixed $value, mixed $pattern, string $message): void
    {
        $result = match ($this) {
            self::Regex => preg_match($pattern, $value) === 1,
            default => throw new ValidationException('Unsupported validation mode')
        };
        if ($result === false) {
            throw new ValidationException(sprintf('Validation by %s on %s with pattern %s. %s',
                $this->name, var_export($value, true), var_export($pattern, true), $message));
        }
    }

}