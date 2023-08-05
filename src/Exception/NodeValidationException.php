<?php

namespace Liteapi\Openapi\Exception;

use Exception;
use Throwable;

class NodeValidationException extends Exception
{

    public function __construct(
        string $className,
        string $propertyName,
        string $message,
        ?Throwable $previous = null)
    {
        $message = sprintf("Property '%s' of node '%s' %s",
            $propertyName, $className, $message);
        parent::__construct($message, 0, $previous);
    }

}